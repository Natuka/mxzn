<?php
/**
 * Created by IntelliJ IDEA.
 * User: FangTi
 * Date: 2018/9/10
 * Time: 下午4:30
 * 工程师资料
 */


Route::group([
    'prefix' => 'engineer',
    'namespace' => 'Admin\Engineer',
    'middleware' => ['auth:api', 'admin.api'],
], function () {
    Route::get('/', [
        'uses' => 'IndexController@index',
        'as' => 'engineer_list'
    ]);


    /*    Route::get('/', [
            'uses' => 'IndexController@index',
            'as' => 'engineer_list',
            'display_name' => '1.工程师管理',
            'visible' => true,
        ]);*/

    Route::post('/', [
        'uses' => 'IndexController@create',
        'as' => 'engineer_create',
        'display_name' => '工程师新增',
    ]);

    Route::put('/{engineer}', [
        'uses' => 'IndexController@update',
        'as' => 'engineer_update',
        'display_name' => '工程师修改',
        'visible' => false,
    ]);

    Route::delete('/{engineer}', [
        'uses' => 'IndexController@destroy',
        'as' => 'engineer_delete',
        'display_name' => '工程师删除',
        'visible' => false,
    ]);
});
