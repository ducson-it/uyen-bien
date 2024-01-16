<?php

use App\Http\Controllers\Admins\ProductController;

Route::get('/', function (){
    return view('admins.layouts.app');
});
Route::prefix('product')->middleware('auth','admin')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
});
