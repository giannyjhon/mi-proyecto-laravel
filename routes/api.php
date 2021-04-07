<?php

use Illuminate\Http\Request;

Route::get('/login', 'AuthController@login');

Route::get('/specialties', 'SpecialtyController@index');
   Route::get('/specialties/{specialty}/doctors', 'SpecialtyController@doctors');
    Route::get('/schedule/hours', 'ScheduleController@hours');
/*

Route::middleware('auth:api')->group(function () {

    Route::get('/user','UserController@show');
    // Route::get('/user', function (Request $request) {
    //     return 'Privado';
    // });
});
*/
Route::group([
    'prefix' => 'auth'
], function () {
    Route::get('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signUp');
    //Route::get('user', 'AuthController@show');
    Route::group([
     'middleware' => 'auth:api'
    ], function() {
        // Route::get('logout', 'AuthController@logout');
         Route::post('/logout', 'AuthController@logout');
        Route::get('/user', 'UserController@show');

    });
});

// Route::get('/login', 'AuthController@login');

// Route::middleware('auth:api')->group(function () {

//     Route::get('/user','UserController@show');
//     // Route::get('/user', function (Request $request) {
//     //     return 'Privado';
//     // });
// });
