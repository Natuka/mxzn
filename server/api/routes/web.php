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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/fileBack/image', 'Admin\File\ImageController@get');

Route::get('/fileBack/doc', 'Admin\File\DocController@get');

load_routes(__DIR__ . '/admin');


