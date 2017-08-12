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

        // 登录用户可查看的，不需要权限控制
        Route::get('sysInfo', 'InfoController');
        Route::patch('user/update/myInfo', 'UserController@updateMyInfo');

        Route::get('role', 'RoleController@index')->middleware('permission:all.role');
        Route::post('role', 'RoleController@store')->middleware('permission:all.role');
        Route::delete('role/{role}', 'RoleController@destroy')->middleware('permission:all.role');
        Route::patch('role/{role}', 'RoleController@update')->middleware('permission:all.role');
        Route::get('role/permissions/{role}', 'RoleController@rolePermissions')->middleware('permission:all.role');
        Route::patch('role/syncPermissions/{role}', 'RoleController@syncPermissions')->middleware('permission:all.role');

        Route::get('permission', 'PermissionController@index')->middleware('permission:all.permission');
        Route::post('permission', 'PermissionController@store')->middleware('permission:all.permission');
        Route::delete('permission/{permission}', 'PermissionController@destroy')->middleware('permission:all.permission');
        Route::patch('permission/{permission}', 'PermissionController@update')->middleware('permission:all.permission');

        Route::get('user', 'UserController@index')->middleware('permission:all.user');
        Route::post('user', 'UserController@store')->middleware('permission:all.user');
        Route::delete('user/{user}', 'UserController@destroy')->middleware('permission:all.user');
        Route::patch('user/{user}', 'UserController@update')->middleware('permission:all.user');
        Route::patch('user/syncRoles/{user}', 'UserController@syncRoles')->middleware('permission:all.user');
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