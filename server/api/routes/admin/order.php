<?php
/**
 * Created by IntelliJ IDEA.
 * User: natusi
 * Date: 2018/9/9
 * Time: 下午4:28
 */


Route::group([
    'prefix' => 'order_flow',
    'middleware' => ['auth:api', 'admin.api'],
    'namespace' => 'Admin\OrderFlow'
], function () {

    Route::get('default', [
        'uses' => 'IndexController@default',
        'as' => 'order_flow_default',
        'display_name' => '工单管理',
        'visible' => true,
    ]);

    Route::get('/index', [
        'uses' => 'IndexController@index',
        'as' => 'order_flow_index',
        'display_name' => '工单管理',
        'visible' => true,
    ]);

    Route::group(['prefix' => 'repair'], function () {
        Route::get('default', [
            'uses' => 'RepairController@default',
            'as' => 'order_repair_default',
            'display_name' => '工单维护-维修工单',
            'visible' => true,
            'alias' => 'order_repair_list',
        ]);

        Route::get('/', [
            'uses' => 'RepairController@index',
            'as' => 'order_repair_list',
            'display_name' => '维修工单列表',
            'visible' => true,
        ]);

        Route::post('/', [
            'uses' => 'RepairController@store',
            'as' => 'order_repair_create',
            'display_name' => '维修工单新增',
            'visible' => false,
        ]);

        Route::put('/{order}', [
            'uses' => 'RepairController@update',
            'as' => 'order_repair_update',
            'display_name' => '维修工单修改',
            'visible' => false,
        ]);

        Route::delete('/{order}', [
            'uses' => 'RepairController@destroy',
            'as' => 'order_repair_delete',
            'display_name' => '维修工单删除',
            'visible' => false,
        ]);

        Route::post('/next', [
            'uses' => 'RepairController@next',
            'as' => 'order_repair_next',
            'display_name' => '下一步',
            'visible' => false,
        ]);

    });

    Route::group(['prefix' => 'install'], function () {
        Route::get('default', [
            'uses' => 'InstallController@default',
            'as' => 'order_install_default',
            'display_name' => '工单维护-安装工单',
            'visible' => true,
            'alias' => 'order_install_list',
        ]);

        Route::get('/', [
            'uses' => 'InstallController@index',
            'as' => 'order_install_list',
            'display_name' => '安装工单列表',
            'visible' => true,
        ]);

        Route::post('/', [
            'uses' => 'InstallController@store',
            'as' => 'order_install_create',
            'display_name' => '安装工单新增',
            'visible' => false,
        ]);

        Route::put('/{order}', [
            'uses' => 'InstallController@update',
            'as' => 'order_install_update',
            'display_name' => '安装工单修改',
            'visible' => false,
        ]);

        Route::delete('/{order}', [
            'uses' => 'InstallController@destroy',
            'as' => 'order_install_delete',
            'display_name' => '安装工单删除',
            'visible' => false,
        ]);

        Route::post('/next', [
            'uses' => 'InstallController@next',
            'as' => 'order_install_next',
            'display_name' => '下一步',
            'visible' => false,
        ]);
    });

    Route::group(['prefix' => 'maintain'], function () {
        Route::get('default', [
            'uses' => 'MaintainController@default',
            'as' => 'order_maintain_default',
            'display_name' => '工单维护-保养工单',
            'visible' => true,
            'alias' => 'order_maintain_list',
        ]);

        Route::get('/', [
            'uses' => 'MaintainController@index',
            'as' => 'order_maintain_list',
            'display_name' => '保养工单列表',
            'visible' => true,
        ]);

        Route::post('/', [
            'uses' => 'MaintainController@store',
            'as' => 'order_maintain_create',
            'display_name' => '保养工单新增',
            'visible' => false,
        ]);

        Route::put('/{order}', [
            'uses' => 'MaintainController@update',
            'as' => 'order_maintain_update',
            'display_name' => '保养工单修改',
            'visible' => false,
        ]);

        Route::delete('/{order}', [
            'uses' => 'MaintainController@destroy',
            'as' => 'order_maintain_delete',
            'display_name' => '保养工单删除',
            'visible' => false,
        ]);

        Route::post('/next', [
            'uses' => 'MaintainController@next',
            'as' => 'order_maintain_next',
            'display_name' => '下一步',
            'visible' => false,
        ]);
    });


    Route::group(['prefix' => 'confirm'], function () {
        Route::get('default', [
            'uses' => 'ConfirmController@default',
            'as' => 'order_confirm_default',
            'display_name' => '工单确认',
            'visible' => true,
            'alias' => 'order_confirm_list',
        ]);

        Route::get('/', [
            'uses' => 'ConfirmController@index',
            'as' => 'order_confirm_list',
            'display_name' => '待确认列表',
            'visible' => true,
        ]);

        Route::post('/next', [
            'uses' => 'ConfirmController@next',
            'as' => 'order_confirm_next',
            'display_name' => '下一步',
            'visible' => false,
        ]);

        Route::post('/cancel', [
            'uses' => 'ConfirmController@cancel',
            'as' => 'order_confirm_cancel',
            'display_name' => '取消',
            'visible' => false,
        ]);

        Route::post('/back', [
            'uses' => 'ConfirmController@back',
            'as' => 'order_confirm_back',
            'display_name' => '退回',
            'visible' => false,
        ]);


        Route::put('/{order}', [
            'uses' => 'ConfirmController@update',
            'as' => 'order_confirm_update',
            'display_name' => '修改',
            'visible' => false,
        ]);
    });

    Route::group(['prefix' => 'dispatch'], function () {
        Route::get('default', [
            'uses' => 'DispatchController@default',
            'as' => 'order_dispatch_default',
            'display_name' => '工单派工',
            'visible' => true,
            'alias' => 'order_dispatch_list',
        ]);

        Route::get('/', [
            'uses' => 'DispatchController@index',
            'as' => 'order_dispatch_list',
            'display_name' => '待派工列表',
            'visible' => true,
        ]);

        Route::post('/next', [
            'uses' => 'DispatchController@next',
            'as' => 'order_dispatch_next',
            'display_name' => '下一步',
            'visible' => false,
        ]);

        Route::post('/cancel', [
            'uses' => 'DispatchController@cancel',
            'as' => 'order_dispatch_cancel',
            'display_name' => '取消',
            'visible' => false,
        ]);

        Route::post('/back', [
            'uses' => 'DispatchController@back',
            'as' => 'order_dispatch_back',
            'display_name' => '退回',
            'visible' => false,
        ]);


        Route::put('/{order}', [
            'uses' => 'DispatchController@update',
            'as' => 'order_dispatch_update',
            'display_name' => '修改',
            'visible' => false,
        ]);
    });


    Route::group(['prefix' => 'dispose'], function () {
        Route::get('default', [
            'uses' => 'DisposeController@default',
            'as' => 'order_dispose_default',
            'display_name' => '工单处理',
            'visible' => true,
            'alias' => 'order_dispose_list',
        ]);

        Route::get('/', [
            'uses' => 'DisposeController@index',
            'as' => 'order_dispose_list',
            'display_name' => '待处理列表',
            'visible' => true,
        ]);

        Route::post('/next', [
            'uses' => 'DisposeController@next',
            'as' => 'order_dispose_next',
            'display_name' => '下一步',
            'visible' => false,
        ]);

        Route::post('/cancel', [
            'uses' => 'DisposeController@cancel',
            'as' => 'order_dispose_cancel',
            'display_name' => '取消',
            'visible' => false,
        ]);

        Route::post('/back', [
            'uses' => 'DisposeController@back',
            'as' => 'order_dispose_back',
            'display_name' => '退回',
            'visible' => false,
        ]);


        Route::put('/{order}', [
            'uses' => 'DisposeController@update',
            'as' => 'order_dispose_update',
            'display_name' => '修改',
            'visible' => false,
        ]);
    });

    Route::group(['prefix' => 'charge'], function () {
        Route::get('default', [
            'uses' => 'ChargeController@default',
            'as' => 'order_charge_default',
            'display_name' => '结算收费',
            'visible' => true,
            'alias' => 'order_charge_list',
        ]);

        Route::get('/', [
            'uses' => 'ChargeController@index',
            'as' => 'order_charge_list',
            'display_name' => '待结算收费表',
            'visible' => true,
        ]);

        Route::post('/next', [
            'uses' => 'ChargeController@next',
            'as' => 'order_charge_next',
            'display_name' => '下一步',
            'visible' => false,
        ]);

        Route::post('/cancel', [
            'uses' => 'ChargeController@cancel',
            'as' => 'order_charge_cancel',
            'display_name' => '取消',
            'visible' => false,
        ]);

        Route::post('/back', [
            'uses' => 'ChargeController@back',
            'as' => 'order_charge_back',
            'display_name' => '退回',
            'visible' => false,
        ]);


        Route::put('/{order}', [
            'uses' => 'ChargeController@update',
            'as' => 'order_charge_update',
            'display_name' => '修改',
            'visible' => false,
        ]);
    });

    Route::group(['prefix' => 'close'], function () {
        Route::get('default', [
            'uses' => 'CloseController@default',
            'as' => 'order_close_default',
            'display_name' => '审核关闭',
            'visible' => true,
            'alias' => 'order_close_list',
        ]);

        Route::get('/', [
            'uses' => 'CloseController@index',
            'as' => 'order_close_list',
            'display_name' => '待审核关闭表',
            'visible' => true,
        ]);

        Route::post('/next', [
            'uses' => 'CloseController@next',
            'as' => 'order_close_next',
            'display_name' => '下一步',
            'visible' => false,
        ]);

        Route::post('/cancel', [
            'uses' => 'CloseController@cancel',
            'as' => 'order_close_cancel',
            'display_name' => '取消',
            'visible' => false,
        ]);

        Route::post('/back', [
            'uses' => 'CloseController@back',
            'as' => 'order_close_back',
            'display_name' => '退回',
            'visible' => false,
        ]);


        Route::put('/{order}', [
            'uses' => 'CloseController@update',
            'as' => 'order_close_update',
            'display_name' => '修改',
            'visible' => false,
        ]);
    });

    Route::group(['prefix' => 'review'], function () {
        Route::get('default', [
            'uses' => 'ReviewController@default',
            'as' => 'order_review_default',
            'display_name' => '客户回访',
            'visible' => true,
            'alias' => 'order_review_list',
        ]);

        Route::get('/', [
            'uses' => 'ReviewController@index',
            'as' => 'order_review_list',
            'display_name' => '待审核关闭表',
            'visible' => true,
        ]);

        Route::post('/next', [
            'uses' => 'ReviewController@next',
            'as' => 'order_review_next',
            'display_name' => '下一步',
            'visible' => false,
        ]);

        Route::post('/cancel', [
            'uses' => 'ReviewController@cancel',
            'as' => 'order_review_cancel',
            'display_name' => '取消',
            'visible' => false,
        ]);

        Route::post('/back', [
            'uses' => 'ReviewController@back',
            'as' => 'order_review_back',
            'display_name' => '退回',
            'visible' => false,
        ]);

        Route::put('/{order}', [
            'uses' => 'ReviewController@update',
            'as' => 'order_review_update',
            'display_name' => '修改',
            'visible' => false,
        ]);
    });
});
