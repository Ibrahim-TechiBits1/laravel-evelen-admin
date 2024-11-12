<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\LoggedIn;
use App\Http\Middleware\Dashboard;

Route::get('/', [UserController::class, 'index'])->name('index');

Route::group(['middleware' => LoggedIn::class], function () {
    
    Route::get('/signup', [UserController::class, 'signup'])->name('signup');
    Route::post('/user-create', [UserController::class, 'userCreate'])->name('user-create');
    Route::post('/login', [UserController::class, 'login'])->name('login');
    Route::get('/forgot-password', [UserController::class, 'forgotPassword'])->name('forgot-password');
    Route::post('/check-information', [UserController::class, 'checkInformation'])->name('check-information');
    Route::post('/forgot-password-verify', [UserController::class, 'forgotPasswordVerify'])->name('forgot-password-verify');
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::post('/trash-kill', [UserController::class, 'trashKill'])->name('trash-kill');
});


Route::group(['middleware' => Dashboard::class], function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
});
