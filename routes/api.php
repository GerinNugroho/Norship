<?php

use App\Http\Controllers\API\V1\authController;
use App\Http\Controllers\API\V1\profileController;
use App\Http\Controllers\API\V1\storeController;
use App\Http\Controllers\API\V1\userController;
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

Route::prefix('v1')->group(function () {

    Route::post('/signup', [authController::class, 'signUp'])->name(name: 'signup');
    Route::post('/login', [authController::class, 'login'])->name(name: 'login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [authController::class, 'logout'])->name(name: 'logout');
        Route::apiResource('profile', profileController::class);
        Route::apiResource('store', storeController::class);
        // Routes that require both a token AND the 'super admin' role.
        Route::middleware('role:super admin')->group(function () {
            Route::apiResource('users', userController::class);
        });
    });
});
