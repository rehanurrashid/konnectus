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


Route::post('/password/reset/number', 'API\UserController@send_reset_password')->name('custom.reset');

Route::post('/upload', 'API\FileController@upload');

Route::get('/places', 'API\PlaceController@show_all');

Route::get('/services', 'API\ServiceController@show_all');

Route::group(['middleware' => 'auth:api'], function(){
    
    Route::post('/password/update/number', 'API\UserController@restpass')->name('custom.update.pass');

	Route::post('/logout', 'API\UserController@logout');

	Route::post('/send_update', 'API\UserController@update');

	Route::get('/details', 'API\UserController@details');
	
	Route::get('user/places/', 'API\UserController@places');

	Route::get('user/services/', 'API\UserController@services');

	Route::post('/password/change', 'API\ChangePasswordController@change');

	Route::post('/place/search/{keyword?}{slug?}', 'API\PlaceController@search');
	Route::post('/place/add', 'API\PlaceController@store');
	Route::post('/place/rating/{id}', 'API\PlaceController@store_rating');

	Route::post('/service/add', 'API\ServiceController@store');
	Route::post('/service/rating/{id}', 'API\ServiceController@store_rating');
	
	Route::get('/categories', 'API\CategoryController@index');

	Route::get('/categories/place/popular', 'API\CategoryController@most_visited_place_category');
	Route::get('/categories/service/popular', 'API\CategoryController@most_visited_service_category');

	Route::get('/category/places/{id}', 'API\CategoryController@places');
	Route::get('/category/services/{id}', 'API\CategoryController@services');

	Route::get('/place/show/{id}', 'API\PlaceController@show');
	Route::get('/service/show/{id}', 'API\ServiceController@show');

	Route::get('/service/rating/{id}', 'API\ServiceController@show_rating');
	Route::get('/place/rating/{id}', 'API\PlaceController@show_rating');

	Route::get('phone/verify/{code}','API\UserController@phone_verify')->name('phone.verify');
    Route::get('phone/resend/','API\UserController@resend')->name('phone.resend');
});

	
	
