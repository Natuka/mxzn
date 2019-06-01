<?php
/**
 * Created by IntelliJ IDEA.
 * User: FangTi
 * Date: 2018/9/10
 * Time: 下午4:30
 * 机台档案
 */


Route::group([
    'prefix' => 'knowledge',
    'namespace' => 'Admin\Knowledge',
    'middleware' => ['auth:api', 'admin.api'],
], function () {
    Route::get('/', [
        'uses' => 'IndexController@index',
        'as' => 'knowledge_list'
    ]);


    /*    Route::get('/', [
            'uses' => 'IndexController@index',
            'as' => 'knowledge_list',
            'display_name' => '1.机台档案管理',
            'visible' => true,
        ]);*/

    Route::post('/', [
        'uses' => 'IndexController@create',
        'as' => 'knowledge_create',
        'display_name' => '知识新增',
    ]);

    Route::put('/{knowledge}', [
        'uses' => 'IndexController@update',
        'as' => 'knowledge_update',
        'display_name' => '知识修改',
        'visible' => false,
    ]);

    Route::delete('/{knowledge}', [
        'uses' => 'IndexController@destroy',
        'as' => 'knowledge_delete',
        'display_name' => '知识删除',
        'visible' => false,
    ]);



});
