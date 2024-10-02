<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/account/registration', \App\Filament\Pages\Auth\Register::class)->name('registration');

Route::get('/products', [\App\Http\Controllers\ProductController::class, 'index'])->name('product.list');
Route::get('/products/{product}', [\App\Http\Controllers\ProductController::class, 'show'])->name('product.view');

Route::get('/checkout/{product}', function (\App\Models\Product $product) {
    return view('pages.checkout', ['product' => $product]);
})->name('checkout.product');

Route::get('/contact-us', fn() => view('pages.contact-us'))->name('contact-us');

Route::get('/thank-you', function () {
    return view('pages.thank-you');
})->name('thank-you');
