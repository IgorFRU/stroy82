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

// Route::get('/admin/login/{token?}', 'Auth\LoginController@showLoginForm')->name('auth.login')->middleware('check.url.login.token');
// Route::post('/admin/login', 'Auth\LoginController@login')->name('admin.login.post');
// Route::get('/admin/logout', 'Auth\LoginController@logout')->name('auth.logout');
Auth::routes();
Route::get('/user/logout', 'Auth\LoginController@userLogout')->name('user.logout');


Route::group(['prefix' => 'admin'], function(){
  Route::get('/', 'AdminController@index')->name('admin.index');
  Route::post('/settings', 'AdminController@settings')->name('admin.settings');
  Route::get('/login/{token?}', 'Auth\AdminLoginController@showLoginForm')->name('admin.login')->middleware('check.url.login.token');
  Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
  Route::get('/logout', 'Auth\AdminLoginController@adminLogout')->name('admin.logout');
    
  Route::post('/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');    
  Route::get('/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');    
  Route::post('/password/reset', 'Auth\AdminResetPasswordController@reset');  
  Route::get('/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');    

  // Route::get('/');
});

Route::get('/home', 'UserController@index')->name('home');
