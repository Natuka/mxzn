<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/6
 * Time: 10:30
 */
Route::group([
    'prefix' => 'order_flow/repair/{order}/follow-up',
    'namespace' => 'Admin\OrderFlow\Action',
    'middleware' => ['auth:api', 'admin.api'],
], function () {
    Route::get('default', [
        'uses' => 'FollowupController@default',
        'as' => 'order_repair_followup_default',
        'display_name' => '工单维护-签到记录',
        'visible' => true,
        'alias' => 'order_repair_followup_list',
    ]);
    Route::get('/', [
        'uses' => 'FollowupController@index',
        'as' => 'order_repair_followup_list',
        'display_name' => '签到记录列表',
        'visible' => true,
    ]);

    Route::post('/', [
        'uses' => 'FollowupController@store',
        'as' => 'order_repair_followup_create',
        'display_name' => '签到记录新增',
        'visible' => false,
    ]);

    Route::put('/{followup}', [
        'uses' => 'FollowupController@update',
        'as' => 'order_repair_followup_update',
        'display_name' => '签到记录修改',
        'visible' => false,
    ]);

    Route::delete('/{followup}', [
        'uses' => 'FollowupController@destroy',
        'as' => 'order_repair_followup_delete',
        'display_name' => '签到记录删除',
        'visible' => false,
    ]);

});
