<?php
/**
 * Created by IntelliJ IDEA.
 * User: FangTi
 * Date: 2018/9/10
 * Time: 下午4:30
 * 服务项目资料
 */


Route::group([
    'prefix' => 'service',
    'namespace' => 'Admin\Service',
    'middleware' => ['auth:api', 'admin.api'],
], function () {
    Route::get('/', [
        'uses' => 'IndexController@index',
        'as' => 'service_list'
    ]);

    Route::post('/', [
        'uses' => 'IndexController@store',
        'as' => 'service_store',
        'display_name' => '服务项目新增',
    ]);

    Route::put('/{service}', [
        'uses' => 'IndexController@update',
        'as' => 'service_update',
        'display_name' => '服务项目修改',
        'visible' => false,
    ]);

    Route::delete('/{service}', [
        'uses' => 'IndexController@destroy',
        'as' => 'service_delete',
        'display_name' => '服务项目删除',
        'visible' => false,
    ]);
});
