<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/6
 * Time: 10:30
 */
Route::group([
    'prefix' => 'order_flow/install/{order}/parts',
    'namespace' => 'Admin\OrderFlow\Action'
], function () {
    Route::get('default', [
        'uses' => 'PartsController@default',
        'as' => 'order_install_parts_default',
        'display_name' => '工单维护-配件耗材',
        'visible' => true,
        'alias' => 'order_install_parts_list',
    ]);
    Route::get('/', [
        'uses' => 'PartsController@index',
        'as' => 'order_install_parts_list',
        'display_name' => '配件耗材列表',
        'visible' => true,
    ]);

    Route::post('/', [
        'uses' => 'PartsController@store',
        'as' => 'order_install_parts_create',
        'display_name' => '配件耗材新增',
        'visible' => false,
    ]);

    Route::put('/{part}', [
        'uses' => 'PartsController@update',
        'as' => 'order_install_parts_update',
        'display_name' => '配件耗材修改',
        'visible' => false,
    ]);

    Route::delete('/{part}', [
        'uses' => 'PartsController@destroy',
        'as' => 'order_install_parts_delete',
        'display_name' => '配件耗材删除',
        'visible' => false,
    ]);

});
