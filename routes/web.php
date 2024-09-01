<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/{account}/products/{slug}', \App\Http\Controllers\OrganizationProduct::class);
