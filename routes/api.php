<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\ProductPriceController;

Route::apiResource('products', ProductController::class);
Route::apiResource('currencies', CurrencyController::class);
Route::apiResource('product-prices', ProductPriceController::class);