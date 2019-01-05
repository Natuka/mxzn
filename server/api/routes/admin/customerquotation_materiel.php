<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/6
 * Time: 10:30
 */
Route::group([
    'prefix' => 'customerquotation/materiel',
    'namespace' => 'Admin\Customer',
    'middleware' => ['auth:api', 'admin.api'],
], function () {
    Route::get('default', [
        'uses' => 'MaterielListController@default',
        'as' => 'customerquotation_materiel_default',
        'display_name' => '报件管理',
        'visible' => true,
        'alias' => 'customerquotation_materiel_list',
    ]);
    Route::get('/', [
        'uses' => 'MaterielListController@index',
        'as' => 'customerquotation_materiel_list',
        'display_name' => '报件管理列表',
        'visible' => true,
    ]);


});
