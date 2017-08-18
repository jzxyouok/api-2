<?php

namespace App\Http\Controllers\Api\Admin;

use App\Attachment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AttachmentController extends Controller
{

    public function index(Request $request)
    {
        return Attachment::where(function ($query) use ($request) {
            if ($request->has('dir_id')) {
                $query->where('dir_id', $request->dir_id);
            }
            if ($request->has('user_id')) {
                $query->where('user_id', $request->user_id);
            }
            if ($request->has('title')) {
                $query->where('title', 'like', '%' . $request->title . '%');
            }
            if ($request->has('is_img')) {
                $query->where('is_img', $request->is_img);
            }
            if ($request->has('disk')) {
                $query->where('disk', $request->disk);
            }
        })->latest()->paginate($request->pageSize);
    }


    public function store(Request $request)
    {
        $arr = $request->all();
        Validator::make($arr, [
            'dir_id' => 'required|integer|exists:attdirs,id',
            'is_image' => 'required|in:T,F',
            'disk' => 'in:public,local',
            'file' => 'required|file',
        ], [], $this->attributes())->validate();

        $disk = $request->get('disk', 'public');
        $file = $request->file('file');
        $path = $file->store(date('Ymd'), $disk);

        $data = array_merge($arr, [
            'user_id' => $request->user()->id,
            'name' => $file->getClientOriginalName(),
            'file_size' => $file->getSize(),
            'path' => $path,
            'url' => Storage::disk($disk)->url($path),
            'disk' => $disk
        ]);
        return Attachment::create($data);
    }

    public function destroy(Request $request)
    {
        Validator::make($request->only('ids'), [
            'ids' => 'required|array',
        ], [], $this->attributes())->validate();

        $atts = Attachment::find($request->get('ids'));

        foreach ($atts as $att) {
            if (Storage::disk($att->disk)->exists($att->path)) {
                Storage::disk($att->disk)->delete($att->path);
            }
            $att->delete();
        }

        return 'delete success';
    }

    protected function attributes()
    {
        return [
            'dir_id' => '目录', 'is_image' => '是否图片', 'disk' => '磁盘', 'ids' => '附件ID集合'
        ];
    }

}
