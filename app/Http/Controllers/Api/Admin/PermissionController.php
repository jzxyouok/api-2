<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use jeremykenedy\LaravelRoles\Models\Permission;

class PermissionController extends Controller
{

    public function index(Request $request)
    {
        return Permission::where(function ($query) use ($request) {
            if ($request->has('slug')) {
                $query->where('slug', 'like', '%' . $request->slug . '%');
            }
        })->get();
    }

    public function store(Request $request)
    {
        $data = $request->all();
        Validator::make($data, [
            'name' => 'required|unique:permissions|max:50',
            'slug' => 'required|unique:permissions|max:150',
            'description' => 'nullable|max:150',
            'model' => 'nullable|max:50',
        ], [], $this->attributes())->validate();

        return Role::create($data);
    }

    public function update(Request $request, Permission $permission)
    {
        $data = $request->all();
        Validator::make($data, [
            'name' => ['required_without_all:slug,description,model', 'max:150', Rule::unique('permissions')->ignore($permission->id)],
            'slug' => ['max:150', Rule::unique('permissions')->ignore($permission->id)],
            'description' => 'nullable|max:150',
            'model' => 'nullable|max:50',
        ], [], $this->attributes())->validate();

        $permission->update($data);
        return $permission;
    }

    public function destroy(Permission $permission)
    {
        return $permission->delete() ? 'success' : response('delete permission fail', 422);
    }

    protected function attributes()
    {
        return [
            'slug' => '检测词', 'model' => '模型'
        ];
    }

}
