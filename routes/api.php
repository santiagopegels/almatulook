<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function () {
    // resources
    Route::resource('roles', 'Admin\RoleAPIController');
    Route::resource('permissions', 'Admin\PermissionAPIController');
    Route::resource('users','Admin\UserAPIController');
    Route::resource('attributes', 'Admin\AttributeAPIController');
    Route::resource('categories', 'Admin\CategoryAPIController');
    Route::resource('values', 'Admin\ValueAPIController');
    Route::resource('parameters', 'Admin\ParameterAPIController');
    Route::resource('products', 'Admin\ProductAPIController');
    Route::resource('purchases', 'Admin\PurchaseAPIController');
    Route::resource('purchase_details', 'Admin\PurchaseDetailAPIController');
    Route::resource('shipment_types', 'Admin\ShipmentTypeAPIController');


    // get all
    Route::get('users_all', ['uses' => 'Admin\UserAPIController@all']);
    Route::get('roles_all', ['uses' => 'Admin\RoleAPIController@all']);
    Route::get('permissions_all', ['uses' => 'Admin\PermissionAPIController@all']);
    Route::get('values_all', ['uses' => 'Admin\ValueAPIController@all']);
    Route::get('attributes_all', ['uses' => 'Admin\AttributeAPIController@all']);
    Route::get('categories_all', ['uses' => 'Admin\CategoryAPIController@all']);
    Route::get('products_all', ['uses' => 'Admin\ProductAPIController@all']);

    // restore
    Route::post('roles/{id}/restore', ['uses' => 'Admin\RoleAPIController@restore']);
    Route::post('permissions/{id}/restore', ['uses' => 'Admin\PermissionAPIController@restore']);
    Route::post('users/{id}/restore', ['uses' => 'Admin\UserAPIController@restore']);
    Route::post('attributes/{id}/restore', ['uses' => 'Admin\AttributeAPIController@restore']);
    Route::post('values/{id}/restore', ['uses' => 'Admin\ValueAPIController@restore']);
    Route::post('categories/{id}/restore', ['uses' => 'Admin\CategoryAPIController@restore']);
    Route::post('shipment_types/{id}/restore', ['uses' => 'Admin\ShipmentTypeAPIController@restore']);

    //extra
    Route::post('product/{product_id}/deleteStock', ['uses' => 'Admin\ProductAPIController@deleteStock']);
});

Route::get('products', 'ProductAPIController@index');
Route::get('attributes_all', 'AttributeAPIController@all');
Route::get('categories_all', 'CategoryAPIController@all');
Route::get('user_logged', 'UserAPIController@getUserLogged');
Route::post('profiles', 'ProfileAPIController@updateProfile');
Route::get('profiles', 'ProfileAPIController@index');
