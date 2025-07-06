<?php

use App\Http\Controllers\API\V1\userControllerSU;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\productController;
use App\Http\Controllers\API\V1\authController;
use App\Http\Controllers\API\V1\storeController;
use App\Http\Controllers\API\V1\addressController;
use App\Http\Controllers\API\V1\cartController;
use App\Http\Controllers\API\V1\orderController;

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

    Route::post('register', [authController::class, 'signUp']);
    ROute::post('login', [authController::class, 'signIn']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [authController::class, 'signOut']);

        Route::get('profile', [authController::class, 'profile']);

        Route::post('create/store', [storeController::class, 'createStore']);

        Route::post('cart', [cartController::class, 'addCart']);
        Route::get('cart', [cartController::class, 'showCart']);
        Route::delete('cart/{id}', [cartController::class, 'clearCart']);

        Route::get('products', [productController::class, 'showProducts']);
        Route::get('products/category/{id}', [productController::class, 'showProductInCategory']);

        Route::apiResource('addresses', addressController::class);

        Route::post('order/create', [orderController::class, 'create']);

        Route::middleware('role:admin')->group(function () {
            Route::put('admin/edit/store/{id}', [storeController::class, 'editStore']);

            Route::post('admin/add/product', [productController::class, 'addProduct']);
        });

        // Routes that require both a token AND the 'super admin' role.
        Route::middleware('role:super admin')->group(function () {
            //dikejar deadline, jadi belum
        });
    });
});
