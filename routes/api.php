<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
use App\Http\Controllers\userController;
use App\Http\Controllers\profileController;

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

Route::post('signup', [authController::class, 'signUp']);
Route::post('login', [authController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [authController::class, 'logout']);
    Route::get('profile', [profileController::class,  'profile']);

    // Routes that require both a token AND the 'admin' role.
    Route::middleware('role:admin')->group(function () {
        Route::apiResource('users', userController::class);
    });
});
