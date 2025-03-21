<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminStoreController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => "an error occurred"
    ]);
});

Route::middleware(AdminMiddleware::class)->group(function () {
    Route::view('/admin/page', 'admin');
    Route::view('/addastore', 'addAStore');
    Route::post('/admin/stores', [AdminStoreController::class, 'store']);

    Route::view('/deleteastore', 'deleteAStore');
    Route::delete('/admin/stores', [AdminStoreController::class, 'destroy']);

    Route::view('/addaproduct', 'addAProduct');
    Route::post('/admin/products', [AdminProductController::class, 'store']);

    Route::view('/deleteaproduct', 'deleteAProduct');
    Route::delete('/admin/products', [AdminProductController::class, 'destroy']);

    Route::view('/editaproduct', 'editAProduct');
    Route::patch('/admin/products', [AdminProductController::class, 'update']);
});

Route::get('/admin/login', [AdminController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login']);
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');



require __DIR__.'/auth.php';
