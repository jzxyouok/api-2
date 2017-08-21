<?php

namespace App\Http\Controllers\Api\Admin;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{

    public function index()
    {
        return Category::with('allChildren')->where(['parent_id' => 0])->get();
    }

    public function store(Request $request)
    {
        $data = $request->all();
        Validator::make($data, [
            'parent_id' => 'integer',
            'title' => 'required|unique:category|between:2,50',
            'seo_title' => 'nullable|max:80',
            'seo_keywords' => 'nullable|max:100',
            'seo_description' => 'nullable|max:255',
            'is_show' => 'in:T,F',
        ], [], $this->attributes())->validate();

        return Category::create($data);
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->all();
        Validator::make($data, [
            'parent_id' => 'integer',
            'title' => ['between:2,50', Rule::unique('category')->ignore($category->id)],
            'seo_title' => 'nullable|max:80',
            'seo_keywords' => 'nullable|max:100',
            'seo_description' => 'nullable|max:255',
            'is_show' => 'in:T,F',
        ], [], $this->attributes())->validate();

        $category->update($data);
        return $category;
    }

    public function destroy(Category $category)
    {
        if (count($category->children)) {
            return response('必须先删除子栏目。', 422);
        }
        $category->delete();
        return $category->delete() ? 'success' : response('delete category fail', 422);
    }

    protected function attributes()
    {
        return [
            'parent_id' => '上级栏目',
            'seo_title' => 'SEO 标题',
            'seo_keywords' => 'SEO 关键词',
            'seo_description' => 'SEO 简介',
            'is_show' => '显示状态',
        ];
    }
}
