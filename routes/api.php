<?php

Route::group(['namespace' => 'Api\Admin', 'prefix' => 'admin'], function () {
    Route::post('login', 'LoginController@login');

    // 登录保护
    Route::group(['middleware' => ['auth:api']], function () {

        // 登录用户可查看的，不需要权限控制
        Route::post('logout', 'LoginController@logout');
        Route::get('sysInfo', 'InfoController');
        Route::patch('user/update/myInfo', 'UserController@updateMyInfo');
        Route::get('user/myRoles', 'UserController@myRoles');

        Route::get('role', 'RoleController@index');
        Route::post('role', 'RoleController@store')->middleware('permission:all.role');
        Route::delete('role/{role}', 'RoleController@destroy')->middleware('permission:all.role');
        Route::patch('role/{role}', 'RoleController@update')->middleware('permission:all.role');
        Route::get('role/permissions/{role}', 'RoleController@rolePermissions')->middleware('permission:all.role');
        Route::patch('role/syncPermissions/{role}', 'RoleController@syncPermissions')->middleware('permission:all.role');

        Route::get('permission', 'PermissionController@index');
        Route::post('permission', 'PermissionController@store')->middleware('permission:all.permission');
        Route::delete('permission/{permission}', 'PermissionController@destroy')->middleware('permission:all.permission');
        Route::patch('permission/{permission}', 'PermissionController@update')->middleware('permission:all.permission');

        Route::get('user', 'UserController@index');
        Route::post('user', 'UserController@store')->middleware('permission:all.user');
        Route::delete('user/{user}', 'UserController@destroy')->middleware('permission:all.user');
        Route::patch('user/{user}', 'UserController@update')->middleware('permission:all.user');
        Route::patch('user/syncRoles/{user}', 'UserController@syncRoles')->middleware('permission:all.user');
        Route::patch('user/resetPassword/{user}', 'UserController@resetPassword')->middleware('permission:all.user');

        Route::get('attDir', 'AttDirController@index')->middleware('permission:all.attachment');
        Route::post('attDir', 'AttDirController@store')->middleware('permission:all.attachment');
        Route::delete('attDir/{attDir}', 'AttDirController@destroy')->middleware('permission:all.attachment');
        Route::patch('attDir/{attDir}', 'AttDirController@update')->middleware('permission:all.attachment');

        Route::get('attachment', 'AttachmentController@index')->middleware('permission:all.attachment');
        Route::post('attachment', 'AttachmentController@store')->middleware('permission:all.attachment');
        Route::delete('attachment/{attachment}', 'AttachmentController@destroy')->middleware('permission:all.attachment');
    });
});
