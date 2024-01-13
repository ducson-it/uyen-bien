<?php

use App\Http\Controllers\Admins\ProductController;

Route::get('/', function (){
    return view('admins.layouts.app');
});

Route::get('/test', [ProductController::class, 'index']);
