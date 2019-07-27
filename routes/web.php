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


Route::prefix('admin')->name('admin.')->group(function(){
  Route::get('/', 'AdminController@index')->name('index');
  Route::post('/settings', 'AdminController@settings')->name('settings');
  Route::get('/login/{token?}', 'Auth\AdminLoginController@showLoginForm')->name('login')->middleware('check.url.login.token');
  Route::post('/login', 'Auth\AdminLoginController@login')->name('login.submit');
  Route::post('/logout', 'Auth\AdminLoginController@adminLogout')->name('logout');
    
  Route::post('/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('password.email');    
  Route::get('/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('password.request');    
  Route::post('/password/reset', 'Auth\AdminResetPasswordController@reset');  
  Route::get('/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('password.reset');
  
  Route::resource('/categories', 'CategoryController');
  Route::resource('/products', 'ProductController');
  // Route::get('/products', 'ProductController');
});

Route::get('/home', 'UserController@index')->name('home');
