<?php

namespace App\Http\Controllers\Api\Admin;

use App\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MenuController extends Controller
{

    public function index(Request $request)
    {
        $menus = Menu::with('allChildren')->where(function ($query) use ($request) {
            $request->title ? $query->where('title', 'like', '%' . $request->title . '%') : null;
        })->where('parent_id', 0)->orderBy('sort')->get();
        return $menus;
    }

    public function store(Request $request)
    {
        $data = $request->all();
        Validator::make($data, [
            'parent_id' => 'integer',
            'title' => 'required|unique:menus|max:50',
            'path' => 'required|unique:menus|max:150',
            'component' => 'required|max:150',
            'sort' => 'integer',
            'is_show' => 'in:T,F',
        ])->validate();

        return Menu::create($data);
    }

    public function show(Menu $menu)
    {
        return Menu::with('roles')->find($menu->id);
    }

    public function update(Request $request, Menu $menu)
    {
        $data = $request->all();
        Validator::make($data, [
            'parent_id' => 'integer',
            'title' => ['required_without_all:parent_id,path,component,sort,is_show', 'max:50', Rule::unique('menus')->ignore($menu->id)],
            'path' => ['max:150', Rule::unique('menus')->ignore($menu->id)],
            'component' => 'max:150',
            'sort' => 'integer',
            'is_show' => 'in:T,F',
        ])->validate();

        $menu->update($data);
        return $menu;
    }

    public function destroy(Menu $menu)
    {
        $children = $menu->children;
        if (!!count($children)) {
            return response(['children' => $children], 422);
        }
        return $menu->delete() ? 'success' : response('delete menu fail', 422);
    }

}
