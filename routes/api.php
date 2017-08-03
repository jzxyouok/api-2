<?php
/*
use Illuminate\Http\Request;
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

use Illuminate\Support\Facades\Storage;

Route::post('/login', 'Api\LoginController@login');
Route::post('/logout', 'Api\LoginController@logout');

Route::post('/upload', function (\Illuminate\Http\Request $request) {
    if ($request->hasFile('file')) {
        return $request->file('file')->store('avatars');
    }
    return response('file does not exist', 502);
});

Route::delete('/file/del', function (\Illuminate\Http\Request $request) {
    $fileUrl = $request->get('fileUrl');
    if (Storage::exists($fileUrl)) {
        return Storage::delete($fileUrl) ? 'file delete success' : response('file delete fail', 502);
    }
    return response('parameter is incorrect or file does not exist', 502);
});