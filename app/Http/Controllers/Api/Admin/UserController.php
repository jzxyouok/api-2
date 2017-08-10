<?php

namespace App\Http\Controllers\Api\Admin;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function index()
    {
        return User::all();
    }

    public function store(Request $request)
    {
        $data = $request->all();
        Validator::make($data, [
            'name' => 'required|unique:users|between:3,15',
            'email' => 'required|email|unique:users,between:6,30',
            'password' => 'required|between:6,15',
            'avatar' => 'between:6,255',
        ])->validate();
        $arr = array_merge($data, ['api_token' => str_random(60), 'password' => bcrypt($data['password'])]);
        return User::create($arr);
    }

    public function show(User $user)
    {
        return $user;
    }

    public function update(Request $request, User $user)
    {
        $data = $request->except('password', 'disable_at');
        Validator::make($data, [
            'name' => ['required_without_all:email,password,disable,avatar', 'between:3,15', Rule::unique('users')->ignore($user->id)],
            'email' => ['email', 'between:6,30', Rule::unique('users')->ignore($user->id)],
            'disable' => 'in:T,F',
            'avatar' => 'between:6,255',
        ])->validate();

        if ($request->has('disable')) {
            $data['disable_at'] = $data['disable'] === 'T' ? Carbon::now() : null;
        }

        $user->update($data);
        return $user;
    }

    public function destroy(User $user)
    {
        return $user->delete() ? 'success' : response('delete user fail', 422);
    }

    public function updateMyInfo(Request $request)
    {
        $user = $request->user();
        $data = $request->intersect('avatar', 'password');

        if ($request->has('password')) {
            $data['password'] = bcrypt($data['password']);
        }

        $user->update($data);
        return $user;
    }
}
