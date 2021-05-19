<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('admin')->group(function () {
    
    Route::get('/login', function () {
        return view('backend.user.auth.login');
    })->name('login');

    Route::get('/register', function () {
        return view('backend.user.auth.register');
    })->name('register');
    
});