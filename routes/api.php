<?php
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Routes;

Route::get('/sw', function () {
    Artisan::call('l5-swagger:generate');
    return response()->json(['message' => 'Swagger documentation generated successfully']);
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
