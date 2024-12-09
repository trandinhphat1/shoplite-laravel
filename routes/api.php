<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BaloController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\UserController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    // Auth routes
    Route::post('login', [AuthenticationController::class, 'login']);
    Route::post('logout', [AuthenticationController::class, 'destroy'])->middleware('auth:api');
    Route::post('register', [AuthenticationController::class, 'saveNewUser']);

    // Protected routes
    Route::middleware('auth:api')->group(function () {
        // User routes
        Route::get('user/statistics', [UserController::class, 'getStatistics']);
        
        // Profile routes
        Route::post('updateprofile', [ProfileController::class, 'updateProfile']);
        Route::get('updateprofile', [ProfileController::class, 'getProfile']);
        Route::post('profile/update', [ProfileController::class, 'updateProfile']);

        // Product routes
        Route::get('getproductlist', [ProductController::class, 'getAllProductList']);
        Route::get('getallcat', [ProductController::class, 'getAllCat']);
        Route::get('getproductcat', [ProductController::class, 'getProductCat']);

        // Order routes
        Route::get('orders/count', [OrderController::class, 'getOrderCount']);
        Route::post('orders/payment', [OrderController::class, 'payment']);
        Route::post('orders/complete-payment', [OrderController::class, 'completePayment']);

        // Admin routes
        Route::get('admin/dashboard', [AdminController::class, 'getDashboardStats']);

        // Balo routes
        Route::post('balos/search', [BaloController::class, 'search']);
        Route::resource('balos', BaloController::class);
        Route::post('balos/{id}/toggle-favorite', [BaloController::class, 'toggleFavorite']);
        Route::get('balos/{id}/check-favorite', [BaloController::class, 'checkFavorite']);
        Route::get('favorites', [BaloController::class, 'getFavorites']);
    });
});

// Public routes
Route::prefix('v1')->group(function () {
    Route::get('/products', [ProductController::class, 'getAllProductList']);
    Route::get('/products/{id}', [ProductController::class, 'getProductDetail']);
    Route::get('/balo', [BaloController::class, 'index']);
    Route::get('/balo/search', [BaloController::class, 'search']);
    Route::get('/balo/{slug}', [BaloController::class, 'show']);
});
