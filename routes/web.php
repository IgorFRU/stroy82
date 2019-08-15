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

Route::get('/', 'MainController@index');



Route::prefix('admin')->name('admin.')->group(function(){
  Route::get('/', 'AdminController@index')->name('index');
  Route::post('/settings/{id}', 'AdminController@settings')->name('settings');
  Route::get('/login/{token?}', 'Auth\AdminLoginController@showLoginForm')->name('login')->middleware('check.url.login.token');
  Route::post('/login', 'Auth\AdminLoginController@login')->name('login.submit');
  Route::post('/logout', 'Auth\AdminLoginController@adminLogout')->name('logout');
    
  Route::post('/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('password.email');    
  Route::get('/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('password.request');    
  Route::post('/password/reset', 'Auth\AdminResetPasswordController@reset');  
  Route::get('/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('password.reset');
  
  Route::post('/uploadimg',  'ImageController@store');
  // Route::any('/updateimg/{id}',  'ImageController@update');
  Route::resource('/categories', 'CategoryController');
  Route::resource('/articles', 'ArticleController');
  Route::post('/articles/addProducts', 'ArticleController@addProducts');
  Route::resource('/manufactures', 'ManufactureController');
  Route::resource('/products', 'ProductController');
  Route::post('/products/store/ajax', 'ProductController@storeAjax')->name('products.storeAjax');
  Route::post('/products/search/ajax', 'ProductController@ajaxSearch'); // поиск товара для добавления к статье
  Route::get('/products/addImages/{product}', 'ProductController@addImages')->name('products.addImages');
  Route::resource('/units', 'UnitController');
  Route::resource('/vendors', 'VendorController');
  Route::get('/discounts/archive', 'DiscountController@archive')->name('discounts.archive');
  Route::resource('/discounts', 'DiscountController');
  Route::any('/productimg', 'UploadImagesController@product')->name('product.image.upload');
});

Route::get('/home', 'UserController@index')->name('home');

Route::get('/user/logout', 'Auth\LoginController@userLogout')->name('user.logout');
Auth::routes();
