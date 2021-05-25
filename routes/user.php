<?php

use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LoginUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
|
| Here is where you can register user routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "user" middleware group. Now create something great!
|
*/


Auth::routes(['verify' => true]);


Route::prefix('admin')->group(function () 
{


    Route::get('/verify-email', [EmailVerificationController::class, 'show'])
        ->middleware('auth')
        ->name('verification.notice'); // <-- don't change the route name

    Route::post('/verify-email/request', [EmailVerificationController::class, 'request'])
        ->middleware('auth')
        ->name('verification.request');

    Route::get('/verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->middleware(['auth', 'signed']) // <-- don't remove "signed"
        ->name('verification.verify'); // <-- don't change the route name


    
    Route::get('/login', function () {
        return view('backend.user.auth.login');
    })->name('login');

    Route::post('/login',[LoginUserController::class , 'login']
    )->name('submit.login');





    Route::get('/register', function () {
        return view('backend.user.auth.register');
    })->name('register');

    Route::post('/register', [RegisterUserController::class, 'store'])->name('submit.register');



    

    Route::get('/dashboard', function () {
            return view('backend.user.dashboard');
        })
        ->middleware(['auth', 'verified']) // <!-- add the "verified" middleware
        ->name('dashboard');
});