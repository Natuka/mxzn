<?php
/**
 * Created by IntelliJ IDEA.
 * User: FangTi
 * Date: 2018/9/15
 * Time: 下午4:30
 * 报价单
 */


Route::group([
    'prefix' => 'customerquotation',
    'namespace' => 'Admin\Customer',
    'middleware' => ['auth:api', 'admin.api'],
], function () {
    Route::get('/', [
        'uses' => 'QuotationController@index',
        'as' => 'customerquotation_list',
        'display_name' => '1.报价单管理',
    ]);


    /*    Route::get('/', [
            'uses' => 'QuotationController@index',
            'as' => 'customer_list',
            'display_name' => '1.客户管理',
            'visible' => true,
        ]);*/

    Route::post('/', [
        'uses' => 'QuotationController@create',
        'as' => 'customerquotation_create',
        'display_name' => '报价单新增',
        'visible' => false,
    ]);

    Route::put('/{quotation}', [
        'uses' => 'QuotationController@update',
        'as' => 'customerquotation_update',
        'display_name' => '报价单修改',
        'visible' => false,
    ]);

    Route::delete('/{quotation}', [
        'uses' => 'QuotationController@destroy',
        'as' => 'customerquotation_delete',
        'display_name' => '报价单删除',
        'visible' => false,
    ]);
    Route::post('/remove-list', [
        'uses' => 'QuotationController@destroyList',
        'as' => 'customerquotation_list_delete',
        'display_name' => '报价单批量删除',
        'visible' => false,
    ]);

    Route::post('/auditing', [
        'uses' => 'QuotationController@auditing',
        'as' => 'customerquotation_list_auditing',
        'display_name' => '审核',
        'visible' => false,
    ]);

    Route::post('/copy', [
        'uses' => 'QuotationController@copy',
        'as' => 'customerquotation_list_copy',
        'display_name' => '复制',
        'visible' => false,
    ]);

    Route::post('/toorder', [
        'uses' => 'QuotationController@toorder',
        'as' => 'customerquotation_list_toorder',
        'display_name' => '转工单',
        'visible' => false,
    ]);

});
