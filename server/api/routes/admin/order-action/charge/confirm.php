<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/6
 * Time: 10:30
 */
Route::group([
    'prefix' => 'order_flow/charge/{order}/confirm',
    'namespace' => 'Admin\OrderFlow\Action'
], function () {
    Route::get('default', [
        'uses' => 'ConfirmController@default',
        'as' => 'order_charge_confirm_default',
        'display_name' => '工单维护-客户确认',
        'visible' => true,
        'alias' => 'order_charge_confirm_list',
    ]);
    Route::get('/', [
        'uses' => 'ConfirmController@index',
        'as' => 'order_charge_confirm_list',
        'display_name' => '客户确认列表',
        'visible' => true,
    ]);

    Route::post('/', [
        'uses' => 'ConfirmController@store',
        'as' => 'order_charge_confirm_create',
        'display_name' => '客户确认新增',
        'visible' => false,
    ]);

    Route::put('/{confirm}', [
        'uses' => 'ConfirmController@update',
        'as' => 'order_charge_confirm_update',
        'display_name' => '客户确认修改',
        'visible' => false,
    ]);

    Route::delete('/{confirm}', [
        'uses' => 'ConfirmController@destroy',
        'as' => 'order_charge_confirm_delete',
        'display_name' => '客户确认删除',
        'visible' => false,
    ]);

});
