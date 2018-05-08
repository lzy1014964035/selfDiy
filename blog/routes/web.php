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

Route::get('/home', 'index\IndexController@returnView');

/**
 * 后台部分
 */
Route::group(['middleware' => ['back']], function () {
    // 主页
    Route::get('/back', 'Back\Index\IndexController@index');
    // 用户 AdminController
    Route::get('/back/adminLogin', 'Back\Admin\AdminController@adminLogin');
    Route::post('/back/adminLoginDeal', 'Back\Admin\AdminController@adminLoginDeal');
    Route::get('/back/adminCancelLogin', 'Back\Admin\AdminController@adminCancelLogin');
});


