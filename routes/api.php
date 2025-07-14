<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\ProductController;
use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\StoreController;
use App\Http\Controllers\API\V1\AddressController;
use App\Http\Controllers\API\V1\CartController;
use App\Http\Controllers\API\V1\OrderController;

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
    Route::get('products', [ProductController::class, 'showProducts']);
    Route::post('register', [AuthController::class, 'signUp']);
    Route::post('login', [AuthController::class, 'signIn']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'signOut']);

        Route::get('profile', [AuthController::class, 'profile']);

        Route::post('create/store', [StoreController::class, 'createStore']);

        Route::post('cart', [CartController::class, 'addCart']);
        Route::get('cart', [CartController::class, 'showCart']);
        Route::delete('cart/{id}', [CartController::class, 'clearCart']);
        Route::get('products/category/{id}', [ProductController::class, 'showProductInCategory']);

        Route::apiResource('addresses', AddressController::class);

        Route::post('order/create', [OrderController::class, 'create']);

        Route::middleware('role:admin')->group(function () {
            Route::put('admin/edit/store/{id}', [StoreController::class, 'editStore']);

            Route::post('admin/add/product', [ProductController::class, 'addProduct']);
        });

        // Routes that require both a token AND the 'super admin' role.
        Route::middleware('role:super admin')->group(function () {
            //dikejar deadline, jadi belum
        });
    });
});
