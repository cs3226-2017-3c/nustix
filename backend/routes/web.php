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

/*
	Routes
*/

Route::get('snap', 'UploadControllerNew@viewUpload');
Route::post('snap', 'UploadControllerNew@storeUpload');


Route::get('tell', 'CreateControllerNew@viewCreate');
Route::post('tell', 'CreateControllerNew@storeCreate');


Route::get('detail/{id}', 'DetailController@getView');
Route::get('image/{id}', 'DetailController@getImage');
Route::get('caption', 'DetailController@getCaptions');
Route::get('caption/{id}', 'DetailController@getCaption');
Route::put('caption/{id}', 'DetailController@likeCaption');

// deleting and approving captions
Route::post('caption/{id}/delete', 'DetailController@deleteCaption');
Route::post('caption/{id}/approve', 'DetailController@approveCaption');

Route::get('newlikes', 'CharacterNewLikeController@getAll');

Route::get('/', 'HomeController@home');


Route::get('admin', 'AdminController@admin');
Auth::routes();

Route::get('/home', 'HomeController@index');

// Authentication Routes...
Route::get('123', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('123', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');