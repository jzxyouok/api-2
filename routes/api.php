<?php
/*
use Illuminate\Http\Request;
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

//use Illuminate\Support\Facades\Storage;

Route::group(['namespace' => 'Api\Admin', 'prefix' => 'admin'], function () {
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout');

    // 登录保护
    Route::group(['middleware' => ['auth:api']], function () {
        Route::get('sysInfo', 'InfoController');

        Route::get('menu', 'MenuController@index');
        Route::post('menu', 'MenuController@store');
        Route::delete('menu/{menu}', 'MenuController@destroy');
        Route::patch('menu/{menu}', 'MenuController@update');
        Route::get('menu/{menu}', 'MenuController@show');

        Route::get('role', 'RoleController@index');
        Route::post('role', 'RoleController@store');
        Route::delete('role/{role}', 'RoleController@destroy');
        Route::patch('role/{role}', 'RoleController@update');
        Route::get('role/{role}', 'RoleController@show');

        Route::get('user', 'UserController@index');
        Route::post('user', 'UserController@store');
        Route::delete('user/{user}', 'UserController@destroy');
        Route::patch('user/{user}', 'UserController@update');
        Route::get('user/{user}', 'UserController@show');

        Route::patch('user/update/myInfo', 'UserController@updateMyInfo');

        Route::patch('user/syncRoles/{user}', 'UserController@syncRoles');
    });
});

/*Route::post('upload', function (\Illuminate\Http\Request $request) {
    if ($request->hasFile('file')) {
        $disk = 'public';
        $path = $request->file('file')->store('avatars', $disk);
        return ['url' => Storage::url($path), 'path' => $path, 'disk' => $disk];
    }
    return response('file does not exist', 502);
});

Route::delete('file/del', function (\Illuminate\Http\Request $request) {
    $fileUrl = $request->get('fileUrl');
    $disk = $request->get('disk', 'public');
    if (Storage::disk($disk)->exists($fileUrl)) {
        return Storage::disk($disk)->delete($fileUrl) ? 'file delete success' : response('file delete fail', 502);
    }
    return response('file does not exist', 502);
});*/