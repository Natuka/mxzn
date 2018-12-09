<?php
/**
 * Created by IntelliJ IDEA.
 * User: FangTi
 * Date: 2018/9/10
 * Time: 下午4:30
 * 外出申请资料
 */


Route::group([
    'prefix' => 'outstaff',
    'namespace' => 'Admin\Staff',
    'middleware' => ['auth:api', 'admin.api'],
], function () {
    Route::get('/', [
        'uses' => 'OutController@index',
        'as' => 'outstaff_list'
    ]);

    /*    Route::get('/', [
            'uses' => 'OutController@index',
            'as' => 'staff_list',
            'display_name' => '1.外出申请管理',
            'visible' => true,
        ]);*/

    Route::post('/', [
        'uses' => 'OutController@create',
        'as' => 'outstaff_create',
        'display_name' => '外出申请新增',
    ]);

    Route::put('/{staff}', [
        'uses' => 'OutController@update',
        'as' => 'outstaff_update',
        'display_name' => '外出申请修改',
        'visible' => false,
    ]);

    Route::delete('/{outstaff}', [
        'uses' => 'OutController@destroy',
        'as' => 'outstaff_delete',
        'display_name' => '外出申请删除',
        'visible' => false,
    ]);
});
