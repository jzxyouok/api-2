<?php

namespace App\Http\Controllers\Api\Admin;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use jeremykenedy\LaravelRoles\Models\Role;

class UserController extends Controller
{

    public function index(Request $request)
    {
        return User::with('roles')->where(function ($query) use ($request) {
            if ($request->has('keyword')) {
                $keyword = $request->get('keyword');
                $query->where('name', 'like', '%' . $keyword . '%')->orWhere('email', 'like', '%' . $keyword . '%');
            }
        })->paginate($request->per_page);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        Validator::make($data, [
            'name' => 'required|unique:users|between:3,15',
            'email' => 'required|email|unique:users|between:6,30',
            'password' => 'between:6,15',
            'disable' => 'in:T,F',
            'avatar' => 'nullable|between:6,255',
            'roles' => 'array',
        ], [], $this->attributes())->validate();

        if ($request->has('disable')) {
            $data['disable_at'] = $data['disable'] === 'T' ? Carbon::now() : null;
        }

        $data['api_token'] = str_random(60);
        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);

        if ($request->has('roles')) {
            $roles = Role::find($request->get('roles'));

            $user->syncRoles($roles);
        }

        return $user;
    }

    public function update(Request $request, User $user)
    {
        $data = $request->except('disable_at', 'api_token');
        Validator::make($data, [
            'name' => ['required_without_all:email,disable,avatar', 'between:3,15', Rule::unique('users')->ignore($user->id)],
            'email' => ['email', 'between:6,30', Rule::unique('users')->ignore($user->id)],
            'disable' => 'in:T,F',
            'avatar' => 'nullable|between:6,255',
        ], [], $this->attributes())->validate();

        if ($request->has('disable')) {
            $data['disable_at'] = $data['disable'] === 'T' ? Carbon::now() : null;
        }

        $user->update($data);
        return $user;
    }

    public function resetPassword(User $user)
    {
        $pwd = str_random(6);
        $user->password = bcrypt($pwd);
        $user->save();
        return $pwd;
    }

    public function destroy(User $user)
    {
        return $user->delete() ? 'success' : response('delete user fail', 422);
    }

    /**
     * @desc 更新个人信息
     * @param Request $request
     * @return mixed
     */
    public function updateMyInfo(Request $request)
    {
        Validator::make($request->all(), [
            'oldPassword' => 'required_with:newPassword|between:6,30',
            'newPassword' => 'between:6,30',
            'avatar' => 'image',
        ], [], $this->attributes())->validate();

        $user = $request->user();

        if ($request->has('newPassword')) {
            if (!Hash::check($request->oldPassword, $user->password)) {
                return response('旧密码输入错误。', 422);
            }
            if (Hash::check($request->newPassword, $user->password)) {
                return response('旧密码与新密码相同。', 422);
            }

            $user->password = bcrypt($request->newPassword);
        }

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $path = $file->storeAs('avatars', $user->id . '.' . $file->getClientOriginalExtension(), ['disk' => 'public']);
            $user->avatar = Storage::disk('public')->url($path);
        }

        $user->save();
        return $user;
    }

    /**
     * 当前用户的角色
     * @param Request $request
     * @return mixed
     */
    public function myRoles(Request $request)
    {
        return $request->user()->roles;
    }

    /**
     * @desc 同步用户角色
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function syncRoles(Request $request, User $user)
    {
        Validator::make($request->all(), [
            'roles' => 'array',
        ])->validate();
        $roles = Role::find($request->get('roles'));
        $user->syncRoles($roles);
        return $user->roles;
    }

    protected function attributes()
    {
        return [
            'disable' => '状态', 'avatar' => '头像', 'roles' => '角色组', 'oldPassword' => '旧密码', 'newPassword' => '新密码'
        ];
    }
}
