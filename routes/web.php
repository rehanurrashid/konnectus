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



Auth::routes();

Route::view('/', 'welcome',['name' => 'Konnectus']);

Route::match(['get','post'],'/home', 'HomeController@index')->name('home');

// Admin Routes 

Route::post('admin/logout', 'Auth\LoginController@logout')->name('admin.logout');

Route::prefix('admin')->middleware(['auth:web','check.role:admin'])->group(function () {

	Route::get('dashboard','AdminController@index')->name('admin.dashboard');
  	Route::get('acount-settings/{id}/edit','AdminController@edit')->name('admin.account.edit');
  	Route::put('acount-settings/{id}','AdminController@update')->name('admin.account.update');


  	Route::resource('users', 'UserController');
  	Route::resource('categories','CategoryController');
  	Route::post('dependent/category','CategoryController@fetch')->name('dynamicdependent.fetch');
  	Route::resource('services','ServiceController');
  	Route::resource('places','PlaceController');
});
