<?php
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Routes;

Route::get('/sw', function () {
    Artisan::call('l5-swagger:generate');
    return response()->json(['message' => 'Swagger documentation generated successfully']);
});

Route::get('/migrate', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
        return response()->json(['message' => 'Migration completed successfully.']);
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});
Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin'], function () {
    // Permissions createLead
    Route::POST('userLogin', 'UsersApiController@userLogin');
    Route::POST('createLead', 'UsersApiController@createLead');
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    //Route::apiResource('users', 'UsersApiController');

    Route::get('/users', 'UsersApiController@index');
});
