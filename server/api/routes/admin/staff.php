<?php
/**
 * Created by IntelliJ IDEA.
 * User: FangTi
 * Date: 2018/9/10
 * Time: 下午4:30
 * 员工资料
 */


Route::group([
    'prefix' => 'staff',
    'namespace' => 'Admin\Staff',
    'middleware' => ['auth:api', 'admin.api'],
], function () {
    Route::get('/', [
        'uses' => 'IndexController@index',
        'as' => 'staff_list'
    ]);

    Route::post('/', [
        'uses' => 'IndexController@create',
        'as' => 'staff_create',
        'display_name' => '员工新增',
    ]);

    Route::put('/{staff}', [
        'uses' => 'IndexController@update',
        'as' => 'staff_update',
        'display_name' => '员工修改',
        'visible' => false,
    ]);

    Route::delete('/{staff}', [
        'uses' => 'IndexController@destroy',
        'as' => 'staff_delete',
        'display_name' => '员工删除',
        'visible' => false,
    ]);
});
