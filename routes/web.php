<?php

Route::get('/thumb', 'ThumbController');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/example', function () {
    return view('example');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
