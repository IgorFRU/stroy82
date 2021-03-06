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

Route::prefix('admin')->name('admin.')->middleware('admin.online')->group(function(){
  Route::get('/', 'AdminController@index')->name('index');
  Route::get('/settings/profile', 'AdminController@profile')->name('profile'); // редактирование соего профиля

  Route::get('/settings/clearcache', 'SettingController@clearCache')->name('clearcache'); // очистка всего кеша
  Route::get('/settings/migrate', 'SettingController@migrate')->name('migrate');
  Route::get('/settings/composer_install', 'SettingController@composerInstall')->name('composer_install');

  Route::put('/settings/profile', 'AdminController@profileUpdate')->name('profile.update'); // редактирование соего профиля
  Route::post('/settings/{id}', 'AdminController@settings')->name('settings');
  Route::get('/login/{token?}', 'Auth\AdminLoginController@showLoginForm')->name('login')->middleware('check.url.login.token');
  Route::post('/login', 'Auth\AdminLoginController@login')->name('login.submit');
  Route::post('/logout', 'Auth\AdminLoginController@adminLogout')->name('logout');
    
  Route::post('/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('password.email');    
  Route::get('/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('password.request');    
  Route::post('/password/reset', 'Auth\AdminResetPasswordController@reset');  
  Route::get('/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('password.reset');
  
  Route::post('/properties/store',  'PropertyController@store');
  Route::post('/properties/destroy',  'PropertyController@destroy');
  
  Route::post('/uploadimg',  'ImageController@store');
  // Route::any('/updateimg/{id}',  'ImageController@update');
  Route::resource('/categories', 'CategoryController');
  
  Route::resource('/articles', 'ArticleController');

  Route::resource('/sets', 'SetController');

  Route::post('/articles/addProducts', 'ArticleController@addProducts');

  Route::resource('/manufactures', 'ManufactureController');

  Route::resource('/orderstatuses', 'OrderstatusController');
  
  Route::resource('/products', 'ProductController');
  Route::post('/products/massdestroy', 'ProductController@massDestroy')->name('products.massdestroy');
  Route::post('/products/getcategoryproperties', 'ProductController@getCategoryProperties'); // во время создания товара при изменении категории подтягиваются параметры
  Route::post('/products/store/ajax', 'ProductController@storeAjax')->name('products.storeAjax');
  Route::post('/products/copy', 'ProductController@copy')->name('products.copy');
  Route::post('/products/published', 'ProductController@published')->name('products.published');
  Route::post('/products/unimported', 'ProductController@unimported')->name('products.unimported');
  Route::post('/products/search/ajax', 'ProductController@ajaxSearch'); // поиск товара для добавления к статье
  Route::get('/products/addImages/{product}', 'ProductController@addImages')->name('products.addImages');

  Route::get('/import-export', 'ImportexportController@index')->name('import-export.index');
  Route::any('/import-export/import', 'ImportexportController@import')->name('import-export.import');  
  Route::any('/import-export/update', 'ImportexportController@update')->name('import-export.update');
  Route::any('/import-export/export', 'ImportexportController@export')->name('import-export.export');
  // Route::get('/export/products', 'ProductController@export')->name('product.export');


  Route::post('/setcookie', 'ProductController@setCookie');

  Route::resource('/units', 'UnitController');
  Route::resource('/banners', 'BannerController');

  Route::post('/bannertag_add', 'BannertagController@store');
  Route::put('/bannertag_update', 'BannertagController@update');
  Route::get('/bannertag_get', 'BannertagController@getTag');
  Route::delete('/bannertag_delete', 'BannertagController@destroy');

  Route::resource('/consumers', 'ConsumerController');
  Route::get('/consumers/{consumer}', 'ConsumerController@consumer')->name('consumer');
  Route::get('/consumers/{consumer}/{order}', 'ConsumerController@order')->name('consumer.order');

  Route::post('/orders/changestatus', 'OrderController@changestatus');
  Route::get('/orders', 'OrderadminController@adminActiveOrders')->name('orders');  
  Route::get('/orders/hot', 'OrderadminController@adminHotOrders')->name('hot.orders');  
  Route::get('/orders/archive', 'OrderadminController@adminArchiveOrders')->name('archive.orders');  
  Route::get('/orders/{order}', 'OrderadminController@order')->name('order');

  Route::resource('/vendors', 'VendorController');
  Route::get('/discounts/archive', 'DiscountController@archive')->name('discounts.archive');
  Route::resource('/discounts', 'DiscountController');
  Route::any('/productimg', 'UploadImagesController@product')->name('product.image.upload');
  Route::resource('/topmenu', 'TopmenuController');
  Route::resource('/typeoptions', 'TypeoptionController');
});

Route::group(['middleware' => 'user.online'], function () {
  Route::get('/', 'MainController@index')->name('index');

  Route::get('/catalog/product/{product}', 'MainController@product2')->name('product.without_category');
  Route::get('/catalog', 'MainController@categories')->name('categories');
  Route::get('/catalog/{category}', 'MainController@category')->name('category');
  Route::get('/catalog/{category}/{product}', 'MainController@product')->name('product');
  
  Route::get('/articles', 'MainController@articles')->name('articles');
  Route::get('/articles/{article}', 'MainController@article')->name('article');
  
  Route::get('/sets', 'MainController@sets')->name('sets');
  Route::get('/sets/{set}', 'MainController@set')->name('set');
  
  Route::get('/sales', 'MainController@sales')->name('sales');
  Route::get('/sales/{sale}', 'MainController@sale')->name('sale');
  
  Route::get('/manufacture', 'MainController@manufactures')->name('manufactures');
  Route::get('/manufacture/{manufacture}', 'MainController@manufacture')->name('manufacture');
  
  Route::post('/setcookie', 'MainController@setCookie');
  
  Route::post('/cart', 'CartController@addItems');
  Route::post('/cart/change', 'CartController@changeQuantity'); // ajax change quantity of item in cart
  Route::delete('/cart/{id}', 'CartController@destroyItem')->name('cart.destroy');
  Route::get('/cart', 'CartController@showCart')->name('cart');
  
  Route::resource('/order', 'OrderController')->except(['show']);
  Route::get('/order/{order}', 'OrderController@showOrder')->name('orderShow');
  Route::post('/order/checkuserphone', 'OrderController@checkUserPhone')->name('checkUserPhone');
  Route::post('/order/checkorderstatus', 'OrderController@checkOrderStatus')->name('checkorderstatus');
  Route::post('/checkinn', 'OrderController@checkinn'); // ajax
  // Route::post('/order/final', 'OrderController@final')->name('order.final');
  
  Route::post('/firm/store', 'FirmController@firmStore');
  
  Route::get('/home', 'UserController@index')->name('home');

  Route::get('/user/logout', 'Auth\LoginController@userLogout')->name('user.logout');
  Route::post('/user/edit', 'UserController@userEdit')->name('user.edit');
  Route::get('/user/orders', 'OrderController@usersOrders')->name('usersOrders')->middleware('auth');
  Route::get('/user/order/{order}', 'OrderController@usersOrder')->name('usersOrder')->middleware('auth');
  Auth::routes();
  
  
  Route::get('/contacts', 'MainController@contacts')->name('contacts');
  Route::post('/contacts', 'MainController@sendQuestion')->name('send.question');
  Route::get('/search', 'SearchController@search')->name('search');
  Route::post('/search', 'SearchController@quickSearch');
  
  Route::get('/{staticpage}', 'MainController@staticpage')->name('staticpage');
});

// Route::get('/', 'MainController@comingsoon');