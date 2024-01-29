<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'api', 'prefix' => 'v1'], function ($router) {

    Route::group(['middleware' => ['jwt.verify']], function() { //jwt verified routes

        Route::group(['prefix' => 'auth'], function() { //auth routes
            Route::controller(\App\Http\Controllers\Api\AuthController::class)->group(function () {
                Route::post('logout',  'logoutUser');
                Route::post('refresh',  'refreshAuthToken');
                Route::get('profiles', 'getUserProfile');
                Route::post('login','loginUser')->withoutMiddleware('jwt.verify');
            });
        }); //end of auth

        Route::group(['prefix' => 'tasks'], function() { // tasks routes
            Route::controller(\App\Http\Controllers\Api\TaskController::class)->group(function () {
                Route::post('create', 'store')->withoutMiddleware(['jwt.verify']);
                Route::get('all', 'index');
                Route::get('single/{slug}', 'show');
                Route::patch('update/{slug}', 'update');
                Route::delete('delete/{slug}', 'destroy');
            });
        }); //end of tasks


    }); //end of route

});
