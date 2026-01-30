<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Super\HomeController;

Route::prefix('superadmin')->name('superadmin.')->group(function () {

    Route::get('login', [LoginController::class, 'showLoginFormSuper'])->name('login');
    Route::post('loginSubmit', [LoginController::class, 'loginSubmit'])->name('loginSubmit');
   // Route::get('/superadmin/dashboard', 'HomeController@index')->name('dashboard');

    // Route::post('logout', [LoginController::class, 'logout'])
    //     ->name('logout');

    // Route::redirect('/', 'login');
    // Route::redirect('home', '/admin');

});

Route::prefix('superadmin')
    ->name('superadmin.')
    ->middleware(['auth'])
    ->group(function () {

        Route::get('dashboard', [HomeController::class, 'index'])
            ->name('dashboard');

        Route::post('logout', [LoginController::class, 'logout'])
            ->name('logout');
    });

