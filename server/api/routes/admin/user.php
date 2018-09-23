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
    'namespace' => 'Admin\User'
], function () {
    Route::get('/', [
        'uses' => 'IndexController@index',
        'as' => 'user_list'
    ]);

    /*    Route::get('/', [
            'uses' => 'IndexController@index',
            'as' => 'agent_list',
            'display_name' => '1.代理商管理',
            'visible' => true,
        ]);*/

    Route::post('/login', [
        'uses' => 'IndexController@login',
        'as' => 'user_login',
        'display_name' => '用户登录',
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
