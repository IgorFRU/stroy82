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

// Auth::routes();
Route::get('/admin/login/{token?}', 'Auth\LoginController@showLoginForm')
        ->name('auth.login')
        ->middleware('check.url.login.token');
Route::post('/admin/login', 'Auth\LoginController@login')->name('admin.login.post');
Route::get('/admin/logout', 'Auth\LoginController@logout')->name('auth.logout');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['is.admin']], function(){
    Route::get('/', 'CoreController@core')->name('admin.core');
    Route::resource('/category', 'CategoryController', ['as'=>'admin']);
    
    
});

Route::get('/home', 'HomeController@index')->name('home');
