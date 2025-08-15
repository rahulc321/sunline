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
	
	# lead source
	Route::resource('leadSource', App\Http\Controllers\Admin\LeadSourceController::class);


	
});
