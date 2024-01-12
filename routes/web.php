<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Route clients
Route::prefix('')->group(function () {
    require "clients.php";
});

//Route admins
Route::prefix('admin')->middleware('auth','admin')->group(function () {
    require "admins.php";
});

require __DIR__.'/auth.php';
