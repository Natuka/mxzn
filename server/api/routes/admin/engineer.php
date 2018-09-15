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
    'namespace' => 'Admin\Engineer'
], function () {
    Route::get('/', [
        'uses' => 'IndexController@index',
        'as' => 'engineer_list'
    ]);
});
