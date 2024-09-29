<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/account/registration', \App\Filament\Pages\Auth\Register::class)->name('registration');

Route::get('/products/{product}', [\App\Http\Controllers\ProductController::class, 'show'])->name('product.view');

Route::get('/checkout/{product}', function (\App\Models\Product $product) {
    return view('pages.checkout', ['product' => $product]);
})->name('checkout.product');

Route::get('/thank-you', function () {
    return view('pages.thank-you');
})->name('thank-you');
