<?php

namespace App\Http\Controllers\Api\Admin;

use App\AttDir;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AttDirController extends Controller
{

    public function index(Request $request)
    {
        return AttDir::with('allChildren')->where(['is_sys' => 'F', 'parent_id' => 0])->get();
    }

    public function store(Request $request)
    {
        $data = $request->except('is_sys');
        Validator::make($data, [
            'title' => 'required|between:3,15',
            'parent_id' => 'integer',
        ], [], $this->attributes())->validate();

        return AttDir::create($data);
    }

    public function update(Request $request, AttDir $attDir)
    {
        $data = $request->except('is_sys');
        Validator::make($data, [
            'title' => 'required_without_all:parent_id|between:3,15',
            'parent_id' => 'integer',
        ], [], $this->attributes())->validate();

        return AttDir::update($data);
    }

    public function destroy(AttDir $attDir)
    {
        if (count($attDir->children())) {
            return response('必须先删除子文件夹', 422);
        }
        return $attDir->delete() ? 'success' : response('delete folder fail', 422);
    }

    protected function attributes()
    {
        return [
            'parent_id' => '上级文件夹', 'is_sys' => '是否系统创建'
        ];
    }
}
