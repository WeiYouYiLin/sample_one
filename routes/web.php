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

/*Route::get('/', function () {
    return view('welcome');
});*/
// 主页
Route::get('/','StaticPagesController@home')->name('home');
// 帮助页
Route::get('/help','StaticPagesController@help')->name('help');
// 关于页
Route::get('/about','StaticPagesController@about')->name('about');
// 注册
Route::get('/signup','UsersController@create')->name('signup');

// 用户资源路由
Route::resource('users','UsersController');
// 等同于
// Route::get('/users','UsersController@index')->name('users.index');
// Route::get('/users/{user}','UserController@show')->name('users.show');
// Route::get('/users/create','UsersController@create')->name('users.create');
// Route::post('/users','UsersController@store')->name('users.store');
// Route::get('/users/{user}/edit','UsersController@edit')->name('users.edit');
// Route::patch('/users/{user}','UserController@update')->name('users.update');
// Route::delete('/user/{user}','UsersController@destroy')->name('user.destroy');

// 用户登录页面
Route::get('login','SessionsController@create')->name('login');
// 用户登录操作
Route::post('login','SessionsController@store')->name('login');
// 用户退出登录
Route::delete('logout','SessionsController@destroy')->name('logout');

// 注册激活邮箱
Route::get('signup/confirm/{token}','UsersController@confirmEmail')->name('confirm_email');

// 显示重置密码的邮箱发送页面
Route::get('password/reset','Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
// 邮箱发送重设链接
Route::post('password/email','Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
// 点击重置密码连接,显示密码更新页面
Route::get('password/reset/{token}','Auth\ResetPasswordController@showResetForm')->name('password.reset');
// 执行重置密码操作
Route::post('password/reset','Auth\ResetPasswordController@reset')->name('password.update');

Route::get('test','UsersController@test')->name('users.test');

// 微博的创建和删除
//Route::resource('statuses','StatusesController',['only'=> ['store','destroy']]);

Route::resource('statuses', 'StatusesController', ['only' => ['store', 'destroy']]);
