<?php


use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\DashboardController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\CashierController;
use App\Http\Middleware\ApiAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware(ApiAuth::class)->group(function () {
    Route::prefix('v1')->group(function () {

        Route::get('balance', [DashboardController::class, 'balance']);
        Route::get('income/daily/{date?}', [DashboardController::class, 'getSalesIncomeForLastDays']);
        Route::get('income/monthly/{date?}', [DashboardController::class, 'getSalesIncomeForLastMonth']);

        Route::get('products', [ProductController::class, 'index']);
        Route::get('products/{id}', [ProductController::class, 'show']);
        Route::get('products/category/{id}', [ProductController::class, 'productsByCategory']);
        Route::get('products/upc/{upc}', [ProductController::class, 'productsByUpc']);

        Route::get('category', [CategoryController::class, 'index']);
        Route::get('category/{id}', [CategoryController::class, 'show']);
    });
});
