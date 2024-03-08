<?php

use App\Http\Controllers\AuthenticationController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::middleware('guest')->group(function () {
        Route::get('register', [AuthenticationController::class, 'registerView'])
            ->name('register');

        Route::post('register', [AuthenticationController::class, 'register']);

        Route::get('login', [AuthenticationController::class, 'loginView'])
            ->name('login');

        Route::post('login', [AuthenticationController::class, 'login']);
    });

    Route::middleware('auth')->group(function () {
        Route::post('logout', [AuthenticationController::class, 'logout'])
            ->name('logout');
    });
});
