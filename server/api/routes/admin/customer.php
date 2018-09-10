<?php
/**
 * Created by IntelliJ IDEA.
 * User: FangTi
 * Date: 2018/9/10
 * Time: 下午4:30
 * 客户档案
 */


Route::group([
    'prefix' => 'customer',
    'namespace' => 'Admin\Customer'
], function () {
    Route::get('/', [
        'uses' => 'IndexController@index',
        'as' => 'customer_list'
    ]);
});
