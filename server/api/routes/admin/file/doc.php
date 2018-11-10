<?php

Route::group([
    'prefix' => 'file',
    'namespace' => 'Admin\File',
    'middleware' => ['auth:api', 'admin.api'],
], function () {
    Route::get('/doc', [
        'uses' => 'DocController@get',
        'as' => 'doc_get',
        'display_name' => '文件',
    ]);

    Route::get('/doc/list', [
        'uses' => 'DocController@getList',
        'as' => 'doc_list',
        'display_name' => '文件列表',
    ]);

    Route::post('/doc', [
        'uses' => 'DocController@store',
        'as' => 'image_store',
        'display_name' => '文件保存',
    ]);
});
