<?php
/**
 * Created by IntelliJ IDEA.
 * User: natusi
 * Date: 2018/9/9
 * Time: 下午4:30
 * 代理商管理
 */


Route::group([
    'prefix' => 'agent',
    'namespace' => 'Admin\Agent'
], function () {
    Route::get('/', [
        'uses' => 'IndexController@index',
        'as' => 'agent_list'
    ]);
});
