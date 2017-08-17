<?php

//Auth::routes();

Route::get('/thumb/{width}/{height?}', 'ThumbController')->where(['width' => '[0-9]+', 'height' => '[0-9]+']);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');
