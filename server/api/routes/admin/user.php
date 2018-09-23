<?php
/**
 * Created by IntelliJ IDEA.
 * User: natusi
 * Date: 2018/9/9
 * Time: 下午4:30
 * 代理商管理
 */


Route::group([
    'prefix' => 'user',
    'namespace' => 'Admin\User',
], function () {
    Route::post('/login', [
        'uses' => 'IndexController@login',
        'as' => 'user_login',
        'display_name' => '用户登录',
    ]);
});


Route::group([
    'prefix' => 'user',
    'namespace' => 'Admin\User',
    'middleware' => ['auth:api', 'admin.api'],
], function () {
    Route::get('/', [
        'uses' => 'IndexController@index',
        'as' => 'user_list'
    ]);
    // 用户信息
    Route::get('/info', [
        'uses' => 'IndexController@info',
        'as' => 'user_info'
    ]);

    Route::post('/', [
        'uses' => 'IndexController@store',
        'as' => 'user_create',
        'display_name' => '用户新增',
    ]);

    Route::put('/{user}', [
        'uses' => 'IndexController@update',
        'as' => 'user_update',
        'display_name' => '用户修改',
        'visible' => false,
    ]);

    Route::delete('/{user}', [
        'uses' => 'IndexController@destroy',
        'as' => 'user_delete',
        'display_name' => '用户删除',
        'visible' => false,
    ]);
});
