<?php

namespace App\Http\Controllers\Api\Admin;

use App\Menu;
use App\Tools\PHPTree;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MenuController extends Controller
{

    public function index(Request $request)
    {
        $menus = Menu::where(function ($query) use ($request) {
            $request->keyword ? $query->where('title', 'like', '%' . $request->keyword . '%') : null;
        })->orderBy('sort')->get();
        if ($menus) {
            $menus = PHPTree::makeTree($menus->toArray());
        }
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
        ], [], $this->attributes())->validate();

        return Menu::create($data);
    }


    public function show(Menu $menu)
    {
        return $menu;
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
        ], [], $this->attributes())->validate();
        return $menu->update($data) ? 'success' : response('fail', 422);
    }


    public function destroy(Menu $menu)
    {
        return $menu->delete() ? 'success' : response('fail', 422);
    }

    protected function attributes()
    {
        return ['parent_id' => '上级节点', 'path' => '路由地址', 'component' => '组件', 'sort' => '排序', 'is_show' => '是否显示'];
    }
}
