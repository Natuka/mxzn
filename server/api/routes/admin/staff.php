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
    'namespace' => 'Admin\Staff'
], function () {
    Route::get('/', [
        'uses' => 'IndexController@index',
        'as' => 'staff_list'
    ]);
});
