<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/6
 * Time: 10:30
 */
Route::group([
    'prefix' => 'order_flow/maintain/{order}/service',
    'namespace' => 'Admin\OrderFlow\Action'
], function () {
    Route::get('default', [
        'uses' => 'ServiceController@default',
        'as' => 'order_maintain_service_default',
        'display_name' => '工单维护-服务项目',
        'visible' => true,
        'alias' => 'order_maintain_service_list',
    ]);
    Route::get('/', [
        'uses' => 'ServiceController@index',
        'as' => 'order_maintain_service_list',
        'display_name' => '服务项目列表',
        'visible' => true,
    ]);

    Route::post('/', [
        'uses' => 'ServiceController@store',
        'as' => 'order_maintain_service_create',
        'display_name' => '服务项目新增',
        'visible' => false,
    ]);

    Route::put('/{service}', [
        'uses' => 'ServiceController@update',
        'as' => 'order_maintain_service_update',
        'display_name' => '服务项目修改',
        'visible' => false,
    ]);

    Route::delete('/{service}', [
        'uses' => 'ServiceController@destroy',
        'as' => 'order_maintain_service_delete',
        'display_name' => '服务项目删除',
        'visible' => false,
    ]);

});
