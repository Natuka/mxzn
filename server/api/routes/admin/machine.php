<?php
/**
 * Created by IntelliJ IDEA.
 * User: FangTi
 * Date: 2018/9/10
 * Time: 下午4:30
 * 机台档案
 */


Route::group([
    'prefix' => 'machine',
    'namespace' => 'Admin\Machine'
], function () {
    Route::get('/', [
        'uses' => 'IndexController@index',
        'as' => 'machine_list'
    ]);
});
