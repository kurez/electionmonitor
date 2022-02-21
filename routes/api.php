<?php


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'Api\V1', 'prefix' => 'v1', 'as' => 'v1.'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/login', 'AuthController@authenticate');
        Route::post('/logout', 'AuthController@logout');
        Route::post('/check', 'AuthController@check');
        Route::post('/register', 'AuthController@register');
        Route::get('/activate/{token}', 'AuthController@activate');
        Route::post('/password', 'AuthController@password');
        Route::post('/validate-password-reset', 'AuthController@validatePasswordReset');
        Route::post('/reset', 'AuthController@reset');
        Route::post('/social/token', 'SocialAuthController@getToken');
    });

    Route::group(['middleware' => ['jwt.auth']], function () {
        Route::get('/auth/user', 'AuthController@getAuthUser');
        Route::post('/aspirant', 'AspirantController@store');
        Route::get('/aspirant', 'AspirantController@index');
        Route::delete('/aspirant/{id}', 'AspirantController@destroy');
        Route::get('/aspirant/{id}', 'AspirantController@show');
        Route::patch('/aspirant/{id}', 'AspirantController@update');
        Route::post('/aspirant/status', 'AspirantController@toggleStatus');

        Route::get('/configuration/fetch', 'ConfigurationController@index');
        Route::post('/configuration', 'ConfigurationController@store');

        Route::get('/user', 'UserController@index');
        Route::post('/user/change-password', 'AuthController@changePassword');
        Route::post('/user/update-profile', 'UserController@updateProfile');
        Route::post('/user/update-avatar', 'UserController@updateAvatar');
        Route::post('/user/remove-avatar', 'UserController@removeAvatar');
        Route::delete('/user/{id}', 'UserController@destroy');
        Route::get('/user/dashboard', 'UserController@dashboard');

      
        Route::get('/county', 'LocationsController@fetchCounty');
        Route::get('/constituency', 'LocationsController@fetchConstituency');
        Route::get('/ward', 'LocationsController@fetchWard');
    
    });
});
