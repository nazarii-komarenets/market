<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products/{product}', function (\App\Models\Product $product) {
    return view('pages.product', ['product' => $product]);
})->name('product.view');
