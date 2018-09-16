<?php
/**
 * Created by IntelliJ IDEA.
 * User: natusi
 * Date: 2018/9/9
 * Time: 下午4:30
 * 代理商管理
 */


Route::group([
    'prefix' => 'agent',
    'namespace' => 'Admin\Agent'
], function () {
    Route::get('/', [
        'uses' => 'IndexController@index',
        'as' => 'agent_list'
    ]);

    /*    Route::get('/', [
            'uses' => 'IndexController@index',
            'as' => 'agent_list',
            'display_name' => '1.代理商管理',
            'visible' => true,
        ]);*/

    Route::post('/', [
        'uses' => 'IndexController@create',
        'as' => 'agent_create',
        'display_name' => '代理商新增',
    ]);

    Route::put('/{agent}', [
        'uses' => 'IndexController@update',
        'as' => 'agent_update',
        'display_name' => '代理商修改',
        'visible' => false,
    ]);

    Route::delete('/{agent}', [
        'uses' => 'IndexController@destroy',
        'as' => 'agent_delete',
        'display_name' => '代理商删除',
        'visible' => false,
    ]);

});
