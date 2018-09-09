<?php
/**
 * Created by IntelliJ IDEA.
 * User: natusi
 * Date: 2018/9/9
 * Time: 下午4:30
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
