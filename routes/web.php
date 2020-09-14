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

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'admin'], function () {
    Route::resource('attributes', 'Admin\AttributeController', ["as" => 'admin']);
    Route::resource('categories', 'Admin\CategoryController', ["as" => 'admin']);
});


Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->middleware('verified');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['prefix' => 'admin'], function () {
    Route::resource('attributeValues', 'Admin\AttributeValueController', ["as" => 'admin']);
});


Route::group(['prefix' => 'admin'], function () {
    Route::resource('parameters', 'Admin\ParameterController', ["as" => 'admin']);
});


Route::group(['prefix' => 'admin'], function () {
    Route::resource('products', 'Admin\ProductController', ["as" => 'admin']);
});
