<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\AuthController;




Route::get('books', 'App\Http\Controllers\SignController@signe');   
Route::get('store_image/fetch_imag/{id}', 'App\Http\Controllers\SignController@fetch_image');
Route::post('store_image/delete/{id}', 'App\Http\Controllers\SignController@destroy');
Route::apiResource('posts', 'App\Http\Controllers\SignController');

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        
        Route::post('register', 'App\Http\Controllers\AuthController@register');
        // Login User
        Route::post('login', 'App\Http\Controllers\AuthController@login');

        // insert signature
        Route::post('sign', 'App\Http\Controllers\SignController@insert_image');
        
        // Refresh the JWT Token
        Route::get('refresh', 'App\Http\Controllers\AuthController@refresh');
        
        // Below mention routes are available only for the authenticated users.
        Route::middleware('auth:api')->group(function () {
            // Get user info
            Route::get('user', 'App\Http\Controllers\AuthController@user');
            // Logout user from application
            Route::post('logout', 'App\Http\Controllers\AuthController@logout');
        });

    });

});