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
    'namespace' => 'Admin\MachinePart'
], function () {
    Route::get('/', [
        'uses' => 'IndexController@index',
        'as' => 'machinepart_list'
    ]);
});
