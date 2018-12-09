<?php
/**
 * Created by IntelliJ IDEA.
 * User: FangTi
 * Date: 2018/9/10
 * Time: 下午4:30
 * 公司组织架构（部门）资料
 */


Route::group([
    'prefix' => 'department',
    'namespace' => 'Admin\Department',
    'middleware' => ['auth:api', 'admin.api'],
], function () {
    Route::get('/', [
        'uses' => 'IndexController@index',
        'as' => 'department_list'
    ]);

    /*    Route::get('/', [
            'uses' => 'IndexController@index',
            'as' => 'department_list',
            'display_name' => '1.部门管理',
            'visible' => true,
        ]);*/

    Route::post('/', [
        'uses' => 'IndexController@create',
        'as' => 'department_create',
        'display_name' => '部门新增',
    ]);

    Route::put('/{department}', [
        'uses' => 'IndexController@update',
        'as' => 'department_update',
        'display_name' => '部门修改',
        'visible' => false,
    ]);

    Route::delete('/{department}', [
        'uses' => 'IndexController@destroy',
        'as' => 'department_delete',
        'display_name' => '部门删除',
        'visible' => false,
    ]);


});
