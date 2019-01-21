<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/6
 * Time: 10:30
 */
Route::group([
    'prefix' => 'order_flow/repair/{order}/repairs',
    'namespace' => 'Admin\OrderFlow\Action',
    'middleware' => ['auth:api', 'admin.api'],
], function () {
    Route::get('default', [
        'uses' => 'RepairsController@default',
        'as' => 'order_repair_repairs_default',
        'display_name' => '工单维护-处理过程',
        'visible' => true,
        'alias' => 'order_repair_repairs_list',
    ]);
    Route::get('/', [
        'uses' => 'RepairsController@index',
        'as' => 'order_repair_repairs_list',
        'display_name' => '处理过程列表',
        'visible' => true,
    ]);

    Route::post('/', [
        'uses' => 'RepairsController@store',
        'as' => 'order_repair_repairs_create',
        'display_name' => '处理过程新增',
        'visible' => false,
    ]);

    Route::put('/{repair}', [
        'uses' => 'RepairsController@update',
        'as' => 'order_repair_repairs_update',
        'display_name' => '处理过程修改',
        'visible' => false,
    ]);

    Route::delete('/{repair}', [
        'uses' => 'RepairsController@destroy',
        'as' => 'order_repair_repairs_delete',
        'display_name' => '处理过程删除',
        'visible' => false,
    ]);

});
