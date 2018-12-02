<?php
/**
 * Created by IntelliJ IDEA.
 * User: FangTi
 * Date: 2018/9/10
 * Time: 下午4:30
 * 设备二维码
 */


Route::group([
    'prefix' => 'machineqrcode',
    'namespace' => 'Admin\Machineqrcode'
], function () {
    Route::get('/', [
        'uses' => 'IndexController@index',
        'as' => 'machineqrcode_list'
    ]);


    /*    Route::get('/', [
            'uses' => 'IndexController@index',
            'as' => 'machine_list',
            'display_name' => '1.设备二维码管理',
            'visible' => true,
        ]);*/

    Route::post('/', [
        'uses' => 'IndexController@create',
        'as' => 'machineqrcode_create',
        'display_name' => '设备二维码新增',
    ]);

    Route::put('/{machineqrcode}', [
        'uses' => 'IndexController@update',
        'as' => 'machineqrcode_update',
        'display_name' => '设备二维码修改',
        'visible' => false,
    ]);

    Route::delete('/{machineqrcode}', [
        'uses' => 'IndexController@destroy',
        'as' => 'machineqrcode_delete',
        'display_name' => '设备二维码删除',
        'visible' => false,
    ]);



});
