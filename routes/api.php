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

Route::post('register', [authController::class, 'signUp']);
Route::post('login', [authController::class, 'login']);
Route::get('logout', [authController::class, 'logout'])->middleware('auth:sanctum');
Route::get('profile', [profileController::class,  'profile'])->middleware(['auth:sanctum']);

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
 Route::apiResource('users', userController::class);
});
