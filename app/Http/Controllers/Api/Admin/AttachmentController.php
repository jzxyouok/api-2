<?php

namespace App\Http\Controllers\Api\Admin;

use App\Attachment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        })->paginate($request->pageSize);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Attachment $attachment)
    {
        //
    }

    public function edit(Attachment $attachment)
    {
        //
    }

    public function update(Request $request, Attachment $attachment)
    {
        //
    }

    public function destroy(Attachment $attachment)
    {
        //
    }
}
