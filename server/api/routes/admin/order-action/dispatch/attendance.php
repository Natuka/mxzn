<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/6
 * Time: 10:30
 */
Route::group([
    'prefix' => 'order_flow/dispatch/{order}/attendance',
    'namespace' => 'Admin\OrderFlow\Action'
], function () {
    Route::get('default', [
        'uses' => 'AttendanceController@default',
        'as' => 'order_dispatch_attendance_default',
        'display_name' => '工单维护-签到记录',
        'visible' => true,
        'alias' => 'order_dispatch_attendance_list',
    ]);
    Route::get('/', [
        'uses' => 'AttendanceController@index',
        'as' => 'order_dispatch_attendance_list',
        'display_name' => '签到记录列表',
        'visible' => true,
    ]);

    Route::post('/', [
        'uses' => 'AttendanceController@store',
        'as' => 'order_dispatch_attendance_create',
        'display_name' => '签到记录新增',
        'visible' => false,
    ]);

    Route::put('/{attendance}', [
        'uses' => 'AttendanceController@update',
        'as' => 'order_dispatch_attendance_update',
        'display_name' => '签到记录修改',
        'visible' => false,
    ]);

    Route::delete('/{attendance}', [
        'uses' => 'AttendanceController@destroy',
        'as' => 'order_dispatch_attendance_delete',
        'display_name' => '签到记录删除',
        'visible' => false,
    ]);

});
