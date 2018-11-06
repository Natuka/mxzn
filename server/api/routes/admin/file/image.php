<?php

Route::group([
    'prefix' => 'file',
    'namespace' => 'Admin\File',
    'middleware' => ['auth:api', 'admin.api'],
], function () {
    Route::get('/image', [
        'uses' => 'ImageController@get',
        'as' => 'image_get',
        'display_name' => '图片保存',
    ]);

    Route::post('/image', [
        'uses' => 'ImageController@store',
        'as' => 'image_store',
        'display_name' => '图片保存',
    ]);
});
