<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class ThumbController extends Controller
{

    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), ['url' => 'required', 'w' => 'required|integer|between:1,5000', 'h' => 'nullable|integer|between:1,5000', 'disk' => 'nullable|in:local,public']);
        if ($validator->fails()) {
            $image = Image::canvas(240, 240, '#DDD')->text('参数错误', 60, 120, function ($font) {
                $font->file('fonts/msyh.ttc')->size(32)->color('#666666');
            });
            return $image->response();
        }
        $disk = $request->get('disk', 'public');
        if (!Storage::disk($disk)->exists($request->url)) {
            $image = Image::canvas(240, 240, '#DDD')->text('图片不存在', 45, 120, function ($font) {
                $font->file('fonts/msyh.ttc')->size(32)->color('#666666');
            });
            return $image->response();
        }

        $image = Image::cache(function ($image) use ($request, $disk) {
            $image->make(Storage::disk($disk)->get($request->url))->fit($request->w, $request->h);
        }, 1, true);
        return $image->response();
    }
}
