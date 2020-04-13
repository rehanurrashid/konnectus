<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', 'API\UserController@login');
Route::post('/send_register', 'API\UserController@register');

Route::post('/password/email', 'API\ForgotPasswordController@sendResetLinkEmail');

Route::post('/password/reset', 'API\ResetPasswordController@reset')->name('custom.password.update');

Route::post('/upload', 'API\FileController@upload');

Route::get('/places', 'API\PlaceController@show_all');

Route::get('/services', 'API\ServiceController@show_all');

Route::group(['middleware' => 'auth:api'], function(){

	Route::post('/logout', 'API\UserController@logout');

	Route::post('/send_update', 'API\UserController@update');

	Route::get('/details', 'API\UserController@details');
	
	Route::get('user/places/', 'API\UserController@places');

	Route::get('user/services/', 'API\UserController@services');

	Route::post('/password/change', 'API\ChangePasswordController@change');

	Route::get('/categories', 'API\CategoryController@index');

	Route::get('/category/places/{id}', 'API\CategoryController@places');
	Route::post('/place/add', 'API\PlaceController@store');
	Route::get('/place/show/{id}', 'API\PlaceController@show');
	Route::post('/place/rating/{id}', 'API\PlaceController@store_rating');
	Route::get('/place/rating/{id}', 'API\PlaceController@show_rating');

	Route::get('/category/services/{id}', 'API\CategoryController@services');
	Route::post('/service/add', 'API\ServiceController@store');
	Route::get('/service/show/{id}', 'API\ServiceController@show');
	Route::post('/service/rating/{id}', 'API\ServiceController@store_rating');
	Route::get('/service/rating/{id}', 'API\ServiceController@show_rating');
});
