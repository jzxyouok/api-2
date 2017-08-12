<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use jeremykenedy\LaravelRoles\Models\Permission;
use jeremykenedy\LaravelRoles\Models\Role;

class RoleController extends Controller
{

    public function index(Request $request)
    {
        return Role::where(function ($query) use ($request) {
            if ($request->has('slug')) {
                $query->where('slug', 'like', '%' . $request->slug . '%');
            }
        })->get();
    }

    public function store(Request $request)
    {
        $data = $request->all();
        Validator::make($data, [
            'name' => 'required|unique:roles|max:50',
            'slug' => 'required|unique:roles|max:150',
            'description' => 'nullable|max:150',
            'level' => 'integer',
        ], [], $this->attributes())->validate();

        return Role::create($data);
    }

    public function rolePermissions(Role $role)
    {
        return $role->permissions;
    }

    public function update(Request $request, Role $role)
    {
        $data = $request->all();
        Validator::make($data, [
            'name' => ['required_without_all:slug,description,level', 'max:150', Rule::unique('roles')->ignore($role->id)],
            'slug' => 'unique:roles|max:150',
            'description' => 'nullable|max:150',
            'level' => 'integer',
        ], [], $this->attributes())->validate();

        $role->update($data);
        return $role;
    }

    public function destroy(Role $role)
    {
        return $role->delete() ? 'success' : response('delete role fail', 422);
    }

    public function syncPermissions(Request $request, Role $role)
    {
        Validator::make($request->all(), [
            'permissions' => 'array',
        ])->validate();

        $permissions = Permission::find($request->get('permissions'));

        $role->syncPermissions($permissions);
        return $role->permissions;
    }

    public function permissionList()
    {
        return Permission::all();
    }

    protected function attributes()
    {
        return [
            'slug' => '检测词', 'level' => '层级'
        ];
    }
}
