<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});




Route::resource('products', App\Http\Controllers\ProductController::class);

Route::resource('currencies', App\Http\Controllers\CurrencyController::class);

Route::resource('product-prices', App\Http\Controllers\ProductPriceController::class);


Route::resource('products', App\Http\Controllers\ProductController::class);

Route::resource('currencies', App\Http\Controllers\CurrencyController::class);

Route::resource('product-prices', App\Http\Controllers\ProductPriceController::class);


Route::resource('products', App\Http\Controllers\ProductController::class);

Route::resource('currencies', App\Http\Controllers\CurrencyController::class);

Route::resource('product-prices', App\Http\Controllers\ProductPriceController::class);
