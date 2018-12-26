<?php

Route::group([
    'prefix' => 'select',
    'namespace' => 'Admin\Select',
    'middleware' => ['auth:api'],
], function () {
    Route::get('department', [
        'uses' => 'DepartmentController@index',
        'as' => 'select_organization'
    ]);
    // TODO 后续添加
});
