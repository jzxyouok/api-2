<?php
/*
use Illuminate\Http\Request;
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::any('/login', 'Api\LoginController@login');
Route::post('/logout', 'Api\LoginController@logout');
