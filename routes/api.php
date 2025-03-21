<?php
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminStoreController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PersonalInformationController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StoreController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::post('/register', [RegisteredUserController::class, 'store']); // POST is standard for creating new resources
Route::post('/login', [AuthenticatedSessionController::class, 'store']); // POST is standard for login

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

    // Store Routes
    Route::get('/stores/{type}', [StoreController::class, 'index']);
    Route::get('/stores/{type}/{store}', [StoreController::class, 'show']);
    // Product Routes
    Route::get('/products/{product}', [ProductController::class, 'show']);

    // Search Routes
    Route::get('/search', [SearchController::class, 'search']);

    // Cart Routes
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart', [CartController::class, 'store']);
    Route::delete('/cart/{cart}', [CartController::class, 'destroy']);
    Route::put('/cart/{cart}', [CartController::class, 'update']);
    Route::post('/cart/submit', [CartController::class, 'PlaceOrder']);

    // Favorites Routes
    Route::get('/favorite',[FavoritesController::class, 'index']);
    Route::post('/favorite',[FavoritesController::class, 'store']);
    Route::delete('/favorite/{favorite}', [FavoritesController::class, 'destroy']);

    //Personal Info Routes
    Route::get('/profile',[PersonalInformationController::class, 'index']);
    Route::Post('/profile',[PersonalInformationController::class, 'update']);

    //Orders
    Route::get('/orders',[OrderController::class, 'index']);
    Route::get('/orders/{order}', [OrderController::class, 'show']);
    Route::delete('/orders/{order}', [OrderController::class, 'destroy']);
});




