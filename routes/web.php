<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');
Route::get('/account/registration', \App\Filament\Pages\Auth\Register::class)->name('registration');

//Route::get('/products', [ProductController::class, 'index'])->name('product.list');
//Route::get('/products/{product}', [ProductController::class, 'show'])->name('product.view');

Route::controller(ProductController::class)
    ->group(function () {
        Route::get('/products', 'index')->name('product.list');
        Route::get('/{author_id}/products/{product}', 'show')->name('product.view');
    }
);


Route::get('/sellers', [\App\Http\Controllers\SellerController::class, 'index'])->name('seller.list');
Route::get('/sellers/{seller}', [\App\Http\Controllers\SellerController::class, 'show'])->name('seller.show');

Route::get('/checkout/{product}', function (\App\Models\Product $product) {
    return view('pages.checkout', ['product' => $product]);
})->name('checkout.product');

Route::get('/contact-us', fn() => view('pages.contact-us'))->name('contact-us');
Route::get('/about-us', fn() => view('pages.about-us'))->name('about-us');

Route::get('/thank-you', function () {
    return view('pages.thank-you');
})->name('thank-you');

Route::get('/telegram/temp-url', [\App\Http\Controllers\TelegramNotificationController::class, 'create'])
    ->name('telegram-temp-url');

Route::post('/telegram/webhook/'.config('services.telegram-bot-api.webhook'),
    [\App\Http\Controllers\TelegramNotificationController::class, 'store']);
