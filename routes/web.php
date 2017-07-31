<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('/example', function () {
    return view('example');
});
