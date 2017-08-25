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
        return Article::with('user')->where(function ($query) use ($request) {
            if ($request->has('title')) {
                $query->where('title', 'like', '%' . $request->title . '%');
            }
            if ($request->has('category_id')) {
                $query->where('category_id', $request->category_id);
            }
        })->paginate($request->per_page);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        Validator::make($data, [
            'category_id' => 'required|integer|exists:category,id',
            'title' => 'required|max:150',
            'keywords' => 'nullable|max:180',
            'description' => 'nullable|max:255',
            'article_data.content' => 'required',
        ], [], $this->attributes())->validate();

        $data = array_merge($data, ['user_id' => $request->user()->id]);
        $article = Article::create($data);
        $arr = $request->get('article_data');
        $article->articleData()->create($arr);

        return $article->load('articleData');
    }

    public function show(Article $article)
    {
        return $article->load('articleData');
    }

    public function update(Request $request, Article $article)
    {
        $data = $request->all();
        Validator::make($data, [
            'category_id' => 'integer|exists:category,id',
            'title' => 'required|max:150',
            'keywords' => 'nullable|max:180',
            'description' => 'nullable|max:255',
            'article_data.content' => 'required',
        ], [], $this->attributes())->validate();

        $arr = $request->get('article_data');
        $article->articleData()->{$article->articleData ? 'update' : 'create'}($arr);

        $article->update($data);
        return $article->load('articleData');
    }

    public function destroy(Request $request)
    {
        Validator::make($request->all(), [
            'ids' => 'required|array',
        ], [], $this->attributes())->validate();

        return Article::destroy($request->ids) ? 'success' : response('delete article fail', 422);
    }

    protected function attributes()
    {
        return [
            'category_id' => '所属栏目',
            'keywords' => '关键词',
            'ids' => '文章ID集合',
        ];
    }
}
