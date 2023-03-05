<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

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

    //Orders
    // Route::group([
    //     'prefix' => 'orders'
    // ], function () {
    //     Route::get('/', [OrderController::class, 'index']);
    //     Route::get('/{id}', [OrderController::class, 'show']);
    //     Route::post('/', [OrderController::class, 'create']);
    //     Route::put('/{id}', [OrderController::class, 'update']);
    //     Route::delete('/{id}', [OrderController::class, 'destroy']);
    //     Route::get('/invoice/{id}', [OrderController::class, 'invoice']);
    // });

    //Products
    // Route::group([
    //     'prefix' => 'products'
    // ], function () {
    //     Route::get('/', [ProductController::class, 'index']);
    //     Route::get('/{id}', [ProductController::class, 'show']);
    //     Route::post('/', [ProductController::class, 'create']);
    //     Route::put('/{id}', [ProductController::class, 'update']);
    //     Route::delete('/{id}', [ProductController::class, 'destroy']);
    // });
});
