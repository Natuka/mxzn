<?php
/**
 * Created by IntelliJ IDEA.
 * User: natusi
 * Date: 2018/9/9
 * Time: 下午4:30
 * 代理商管理
 */


Route::group([
    'prefix' => 'base',
    'namespace' => 'Admin\Select'
], function () {
    Route::get('job', [
        'uses' => 'BaseConfigController@job',
        'as' => 'base_job'
    ]);

    Route::get('post', [
        'uses' => 'BaseConfigController@post',
        'as' => 'base_post'
    ]);

    // 学历
    Route::get('education', [
        'uses' => 'BaseConfigController@education',
        'as' => 'base_education'
    ]);

    // TODO 后续添加
});
