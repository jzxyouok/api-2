<?php

namespace App\Http\Controllers\Api\Admin;

use App\Mdd;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MddController extends Controller
{

    public function index(Request $request)
    {
        return Mdd::where(function ($query) use ($request) {
            if ($request->has('title')) {
                $query->where('title', 'like', '%' . $request->title . '%');
            }
        })->paginate($request->per_page);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        Validator::make($data, [
            'cascader' => 'required|array',
            'title' => 'required|between:2,50|unique:mdd',
            'thumb' => 'nullable|max:255',
            'description' => 'nullable|max:255',
            'is_show' => 'boolean',
        ], [], $this->attributes())->validate();

        $data['loc_id'] = array_last($request->cascader);

        return Mdd::create($data);
    }

    public function update(Request $request, Mdd $mdd)
    {
        $data = $request->all();
        Validator::make($data, [
            'cascader' => 'array',
            'title' => ['between:2,50', Rule::unique('mdd')->ignore($mdd->id)],
            'thumb' => 'nullable|max:255',
            'description' => 'nullable|max:255',
            'is_show' => 'boolean',
        ], [], $this->attributes())->validate();

        if ($request->has('cascader')) {
            $data['loc_id'] = array_last($request->cascader);
        }

        $mdd->update($data);
        return $mdd;
    }

    public function destroy(Mdd $mdd)
    {
        return $mdd->delete() ? 'success' : response('delete fail', 422);
    }

    protected function attributes()
    {
        return [
            'loc_id' => '地理位置',
            'thumb' => '图片',
            'is_show' => '状态',
            'cascader' => '级联',
        ];
    }
}
