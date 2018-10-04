<?php
/**
 * Created by PhpStorm.
 * User: natusi
 * Date: 2018-10-04
 * Time: 20:34
 */

Route::group([
    'prefix' => 'job',
    'namespace' => 'Admin\Base',
    // 'middleware' => 'auth:api',
], function () {

    Route::get('/', [
        'uses' => 'JobController@index',
        'as' => 'job_list',
        'display_name' => '职务列表',
        'visible' => true,
    ]);

    Route::post('/', [
        'uses' => 'JobController@store',
        'as' => 'job_create',
        'display_name' => '职务新增',
        'visible' => true,
    ]);

    Route::put('/{baseConfig}', [
        'uses' => 'JobController@store',
        'as' => 'job_update',
        'display_name' => '职务新增',
        'visible' => true,
    ]);

    Route::delete('/{baseConfig}', [
        'uses' => 'JobController@destroy',
        'as' => 'job_update',
        'display_name' => '职务新增',
        'visible' => true,
    ]);
});


Route::group([
    'prefix' => 'post',
    'namespace' => 'Admin\Base',
    // 'middleware' => 'auth:api',
], function () {

    Route::get('/', [
        'uses' => 'PostController@index',
        'as' => 'post_list',
        'display_name' => '职位列表',
        'visible' => true,
    ]);

    Route::post('/', [
        'uses' => 'PostController@store',
        'as' => 'post_create',
        'display_name' => '职位新增',
        'visible' => true,
    ]);

    Route::put('/{baseConfig}', [
        'uses' => 'PostController@store',
        'as' => 'post_update',
        'display_name' => '职位新增',
        'visible' => true,
    ]);

    Route::delete('/{baseConfig}', [
        'uses' => 'PostController@destroy',
        'as' => 'post_update',
        'display_name' => '职位新增',
        'visible' => true,
    ]);
});
