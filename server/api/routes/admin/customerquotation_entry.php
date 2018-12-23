<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/6
 * Time: 10:30
 */
Route::group([
    'prefix' => 'customerquotation/{quotation}/materiel',
    'namespace' => 'Admin\Customer',
    'middleware' => ['auth:api', 'admin.api'],
], function () {
    Route::get('default', [
        'uses' => 'MaterielController@default',
        'as' => 'customerquotation_materiel_default',
        'display_name' => '报价单-配件耗材',
        'visible' => true,
        'alias' => 'customerquotation_materiel_list',
    ]);
    Route::get('/', [
        'uses' => 'MaterielController@index',
        'as' => 'customerquotation_materiel_list',
        'display_name' => '报价单-配件耗材列表',
        'visible' => true,
    ]);

    Route::post('/', [
        'uses' => 'MaterielController@store',
        'as' => 'customerquotation_materiel_create',
        'display_name' => '报价单-配件耗材新增',
        'visible' => false,
    ]);

    Route::put('/{quotationentry}', [
        'uses' => 'MaterielController@update',
        'as' => 'customerquotation_materiel_update',
        'display_name' => '报价单-配件耗材修改',
        'visible' => false,
    ]);

    Route::delete('/{quotationentry}', [
        'uses' => 'MaterielController@destroy',
        'as' => 'customerquotation_materiel_delete',
        'display_name' => '报价单-配件耗材删除',
        'visible' => false,
    ]);

});
