<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class ThumbController extends Controller
{

    public function __invoke(Request $request, $width, $height = null)
    {
        $validator = Validator::make($request->all(), ['url' => 'required|url']);
        if ($validator->fails()) {
            $image = Image::canvas(240, 240, '#DDD')->text('参数错误', 60, 120, function ($font) {
                $font->file('fonts/msyh.ttc')->size(32)->color('#666666');
            });
            return $image->response();
        }
        $url = $request->url;
        $image = Image::cache(function ($image) use ($url, $width, $height) {
            $image->make($url)->fit($width, $height);
        }, 1, true);
        return $image->response();
    }
}
