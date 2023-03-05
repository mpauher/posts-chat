<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ChatController;

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

Route::get('/', function () {
    return "welcome";
});

//Unprotected routes 
Route::post('register', [UserController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

//Protected routes
Route::group([
    'middleware' => 'auth:api',
], function ($router) {

    //Autentication
    Route::group([
        'prefix' => 'auth'
    ], function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh',[AuthController::class, 'refresh']);
        Route::post('me', [AuthController::class, 'me']);
    });

    //Users 
    Route::group([
        'prefix' => 'users'
    ], function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });

    //Services
    Route::group([
        'prefix' => 'services'
    ], function () {
        Route::get('/', [ServiceController::class, 'index']);
        Route::get('/{id}', [ServiceController::class, 'show']);
        Route::post('/', [ServiceController::class, 'create']);
        Route::put('/{id}', [ServiceController::class, 'update']);
        Route::delete('/{id}', [ServiceController::class, 'destroy']);
    });

        //Chats
        Route::group([
            'prefix' => 'chats'
        ], function () {
            Route::get('/', [ChatController::class, 'index']);
            // Route::get('/{id}', [ServiceController::class, 'show']);
            Route::post('/{id}', [ChatController::class, 'create']);
            // Route::put('/{id}', [ServiceController::class, 'update']);
            // Route::delete('/{id}', [ServiceController::class, 'destroy']);
        });


});
