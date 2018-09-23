<?php
/**
 * Created by IntelliJ IDEA.
 * User: FangTi
 * Date: 2018/9/10
 * Time: 下午4:30
 * 员工资料
 */


Route::group([
    'prefix' => 'organization',
    'namespace' => 'Admin\Organization',
    'middleware' => ['auth:api', 'admin.api'],
], function () {
    Route::get('/', [
        'uses' => 'IndexController@index',
        'as' => 'organization_list'
    ]);

    Route::post('/', [
        'uses' => 'IndexController@store',
        'as' => 'organization_create',
        'display_name' => '公司新增',
    ]);

    Route::put('/{organization}', [
        'uses' => 'IndexController@update',
        'as' => 'organization_update',
        'display_name' => '公司修改',
        'visible' => false,
    ]);

    Route::delete('/{staff}', [
        'uses' => 'IndexController@destroy',
        'as' => 'organization_delete',
        'display_name' => '公司删除',
        'visible' => false,
    ]);
});
