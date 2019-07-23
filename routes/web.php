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

Route::group(['prefix' => 'admin'], function(){
  Route::get('/', 'AdminController@index')->name('admin.index');
  Route::get('/login/{token?}', 'Auth\AdminLoginController@showLoginForm')->name('admin.login')->middleware('check.url.login.token');
  Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    
    
});
Auth::routes();
Route::get('/home', 'UserController@index')->name('home');
