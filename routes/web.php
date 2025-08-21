<?php

Route::redirect('/', '/login');
Route::redirect('/home', '/admin');
Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');
	Route::get('users-list', [App\Http\Controllers\Admin\UsersController::class, 'getUsersForSelect2'])->name('users.select2');
	
	 
	
	Route::get('intake-values/data', [App\Http\Controllers\Admin\IntakeValueController::class, 'getIntakeValues'])->name('intake-values.getIntakeValues');
	Route::resource('intake-values', App\Http\Controllers\Admin\IntakeValueController::class);
	
	Route::get('lead-inbox', [App\Http\Controllers\Admin\LeadInboxController::class, 'index'])->name('lead-inbox.index');
	Route::get('lead-inbox/data', [App\Http\Controllers\Admin\LeadInboxController::class, 'getLeadInboxList'])->name('lead-inbox.getLeadInboxList');	
	Route::any('leadStore', [App\Http\Controllers\Admin\LeadInboxController::class, 'leadStore'])->name('leadStore');
	Route::any('listLeads', [App\Http\Controllers\Admin\LeadInboxController::class, 'listLeads'])->name('listLeads');	
    Route::any('leadFollowUps', [App\Http\Controllers\Admin\LeadInboxController::class, 'leadFollowUps'])->name('leadFollowUps');
    Route::any('updateLeadStatus', [App\Http\Controllers\Admin\LeadInboxController::class, 'updateLeadStatus'])->name('updateLeadStatus');		
	
	# lead source
	Route::resource('leadSource', App\Http\Controllers\Admin\LeadSourceController::class);
    Route::resource('fri', App\Http\Controllers\Admin\FriController::class);
    Route::any('listFri', [App\Http\Controllers\Admin\FriController::class, 'listFri'])->name('listFri');
    Route::any('viewFri/{id}', [App\Http\Controllers\Admin\FriController::class, 'viewFri'])->name('viewFri');
    Route::any('updateFriStaus', [App\Http\Controllers\Admin\FriController::class, 'updateFriStaus'])->name('updateFriStaus');
    Route::any('friUpdate', [App\Http\Controllers\Admin\FriController::class, 'friUpdate'])->name('friUpdate');
    Route::any('followupComplete', [App\Http\Controllers\Admin\LeadInboxController::class, 'followupComplete'])->name('followupComplete');

    # email templete
	Route::resource('emailTemplate', App\Http\Controllers\Admin\EmailTemplateController::class);

    Route::any('emailTemplateUpdate', [App\Http\Controllers\Admin\EmailTemplateController::class, 'emailTemplateUpdate'])->name('emailTemplateUpdate');
    Route::any('sendEmail', [App\Http\Controllers\Admin\EmailTemplateController::class, 'sendEmail'])->name('sendEmail');
});
