<?php
/**
 * Created by IntelliJ IDEA.
 * User: FangTi
 * Date: 2018/9/15
 * Time: 下午4:30
 * 客户联系人
 */


Route::group([
    'prefix' => 'customercontact',
    'namespace' => 'Admin\Customer'
], function () {
    Route::get('/', [
        'uses' => 'ContactController@index',
        'as' => 'customercontact_list'
    ]);
});
