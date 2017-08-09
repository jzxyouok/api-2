<?php

namespace App\Http\Controllers\Api\Admin;

use App\Menu;
use App\Tools\PHPTree;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

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
        return ['isAjax' => $request->isJson()];

        Validator::make($request->all(), [
            'parent_id' => 'integer',
            'title' => 'required|unique:menus|max:50',
            'sort' => 'integer',
            'is_show' => 'in:T,F',
        ])->validate();

        return Menu::create($request->all());
    }


    public function show(Menu $menu)
    {
        //
    }


    public function update(Request $request, Menu $menu)
    {
        //
    }


    public function destroy(Menu $menu)
    {
        //
    }
}
