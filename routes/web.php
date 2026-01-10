<?php
 
use App\User;

Route::redirect('/', '/login');
Route::redirect('/home', '/admin');
Auth::routes();

Route::get('/google/callback', [App\Http\Controllers\Admin\GmailController::class, 'gmailCallback'])
->name('gmailCallback');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::get('logout', [App\Http\Controllers\Admin\UsersController::class, 'logout'])->name('logout');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::any('updateProfile', 'UsersController@updateProfile')->name('updateProfile');
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
	Route::any('updateStore', [App\Http\Controllers\Admin\LeadInboxController::class, 'updateStore'])->name('updateStore');
    Route::any('deleteLead/{id}', [App\Http\Controllers\Admin\LeadInboxController::class, 'deleteLead'])->name('deleteLead');

    # For contacts 
    Route::any('contacts', [App\Http\Controllers\Admin\LeadInboxController::class, 'contacts'])->name('contacts');	
    Route::any('listContact', [App\Http\Controllers\Admin\LeadInboxController::class, 'listContact'])->name('listContact');	
    Route::any('updateContact', [App\Http\Controllers\Admin\LeadInboxController::class, 'updateContact'])->name('updateContact');
    Route::any('contactFollowUp/{id}', [App\Http\Controllers\Admin\LeadInboxController::class, 'contactFollowUp'])->name('contactFollowUp');		

    # zoom recordings
    
    Route::any('/zoomRecordings/{id}', [App\Http\Controllers\Admin\LeadInboxController::class, 'zoomRecordings']);	
    Route::any('/audioUrl', [App\Http\Controllers\Admin\LeadInboxController::class, 'audioUrl'])->name('audioUrl');			

	# lead source friImages
	Route::resource('leadSource', App\Http\Controllers\Admin\LeadSourceController::class);
    Route::resource('fri', App\Http\Controllers\Admin\FriController::class);
    Route::any('listFri', [App\Http\Controllers\Admin\FriController::class, 'listFri'])->name('listFri');
    Route::any('viewFri/{id}', [App\Http\Controllers\Admin\FriController::class, 'viewFri'])->name('viewFri');
    Route::any('updateFriStaus', [App\Http\Controllers\Admin\FriController::class, 'updateFriStaus'])->name('updateFriStaus');
    Route::any('friUpdate', [App\Http\Controllers\Admin\FriController::class, 'friUpdate'])->name('friUpdate');
    Route::any('followupComplete', [App\Http\Controllers\Admin\LeadInboxController::class, 'followupComplete'])->name('followupComplete');
    Route::any('friImages', [App\Http\Controllers\Admin\FriController::class, 'fri_images'])->name('friImages');

    # timeline
    Route::get('timeline/{leadId}', [App\Http\Controllers\Admin\LeadInboxController::class, 'timeline'])->name('timeline');

    Route::get('/gmailConnect/{lead}', [App\Http\Controllers\Admin\GmailController::class, 'gmailConnect'])
        ->name('gmailConnect');

   

    Route::post('/gmailSync/{lead}', [App\Http\Controllers\Admin\GmailController::class, 'gmailSync'])
        ->name('gmailSync');

    #sales 
    Route::get('sales', [App\Http\Controllers\Admin\LeadInboxController::class, 'sales'])->name('sales');
    Route::get('getSale', [App\Http\Controllers\Admin\LeadInboxController::class, 'getSale'])->name('getSale');

    Route::any('updateSalesStatus', [App\Http\Controllers\Admin\LeadInboxController::class, 'updateSalesStatus'])->name('updateSalesStatus');

    # email templete
	Route::resource('emailTemplate', App\Http\Controllers\Admin\EmailTemplateController::class);
    Route::any('emailTemplateUpdate', [App\Http\Controllers\Admin\EmailTemplateController::class, 'emailTemplateUpdate'])->name('emailTemplateUpdate');
    Route::any('sendEmail', [App\Http\Controllers\Admin\EmailTemplateController::class, 'sendEmail'])->name('sendEmail');

    Route::any('bulkEmail', [App\Http\Controllers\Admin\EmailTemplateController::class, 'bulkEmail'])->name('bulkEmail');
    Route::any('bulkEmailSend', [App\Http\Controllers\Admin\EmailTemplateController::class, 'bulkEmailSend'])->name('bulkEmailSend');
    

    # for task related routes
    Route::any('taskList', [App\Http\Controllers\Admin\TasksController::class, 'taskList'])->name('taskList');
    Route::any('getTask', [App\Http\Controllers\Admin\TasksController::class, 'getTask'])->name('getTask');
    Route::any('taskStore', [App\Http\Controllers\Admin\TasksController::class, 'taskStore'])->name('taskStore');
    Route::any('taskUpdate', [App\Http\Controllers\Admin\TasksController::class, 'taskUpdate'])->name('taskUpdate');

    # for ticket routes
    Route::resource('ticket', App\Http\Controllers\Admin\TicketController::class);
    Route::any('getTicket', [App\Http\Controllers\Admin\TicketController::class, 'getTicket'])->name('getTicket');
    Route::any('closeTicket/{id}', [App\Http\Controllers\Admin\TicketController::class, 'closeTicket'])
     ->name('admin.closeTicket');
    Route::any('ticketsRepliesList/{id}', [App\Http\Controllers\Admin\TicketController::class, 'ticketsRepliesList'])
     ->name('admin.ticketsRepliesList');

    Route::any('ticketsReplies/{id}', [App\Http\Controllers\Admin\TicketController::class, 'ticketsReplies'])
     ->name('admin.ticketsReplies');
    Route::any('ticketUpdate/{id}', [App\Http\Controllers\Admin\TicketController::class, 'ticketUpdate'])
     ->name('admin.ticketUpdate');
     

    Route::any('fetchUnreadReplies', [App\Http\Controllers\Admin\TicketController::class, 'fetchUnreadReplies'])
     ->name('fetchUnreadReplies');

    Route::any('fetchUnreadRepliesFri', [App\Http\Controllers\Admin\TicketController::class, 'fetchUnreadRepliesFri'])
     ->name('fetchUnreadRepliesFri');

    # for webhook
    Route::any('send', [App\Http\Controllers\Admin\ApiTesterController::class, 'send'])->name('send');
    Route::any('webhook', [App\Http\Controllers\Admin\ApiTesterController::class, 'webhook'])->name('webhook');
    Route::any('createWebhook', [App\Http\Controllers\Admin\ApiTesterController::class, 'createWebhook'])->name('createWebhook');
    Route::any('storeWebhook', [App\Http\Controllers\Admin\ApiTesterController::class, 'storeWebhook'])->name('storeWebhook');
    Route::any('editWebhook/{id}', [App\Http\Controllers\Admin\ApiTesterController::class, 'editWebhook'])->name('editWebhook');
    Route::any('updateWebhook/{id}', [App\Http\Controllers\Admin\ApiTesterController::class, 'updateWebhook'])->name('updateWebhook');
    Route::any('deleteWebhook/{id}', [App\Http\Controllers\Admin\ApiTesterController::class, 'deleteWebhook'])->name('deleteWebhook');
    Route::any('triggerwebhook', [App\Http\Controllers\Admin\ApiTesterController::class, 'triggerwebhook'])->name('triggerwebhook');
    Route::any('apiLog/{id}', [App\Http\Controllers\Admin\ApiTesterController::class, 'apiLog'])->name('apiLog');
    Route::any('generateQuote/{id}', [App\Http\Controllers\Admin\ApiTesterController::class, 'createProject'])->name('generateQuote');


    # for notification
    Route::any('/notifications/{id}/read', function($id){
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return back();
    })->name('notifications.read');


    Route::any('/profile', function(){
        $user = User::find(auth()->user()->id);
        return view('profile', compact('user'));
    })->name('profile');

    Route::any('/notifications', function(){
        $notifications = auth()->user()->notifications()->latest()->get();
        auth()->user()->unreadNotifications->markAsRead();
        return view('notifications.index', compact('notifications'));
    })->name('notifications.index');

    Route::any('/notifications/mark-all-read', function(){
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.markAllRead');


    Route::any('fetchNotification', [App\Http\Controllers\Admin\UsersController::class, 'fetchNotification'])
    ->name('fetchNotification');


    # for tier functionality
    Route::resource('tier', App\Http\Controllers\Admin\TierController::class);
    Route::get('settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');

    Route::post('/attendance/punch-in', [App\Http\Controllers\Admin\AttendanceController::class, 'punchIn'])->name('attendance.punchin');
    Route::post('/attendance/punch-out', [App\Http\Controllers\Admin\AttendanceController::class, 'punchOut'])->name('attendance.punchout');
    Route::get('/attendance', [App\Http\Controllers\Admin\AttendanceController::class, 'userAttendance'])->name('attendance.index');
    Route::get('/admin/attendance', [App\Http\Controllers\Admin\AttendanceController::class, 'adminIndex'])->name('admin.attendance.index');


});