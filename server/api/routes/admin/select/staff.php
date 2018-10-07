<?php
/**
 * Created by IntelliJ IDEA.
 * User: natusi
 * Date: 2018/9/9
 * Time: 下午4:30
 * 代理商管理
 */


Route::group([
    'prefix' => 'select',
    'namespace' => 'Admin\Select'
], function () {
    Route::get('staff', [
        'uses' => 'StaffController@index',
        'as' => 'select_staff'
    ]);
    // TODO 后续添加
});
