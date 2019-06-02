<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



//
Route::any('/wechat', 'WechatController@serve');

Route::post('/login', 'User\AuthController@login');
Route::post('/user/create', 'User\CreateController@store');
Route::get('/user/info', 'User\IndexController@info');
Route::get('/config', 'WechatController@config');

Route::get('/debug', 'DebugController@index');
Route::get('/menu/list', 'MenuController@index');
Route::get('/menu/create', 'MenuController@create');

Route::get('order/{order}', 'Order\IndexController@get');

Route::get('/fileBack/image', 'File\ImageController@get');

// 微信必须验证
// 'wechat.oauth' 'wechat.oauth','auth'
// 调试时，可以先删除，在正式环境上，在加回去 'wechat.oauth'
Route::group(['middleware' => []], function () {

//    需要验证登录，调试时可以先删除，在正式环境上，在加回去 'auth'
    Route::group(['middleware' => ['auth']], function () {

        Route::group(['prefix' => 'repair', 'namespace' => 'Order'], function () {
            // 订单列表
            Route::get('list', 'IndexController@index');
            Route::get('{order}/info', 'IndexController@get');

            // 签到
            Route::get('{order}/attendances', 'AttendanceController@get');

            // 签到提交
            Route::post('{order}/attendance', 'AttendanceController@store');
            // 处理
            Route::get('action/{order}', 'ActionController@get');

            Route::get('/{order}/repair', 'RepairController@index');
            Route::post('/{order}/repair', 'RepairController@store');
            Route::post('/{order}/repair/{repair}', 'RepairController@update');
            // 附件
            Route::get('{order}/document', 'DocumentController@get');
            // 转派
            Route::get('{order}/change', 'ChangeController@get');
            // 完工
            Route::get('{order}/complete', 'CompleteController@get');
            // 配件耗材
            Route::get('{order}/equipment', 'EquipmentController@get');
            // 服务项目
            Route::get('{order}/service', 'ServiceController@get');
            // 操作记录
            Route::get('{order}/log', 'LogController@get');
            // 催单记录
            Route::get('{order}/followup', 'FollowupController@get');

            Route::post('create', 'CreateController@store');
            Route::post('evaluate/{order}', 'EvaluateController@store');
            Route::get('evaluate/last', 'EvaluateController@last');
            Route::get('evaluate/list', 'EvaluateController@index');
            Route::get('evaluate/list', 'EvaluateController@index');

            Route::get('detail', 'RepairController@info');
        });

        // 维修确认&评价
        Route::get('/repair/confirm', 'Order\ConfirmController@get');
        Route::post('/repair/confirm', 'Order\ConfirmController@post');

        // 机器
        Route::get('/equipment', 'Equipment\IndexController@index');
        Route::post('/equipment/create', 'Equipment\IndexController@store');
    });
    Route::get('/', 'IndexController@index');
    Route::get('/geo', 'GeoController@get');

    // 绑定手机号
    Route::get('/mobile/bind', 'User\BindController@get');
    Route::post('/mobile/bind', 'User\BindController@postBind');
    Route::post('/upload', 'UploadController@post');

    // 机器码
    Route::get('machine/{code}', 'MachineController@get');
    Route::get('machine/{code}/info', 'MachineController@info');

    Route::get('menu/equipment', 'MenuController@equipment');
    Route::get('menu/service-orders', 'MenuController@serviceOrders');
    Route::get('menu/evaluate', 'MenuController@evalute');
    Route::get('menu/evaluate/{order_id}', 'MenuController@evaluteByServiceOrderId');
    Route::get('menu/service-order-create', 'MenuController@serviceOrderCreate');

    Route::group([
        'prefix' => 'select',
        'namespace' => 'Select',
    ], function () {
        Route::get('/project', [
            'uses' => 'ProjectController@index',
            'as' => 'project_index',
            'display_name' => '项目选择',
        ]);
        Route::get('/part', [
            'uses' => 'PartController@index',
            'as' => 'part_index',
            'display_name' => '部件选择',
        ]);
        Route::get('/engineer', [
            'uses' => 'EngineerController@index',
            'as' => 'engineer_index',
            'display_name' => '工程师选择',
        ]);
    });

    Route::group([
        'prefix' => 'file',
        'namespace' => 'File',
    ], function () {
        Route::get('/doc', [
            'uses' => 'DocController@get',
            'as' => 'doc_get',
            'display_name' => '文件',
        ]);

        Route::get('/doc/list', [
            'uses' => 'DocController@getList',
            'as' => 'doc_list',
            'display_name' => '文件列表',
        ]);

        Route::post('/doc', [
            'uses' => 'DocController@store',
            'as' => 'image_store',
            'display_name' => '文件保存',
        ]);

        Route::get('/image', [
            'uses' => 'ImageController@get',
            'as' => 'image_get',
            'display_name' => '图片保存',
        ]);

        Route::post('/image', [
            'uses' => 'ImageController@store',
            'as' => 'image_store',
            'display_name' => '图片保存',
        ]);
    });

    // 发送短信验证码
    Route::post('/sms/send', 'SmsController@post');

    // 机器报修
    Route::get('/machine/{machine}', 'Order\ConfirmController@get');

    // 机器报修
    Route::get('/repair/machine', 'Order\ConfirmController@get');
    Route::post('/repair/machine', 'Order\ConfirmController@post');

    Route::group(['prefix' => 'user', 'namespace' => 'User'], function () {
        Route::get('info', 'UserController@info');
    });

});
