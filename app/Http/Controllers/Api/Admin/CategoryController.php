<?php

namespace App\Http\Controllers\Api\Admin;

use App\Category;
use App\Tools\PHPTree;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        $categorys = Category::withCount('article')->where(function ($query) use ($request) {
            if ($request->has('title')) {
                $query->where('title', 'like', '%' . $request->title . '%');
            }
        })->get();

        return count($categorys) ? PHPTree::makeTreeForHtml($categorys) : $categorys;
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
            'is_show' => 'boolean',
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
            'is_show' => 'boolean',
        ], [], $this->attributes())->validate();

        $category->update($data);
        return $category;
    }

    public function destroy(Category $category)
    {
        if (Category::where('parent_id', $category->id)->count()) {
            return response('必须先删除子栏目。', 422);
        }
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
