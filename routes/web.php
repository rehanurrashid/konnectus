<?php
 
// use App\Mail\WelcomeEmail;
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



// Auth::routes();

Route::match(['get','post'],'/home', 'HomeController@index');

// Admin Routes 

Route::get('admin/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('admin/login', 'Auth\LoginController@login')->name('admin.login');
Route::post('admin/logout', 'Auth\LoginController@logout')->name('admin.logout');

// Password Reset Routes...
Route::post('password/email', [
  'as' => 'password.email',
  'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail'
]);
Route::get('password/reset', [
  'as' => 'password.request',
  'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm'
]);
Route::post('password/reset', [
  'as' => 'password.update',
  'uses' => 'Auth\ResetPasswordController@reset'
]);
Route::get('password/reset/{token}', [
  'as' => 'password.reset',
  'uses' => 'Auth\ResetPasswordController@showResetForm'
]);

Route::post('admin/logout', 'Auth\LoginController@logout')->name('admin.logout');

Route::prefix('admin')->middleware(['auth:web','check.role:admin'])->group(function () {

	Route::get('dashboard','AdminController@index')->name('admin.dashboard');
  
  	Route::get('acount-settings/{id}/edit','AdminController@edit')->name('admin.account.edit');
  	Route::put('acount-settings/{id}','AdminController@update')->name('admin.account.update');

    Route::resource('content_settings', 'ContentSettingController');
  	Route::resource('users', 'UserController');
    Route::resource('posts', 'PostController');
  	Route::resource('categories','CategoryController');
  	Route::post('dependent/category','CategoryController@fetch')->name('dynamicdependent.fetch');
  	
  	Route::resource('places','PlaceController');
    Route::post('add/place/notes','PlaceController@add_note')->name('add.place.note');

  	Route::resource('pending_places','PendingPlaceController');
    Route::resource('disapproved_places','DisapprovedPlaceController');
    

    Route::resource('services','ServiceController');
    Route::post('add/service/notes','ServiceController@add_note')->name('add.service.note');
    
  	Route::resource('pending_services','PendingServiceController');
    Route::resource('disapproved_services','DisapprovedServiceController');
});

// Front end User Side Routes

Route::get('/', 'HomeController@home')->name('home');
Route::get('/blog/{slug}', 'HomeController@single')->name('single');