<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Admin routes for your application.
|
*/

Auth::routes(['verify' => true]);

Route::group(['middleware' => ['role:super-administrador|administrador']], function () {
    Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'auth'], function () {
        Route::get('users', ['uses' => 'UserController@index'])->name('admin.users.index');
        Route::get('roles', ['uses' => 'RoleController@index'])->name('admin.roles.index');
        Route::get('permissions', ['uses' => 'PermissionController@index'])->name('admin.permissions.index');
    });
});
