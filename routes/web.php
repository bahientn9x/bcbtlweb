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

Route::get('/','HomeController@index');

Route::get('login', function() {
    return view('login');
});

Route::resource('product', 'User\ProductController');
Route::resource('adminrecharge','Admin\RechargeController');
Route::resource('recharge','User\RechargeController');
Route::resource('withdrawal','User\WithdController');
Route::get('bankreceivemoney/{bankname}','User\RechargeController@bankreceivemoney');
Route::get('bankwithdmoney/{bankname}','User\WithdController@bankwithdmoney');
Route::get('withdrawal/confirmation/{token}','User\WithdController@confirmation')->name('confirmation');
Route::resource('adminwithdrawal','Admin\WithdrawalController');
Route::resource('adminmanagertrade','Admin\ManagerTradeController');
Route::resource('bank','Admin\bankController');
Route::resource('bankadmin','Admin\BankAdminController');


Route::resource('profile/payment', 'User\BankMemberController');
Route::resource('order', 'User\OrderController');
Route::resource('home', 'User\HomeController');
Route::resource('cate', 'User\CategoryController');


Route::post('checkDeposit', 'User\UserController@checkDeposit');

Route::post('destroyTrans', 'User\OrderController@destroyTrans');

Route::post('destroyOrder', 'User\OrderController@destroyOrder');

Route::post('addProduct', 'User\ProductController@addProduct');

Route::post('uploadImage', 'User\ProductController@uploadImage');

Route::get('product/create/sell', 'User\ProductController@sell');

Route::get('product/create/buy', 'User\ProductController@buy');

Route::get('profile/manager', 'User\OrderController@index');

Route::post('profile/update/{id}', [
	'uses' => 'User\ProfileController@update',
	'as' => 'profile.update',
]);

Route::post('payment/store', [
	'uses' => 'User\BankMemberController@store',
	'as' => 'payment.store',
]);

Route::post('payment/update/{id}', [
	'uses' => 'User\BankMemberController@update',
	'as' => 'payment.update',
]);

Route::post('payment/destroy/{id}', [
	'uses' => 'User\BankMemberController@destroy',
	'as' => 'payment.destroy',
]);

Route::post('manager/destroy/{id}', [
	'uses' => 'User\OrderController@destroy',
	'as' => 'manager.destroy',
]);

Route::post('profile/change-password', [
	'uses' => 'User\ProfileController@changePassword',
	'as' => 'profile.password',
]);

Route::get('profile', 'User\ProfileController@index');

Route::get('profile/change-password', 'User\ProfileController@viewChangePassword');

Route::get('profile/history', 'User\ProfileController@viewHistory');

Route::get('profile/order-status/{id}', 'User\ProfileController@orderSatus');

Route::post('depositOrder', 'User\OrderController@depositOrder');

Route::post('confirmSent', 'User\OrderController@confirmSent');

Route::post('confirmReceived', 'User\OrderController@confirmReceived');

Route::get('getProduct/{id}', 'User\ProductController@getProduct');

Route::post('checkOrder', 'User\OrderController@checkOrder');

Route::get('checkProfile', 'User\UserController@checkProfile');

Route::get('unreadNotifi', 'User\ProfileController@unreadNotifi');

Auth::routes();

/* route admin */

Route::get('admin/login', 'Auth\Admin\AdminLoginController@showLoginForm')->name('admin.login');

Route::get('admin/logout', 'Auth\Admin\AdminLoginController@logout') ->name('admin.logout');

Route::get('admin/dashboard', 'Admin\DashboardController@index');

Route::post('admin/login/submit', [
	'uses' => 'Auth\Admin\AdminLoginController@login',
	'as' => 'admin.login.submit'
]);

Route::resource('admin/members', 'Admin\MemberController');

Route::post('admin/member/destroy/{id}', [
	'uses' => 'Admin\MemberController@destroy',
	'as' => 'admin.member.destroy',
]);


Route::resource('admin/members', 'Admin\MemberController');

Route::post('admin/member/destroy/{id}', [
	'uses' => 'Admin\MemberController@destroy',
	'as' => 'admin.member.destroy',
]);


Route::post('admin/product/destroy/{id}', [
	'uses' => 'Admin\ProductController@destroy',
	'as' => 'admin.product.destroy',
]);

Route::post('admin/product/change-state/{id}', [
	'uses' => 'Admin\ProductController@changeState',
	'as' => 'admin.product.changeState',
]);

Route::resource('admin/orders', 'Admin\OrderController');

Route::post('admin/order/destroy/{id}', [
	'uses' => 'Admin\OrderController@destroy',
	'as' => 'admin.order.destroy',
]);

Route::post('admin/order/update/{id}', [
	'uses' => 'Admin\OrderController@update',
	'as' => 'admin.order.update',
]);



