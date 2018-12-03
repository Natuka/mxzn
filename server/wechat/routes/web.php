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

Route::get('/', 'IndexController@index');

//
Route::any('/wechat', 'WeChatController@serve');

Route::post('/login', 'User\AuthController@login');
Route::post('/user/create', 'User\CreateController@store');
Route::get('/user/info', 'User\IndexController@info');
Route::get('/config', 'WechatController@config');

// 微信必须验证
// 'wechat.oauth'
Route::group(['middleware' => []], function () {
    // 绑定手机号
    Route::get('/mobile/bind', 'User\MobileController@get');
    Route::post('/mobile/bind', 'User\MobileController@post');

    // 发送短信验证码
    Route::post('/sms/send', 'SmsController@post');

    // 机器报修
    Route::get('/machine/{machine}', 'Order\ConfirmController@get');
    // 机器
    Route::get('/equipment', 'Equipment\IndexController@index');

    // 机器报修
    Route::get('/repair/machine', 'Order\ConfirmController@get');
    Route::post('/repair/machine', 'Order\ConfirmController@post');

    Route::group(['prefix' => 'repair', 'namespace' => 'Order'], function () {
        // 订单列表
        Route::get('list', 'IndexController@index');
        Route::get('info/{order}', 'IndexController@get');

        // 签到
        Route::get('attendances/{order}', 'AttendanceController@get');
        // 处理
        Route::get('action/{order}', 'ActionController@get');
        // 附件
        Route::get('document/{order}', 'DocumentController@get');
        // 转派
        Route::get('change/{order}', 'ChangeController@get');
        // 完工
        Route::get('complete/{order}', 'CompleteController@get');
        // 配件耗材
        Route::get('equipment/{order}', 'EquipmentController@get');
        // 服务项目
        Route::get('service/{order}', 'ServiceController@get');
        // 操作记录
        Route::get('log/{order}', 'LogController@get');
        // 催单记录
        Route::get('followup/{order}', 'FollowupController@get');

        Route::post('create', 'CreateController@store');
        Route::post('evaluate/{order}', 'EvaluateController@store');
    });

    Route::group(['prefix' => 'user', 'namespace' => 'User'], function () {
        Route::get('info', 'UserController@info');
    });


    // 维修确认&评价
    Route::get('/repair/confirm', 'Order\ConfirmController@get');
    Route::post('/repair/confirm', 'Order\ConfirmController@post');
});
