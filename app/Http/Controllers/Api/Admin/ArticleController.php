<?php

namespace App\Http\Controllers\Api\Admin;

use App\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        return Article::where(function ($query) use ($request) {
            if ($request->has('title')) {
                $query->where('title', 'like', '%' . $request->title . '%');
            }
        })->paginate($request->per_page);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        Validator::make($data, [
            'category_id' => 'integer|exists:category,id',
            'title' => 'required|unique:article|max:50',
            'keywords' => 'nullable|max:80',
            'description' => 'nullable|max:255',
            'is_show' => 'in:T,F',
            'content' => 'required',
        ], [], $this->attributes())->validate();

        $article = Article::create($data);
        $article->articleData()->create($data);

        return $article;
    }

    public function show(Article $article)
    {
        $article->load('articleData');
        return $article;
    }

    public function update(Request $request, Article $article)
    {
        $data = $request->all();
        Validator::make($data, [
            'category_id' => 'integer|exists:category,id',
            'title' => ['required', 'max:50', 'unique:article', Rule::unique('article')->ignore($article->id)],
            'keywords' => 'nullable|max:80',
            'description' => 'nullable|max:255',
            'is_show' => 'in:T,F',
        ], [], $this->attributes())->validate();

        if ($request->has('content')) {
            $article->articleData()->update($data);
        }

        $article->update($data);
        return $article;
    }

    public function destroy(Article $article)
    {
        return $article->delete() ? 'success' : response('delete article fail', 422);
    }

    protected function attributes()
    {
        return [
            'category_id' => '所属栏目',
            'keywords' => '关键词',
        ];
    }
}
