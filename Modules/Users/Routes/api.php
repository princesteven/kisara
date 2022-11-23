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

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [\Modules\Users\Http\Controllers\Auth\AuthController::class, 'login']);

        Route::middleware('auth:api')->group(function () {
            Route::post('logout', [\Modules\Users\Http\Controllers\Auth\AuthController::class, 'logout']);

            Route::get('user', [\Modules\Users\Http\Controllers\Auth\AuthController::class, 'user']);
        });
    });

    Route::middleware('auth:api')->group(function () {
        Route::resource('users', \Modules\Users\Http\Controllers\UsersController::class);

        Route::resource('roles', \Modules\Users\Http\Controllers\RolesController::class);
    });
});
