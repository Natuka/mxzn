<?php

Route::group([
    'prefix' => 'areas',
    'namespace' => 'Admin\Area',
    // 'middleware' => 'auth:api',
], function () {

    Route::get('{id}/list/{level}', [
        'uses' => 'IndexController@show',
        'as' => 'area_list',
        'display_name' => '地区列表',
        'visible' => false,
    ]);

    Route::get('cities', [
        'uses' => 'IndexController@cities',
        'as' => 'area_cities_list',
        'display_name' => '城市列表',
        'visible' => false,
    ]);
    Route::get('districts', [
        'uses' => 'IndexController@districts',
        'as' => 'area_districts_list',
        'display_name' => '区县列表',
        'visible' => false,
    ]);
    Route::get('provinces', [
        'uses' => 'IndexController@provinces',
        'as' => 'area_provinces_list',
        'display_name' => '省份列表',
        'visible' => false,
    ]);

});
