<?php
/**
 * Created by IntelliJ IDEA.
 * User: FangTi
 * Date: 2018/9/15
 * Time: 下午4:30
 * 客户设备
 */


Route::group([
    'prefix' => 'customerequipment',
    'namespace' => 'Admin\Customer'
], function () {
    Route::get('/', [
        'uses' => 'EquipmentController@index',
        'as' => 'customerequipment_list',
        'display_name' => '1.客户设备管理',
    ]);


    /*    Route::get('/', [
            'uses' => 'EquipmentController@index',
            'as' => 'customer_list',
            'display_name' => '1.客户管理',
            'visible' => true,
        ]);*/

    Route::post('/', [
        'uses' => 'EquipmentController@store',
        'as' => 'customerequipment_store',
        'display_name' => '客户设备新增',
        'visible' => false,
    ]);

    Route::put('/{customerequipment}', [
        'uses' => 'EquipmentController@update',
        'as' => 'customerequipment_update',
        'display_name' => '客户设备修改',
        'visible' => false,
    ]);

    Route::delete('/{customerequipment}', [
        'uses' => 'EquipmentController@destroy',
        'as' => 'customerequipment_delete',
        'display_name' => '客户设备删除',
        'visible' => false,
    ]);
    Route::post('/remove-list', [
        'uses' => 'EquipmentController@destroyList',
        'as' => 'customerequipment_list_delete',
        'display_name' => '客户设备批量删除',
        'visible' => false,
    ]);


});
