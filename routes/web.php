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

Route::middleware(['role:super-administrador'])->get('/admin/{vue_capture?}', function () {
    return view('vue.index');
})->where('vue_capture', '[\/\w\.-]*');

Route::group(['prefix' => 'admin', 'middleware' => ['role:super-administrador']], function () {
    Route::resource('attributes', 'Admin\AttributeController', ["as" => 'admin']);
    Route::resource('categories', 'Admin\CategoryController', ["as" => 'admin']);
    Route::resource('parameters', 'Admin\ParameterController', ["as" => 'admin']);
    Route::resource('products', 'Admin\ProductController', ["as" => 'admin']);
    Route::resource('purchases', 'Admin\PurchaseController', ["as" => 'admin']);
});

