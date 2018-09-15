<?php
/**
 * Created by IntelliJ IDEA.
 * User: FangTi
 * Date: 2018/9/15
 * Time: 下午4:30
 * 客户联系人
 */


Route::group([
    'prefix' => 'customercontact',
    'namespace' => 'Admin\Customer'
], function () {
    Route::get('/', [
        'uses' => 'ContactController@index',
        'as' => 'customercontact_list',
        'display_name' => '1.客户联系人管理',
    ]);


    /*    Route::get('/', [
            'uses' => 'ContactController@index',
            'as' => 'customer_list',
            'display_name' => '1.客户管理',
            'visible' => true,
        ]);*/

    Route::post('/', [
        'uses' => 'ContactController@create',
        'as' => 'customercontact_create',
        'display_name' => '客户联系人新增',
        'visible' => false,
    ]);

    Route::put('/{customercontact}', [
        'uses' => 'ContactController@update',
        'as' => 'customercontact_update',
        'display_name' => '客户联系人修改',
        'visible' => false,
    ]);

    Route::delete('/{customercontact}', [
        'uses' => 'ContactController@destroy',
        'as' => 'customercontact_delete',
        'display_name' => '客户联系人删除',
        'visible' => false,
    ]);
    Route::post('/remove-list', [
        'uses' => 'ContactController@destroyList',
        'as' => 'customer_list_delete',
        'display_name' => '客户联系人批量删除',
        'visible' => false,
    ]);


});
