<?php
/**
 * Created by IntelliJ IDEA.
 * User: FangTi
 * Date: 2018/9/10
 * Time: 下午4:30
 * 客户档案
 */


Route::group([
    'prefix' => 'customer',
    'namespace' => 'Admin\Customer',
    'middleware' => ['auth:api', 'admin.api'],
], function () {
    Route::get('/', [
        'uses' => 'IndexController@index',
        'as' => 'customer_list',
        'display_name' => '1 客户管理',
    ]);

/*    Route::get('/', [
        'uses' => 'IndexController@index',
        'as' => 'customer_list',
        'display_name' => '1.客户管理',
        'visible' => true,
    ]);*/

    Route::post('/', [
        'uses' => 'IndexController@create',
        'as' => 'customer_create',
        'display_name' => '客户新增',
    ]);

    Route::put('/{customer}', [
        'uses' => 'IndexController@update',
        'as' => 'customer_update',
        'display_name' => '客户修改',
        'visible' => false,
    ]);

    Route::delete('/{customer}', [
        'uses' => 'IndexController@destroy',
        'as' => 'customer_delete',
        'display_name' => '客户删除',
        'visible' => false,
    ]);
    Route::post('/remove-list', [
        'uses' => 'IndexController@destroyList',
        'as' => 'customer_list_delete',
        'display_name' => '客户批量删除',
        'visible' => false,
    ]);


});
