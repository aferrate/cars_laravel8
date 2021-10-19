<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'App\Http\Controllers\CarController@index')->name('car.index');
Route::get('/car/{slug}', 'App\Http\Controllers\CarController@getCarInfo')->name('car.getCarInfo');
Route::post('/car/search', 'App\Http\Controllers\CarController@searchCars')->name('car.searchCars');
Route::get('/elasticindexcarsadd', 'App\Http\Controllers\CarController@addElasticIndex')->name('car.addelasticindex');
Route::get('/elasticindexcarsdelete', 'App\Http\Controllers\CarController@deleteIndexCars')->name('car.deleteelasticindex');

Route::get('/admin', 'App\Http\Controllers\AdminCarController@list')->name('car_admin.list');
Route::get('/admin/create', 'App\Http\Controllers\AdminCarController@create')->name('car_admin.create');
Route::post('/admin/store', 'App\Http\Controllers\AdminCarController@store')->name('car_admin.store');
Route::get('/admin/edit/{id}', 'App\Http\Controllers\AdminCarController@edit')->name('car_admin.edit');
Route::put('/admin/update/{id}', 'App\Http\Controllers\AdminCarController@update')->name('car_admin.update');
Route::post('/admin/delete', 'App\Http\Controllers\AdminCarController@delete')->name('car_admin.delete');
Route::post('/admin/search', 'App\Http\Controllers\AdminCarController@searchCars')->name('car_admin.searchCars');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles','App\Http\Controllers\RoleController');
    Route::resource('users','App\Http\Controllers\UserController');
});
