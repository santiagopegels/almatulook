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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'admin'], function () {
    // resources
    Route::resource('roles', 'Admin\RoleAPIController');
    Route::resource('permissions', 'Admin\PermissionAPIController');
    Route::resource('users','Admin\UserAPIController');
    Route::resource('attributes', 'Admin\AttributeAPIController');
    Route::resource('categories', 'Admin\CategoryAPIController');
    Route::resource('values', 'Admin\ValueAPIController');
    Route::resource('attribute_values', 'Admin\AttributeValueAPIController');


    // get all
    Route::get('users_all', ['uses' => 'Admin\UserAPIController@all']);
    Route::get('roles_all', ['uses' => 'Admin\RoleAPIController@all']);
    Route::get('permissions_all', ['uses' => 'Admin\PermissionAPIController@all']);
    Route::get('values_all', ['uses' => 'Admin\ValueAPIController@all']);
    Route::get('attributes_all', ['uses' => 'Admin\AttributeAPIController@all']);
    Route::get('categories_all', ['uses' => 'Admin\CategoryAPIController@all']);

    // restore
    Route::post('roles/{id}/restore', ['uses' => 'Admin\RoleAPIController@restore']);
    Route::post('permissions/{id}/restore', ['uses' => 'Admin\PermissionAPIController@restore']);
    Route::post('users/{id}/restore', ['uses' => 'Admin\UserAPIController@restore']);
    Route::post('attributes/{id}/restore', ['uses' => 'Admin\AttributeAPIController@restore']);
    Route::post('values/{id}/restore', ['uses' => 'Admin\ValueAPIController@restore']);

});
