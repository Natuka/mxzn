<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/6
 * Time: 10:30
 */
Route::group([
    'prefix' => 'order_flow/close/{order}/doc',
    'namespace' => 'Admin\OrderFlow\Action'
], function () {
    Route::get('default', [
        'uses' => 'DocController@default',
        'as' => 'order_close_doc_default',
        'display_name' => '工单维护-附件',
        'visible' => true,
        'alias' => 'order_close_doc_list',
    ]);
    Route::get('/', [
        'uses' => 'DocController@index',
        'as' => 'order_close_doc_list',
        'display_name' => '附件列表',
        'visible' => true,
    ]);

    Route::post('/', [
        'uses' => 'DocController@store',
        'as' => 'order_close_doc_create',
        'display_name' => '附件新增',
        'visible' => false,
    ]);

    Route::put('/{doc}', [
        'uses' => 'DocController@update',
        'as' => 'order_close_doc_update',
        'display_name' => '附件修改',
        'visible' => false,
    ]);

    Route::delete('/{doc}', [
        'uses' => 'DocController@destroy',
        'as' => 'order_close_doc_delete',
        'display_name' => '附件删除',
        'visible' => false,
    ]);

});
