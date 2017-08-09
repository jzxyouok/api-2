<?php

//Auth::routes();

Route::get('/thumb', 'ThumbController');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');
