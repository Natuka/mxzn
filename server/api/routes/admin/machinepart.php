<?php
/**
 * Created by IntelliJ IDEA.
 * User: FangTi
 * Date: 2018/9/10
 * Time: 下午4:30
 * 机器零件资料
 */


Route::group([
    'prefix' => 'machinepart',
    'namespace' => 'Admin\MachinePart',
    'middleware' => ['auth:api', 'admin.api'],
], function () {
    Route::get('/', [
        'uses' => 'IndexController@index',
        'as' => 'machinepart_list'
    ]);


    /*    Route::get('/', [
            'uses' => 'IndexController@index',
            'as' => 'machinepart_list',
            'display_name' => '1.机器零件管理',
            'visible' => true,
        ]);*/

    Route::post('/', [
        'uses' => 'IndexController@create',
        'as' => 'machinepart_create',
        'display_name' => '机器零件新增',
    ]);

    Route::put('/{machinepart}', [
        'uses' => 'IndexController@update',
        'as' => 'machinepart_update',
        'display_name' => '机器零件修改',
        'visible' => false,
    ]);

    Route::delete('/{machinepart}', [
        'uses' => 'IndexController@destroy',
        'as' => 'machinepart_delete',
        'display_name' => '机器零件删除',
        'visible' => false,
    ]);

});
