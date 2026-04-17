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
    Route::get('listLeads', [App\Http\Controllers\Super\LeadInboxController::class, 'listLeads'])->name('listLeads');
    Route::get('getSale', [App\Http\Controllers\Super\LeadInboxController::class, 'getSale'])->name('getSale');
    Route::get('leadDetails/{leadId}', [App\Http\Controllers\Super\LeadInboxController::class, 'leadDetails'])->name('leadDetails');

    # distributorApproval
    Route::get('distributorApproval', [App\Http\Controllers\Super\LeadInboxController::class, 'distributorApproval'])->name('distributorApproval');

    # vicRebate
    Route::get('vicRebate', [App\Http\Controllers\Super\LeadInboxController::class, 'vicRebate'])->name('vicRebate');

    # complianceCheck
    Route::get('complianceCheck', [App\Http\Controllers\Super\LeadInboxController::class, 'complianceCheck'])->name('complianceCheck');

    # bookInstallation
    Route::get('bookInstallation', [App\Http\Controllers\Super\LeadInboxController::class, 'bookInstallation'])->name('bookInstallation');

    #customerPayment
    Route::get('customerPayment', [App\Http\Controllers\Super\LeadInboxController::class, 'customerPayment'])->name('customerPayment');

    # coES
    Route::get('coES', [App\Http\Controllers\Super\LeadInboxController::class, 'coES'])->name('coES');

    #vicPayment
    Route::get('vicPayment', [App\Http\Controllers\Super\LeadInboxController::class, 'vicPayment'])->name('vicPayment');

    # stcPayment
    Route::get('stcPayment', [App\Http\Controllers\Super\LeadInboxController::class, 'stcPayment'])->name('stcPayment');

    # connectionPaperwork
    Route::get('connectionPaperwork', [App\Http\Controllers\Super\LeadInboxController::class, 'connectionPaperwork'])->name('connectionPaperwork');

    # supplierPayment
    Route::get('supplierPayment', [App\Http\Controllers\Super\LeadInboxController::class, 'supplierPayment'])->name('supplierPayment');

    # installerPayment
    Route::get('installerPayment', [App\Http\Controllers\Super\LeadInboxController::class, 'installerPayment'])->name('installerPayment');

    # salesRepPayment
    Route::get('salesRepPayment', [App\Http\Controllers\Super\LeadInboxController::class, 'salesRepPayment'])->name('salesRepPayment');

    Route::any('updateLeadStatusNew', [App\Http\Controllers\Super\LeadInboxController::class, 'updateLeadStatusNew'])->name('updateLeadStatusNew');
    
    Route::any('leadImages', [App\Http\Controllers\Super\LeadInboxController::class, 'leadImages'])->name('leadImages');
    Route::post('saveDistributorApprovalMeta', [App\Http\Controllers\Super\LeadInboxController::class, 'saveDistributorApprovalMeta'])->name('saveDistributorApprovalMeta');
    Route::post('saveVicRebateMeta', [App\Http\Controllers\Super\LeadInboxController::class, 'saveVicRebateMeta'])->name('saveVicRebateMeta');
    Route::post('saveComplianceMeta', [App\Http\Controllers\Super\LeadInboxController::class, 'saveComplianceMeta'])->name('saveComplianceMeta');
});

