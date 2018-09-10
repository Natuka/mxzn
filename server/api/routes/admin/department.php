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
    'namespace' => 'Admin\Department'
], function () {
    Route::get('/', [
        'uses' => 'IndexController@index',
        'as' => 'department_list'
    ]);
});
