<?php
/**
 * Created by IntelliJ IDEA.
 * User: FangTi
 * Date: 2018/9/10
 * Time: 下午4:30
 * 机台档案
 */


Route::group([
    'prefix' => 'machine',
    'namespace' => 'Admin\Machine'
], function () {
    Route::get('/', [
        'uses' => 'IndexController@index',
        'as' => 'machine_list'
    ]);


    /*    Route::get('/', [
            'uses' => 'IndexController@index',
            'as' => 'machine_list',
            'display_name' => '1.机台档案管理',
            'visible' => true,
        ]);*/

    Route::post('/', [
        'uses' => 'IndexController@create',
        'as' => 'machine_create',
        'display_name' => '机台档案新增',
    ]);

    Route::put('/{machine}', [
        'uses' => 'IndexController@update',
        'as' => 'machine_update',
        'display_name' => '机台档案修改',
        'visible' => false,
    ]);

    Route::delete('/{machine}', [
        'uses' => 'IndexController@destroy',
        'as' => 'machine_delete',
        'display_name' => '机台档案删除',
        'visible' => false,
    ]);



});
