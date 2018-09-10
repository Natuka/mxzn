<?php
/**
 * Created by IntelliJ IDEA.
 * User: FangTi
 * Date: 2018/9/10
 * Time: 下午4:30
 * 文档资料
 */


Route::group([
    'prefix' => 'document',
    'namespace' => 'Admin\Document'
], function () {
    Route::get('/', [
        'uses' => 'IndexController@index',
        'as' => 'document_list'
    ]);
});
