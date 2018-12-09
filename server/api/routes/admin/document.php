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
    'namespace' => 'Admin\Document',
    'middleware' => ['auth:api', 'admin.api'],
], function () {
    Route::get('/', [
        'uses' => 'IndexController@index',
        'as' => 'document_list'
    ]);


    /*    Route::get('/', [
            'uses' => 'IndexController@index',
            'as' => 'document_list',
            'display_name' => '1.文档管理',
            'visible' => true,
        ]);*/

    Route::post('/', [
        'uses' => 'IndexController@create',
        'as' => 'document_create',
        'display_name' => '文档新增',
    ]);

    Route::put('/{document}', [
        'uses' => 'IndexController@update',
        'as' => 'document_update',
        'display_name' => '文档修改',
        'visible' => false,
    ]);

    Route::delete('/{document}', [
        'uses' => 'IndexController@destroy',
        'as' => 'document_delete',
        'display_name' => '文档删除',
        'visible' => false,
    ]);

});
