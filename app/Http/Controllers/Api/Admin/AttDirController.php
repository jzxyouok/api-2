<?php

namespace App\Http\Controllers\Api\Admin;

use App\AttDir;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AttDirController extends Controller
{

    public function index(Request $request)
    {
        return AttDir::with('allChildren')->where(['parent_id' => 0])->get();
    }

    public function store(Request $request)
    {
        $data = $request->all();
        Validator::make($data, [
            'title' => 'required|between:2,15',
            'parent_id' => 'integer',
        ], [], $this->attributes())->validate();


        return AttDir::create($data);
    }

    public function update(Request $request, AttDir $attDir)
    {
        $data = $request->all();
        Validator::make($data, [
            'title' => 'required_without_all:parent_id|between:2,15',
            'parent_id' => 'integer',
        ], [], $this->attributes())->validate();

        $attDir->update($data);
        return $attDir;
    }

    public function destroy(AttDir $attDir)
    {
        if (count($attDir->children)) {
            return response('必须先删除子文件夹。', 422);
        }
        // 删除附件
        foreach ($attDir->attachments as $att) {
            if (Storage::disk($att->disk)->exists($att->path)) {
                Storage::disk($att->disk)->delete($att->path);
            }
            $att->delete();
        }
        return $attDir->delete() ? 'success' : response('delete folder fail', 422);
    }

    protected function attributes()
    {
        return [
            'parent_id' => '上级文件夹'
        ];
    }
}
