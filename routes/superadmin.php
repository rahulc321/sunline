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

Route::prefix('superadmin')->name('superadmin.')->middleware(['superadmin.auth'])->group(function () {

    Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');
    
    # timeline
    Route::get('connectGmail', [App\Http\Controllers\Super\LeadInboxController::class, 'connectGmail'])->name('connectGmail');
    Route::get('timeline/{leadId}', [App\Http\Controllers\Super\LeadInboxController::class, 'timeline'])->name('timeline');
    Route::any('/gmailDisconnect/{lead}', [App\Http\Controllers\Super\GmailController::class, 'gmailDisconnect'])
    ->name('gmailDisconnect');

    Route::get('/gmailConnect/{lead}', [App\Http\Controllers\Super\GmailController::class, 'gmailConnect'])
        ->name('gmailConnect');
    
    Route::any('google/callback', [App\Http\Controllers\Super\GmailController::class, 'gmailCallback'])
        ->name('gmailCallback');

    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('sales', [App\Http\Controllers\Super\LeadInboxController::class, 'sales'])->name('sales');
    Route::get('getSale', [App\Http\Controllers\Super\LeadInboxController::class, 'getSale'])->name('getSale');

    });

