<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group([ 'prefix' => 'v1', 'middleware' => 'api'], function(){

    /* User register */
    Route::post('user/register', 'App\Http\Controllers\Api\v1\AuthController@register');

    /* User login */
    Route::post('user/login', 'App\Http\Controllers\Api\v1\AuthController@login');

    /* Refresh user's token */
    Route::get('user/refresh', 'App\Http\Controllers\Api\v1\AuthController@token');

    /* User logout from system */
    Route::get('user/logout', 'App\Http\Controllers\Api\v1\AuthController@logout');

    // Get auth user
    Route::get('token/validate', 'App\Http\Controllers\Api\v1\AuthController@auth');

    //Admin actions
    Route::group([ 'prefix' => 'admin' ], function(){
        /* Get all users details*/
        Route::get('users', 'App\Http\Controllers\Api\v1\UserController@getAll');
        // /* Add a user */
        Route::post('user/create', 'App\Http\Controllers\Api\v1\UserController@create');
        // /* Update a user */
        Route::put('user/update', 'App\Http\Controllers\Api\v1\UserController@update');
        /* Get user detail by id */
        Route::get('user/{userId}', 'App\Http\Controllers\Api\v1\UserController@getById');
        /* delete user by id */
        Route::delete('user/delete/{userId}', 'App\Http\Controllers\Api\v1\UserController@delete');

        /* Get all competition_types details*/
        Route::get('competition_types', 'App\Http\Controllers\Api\v1\CompetitionTypeController@getAll');
        // /* Add a competition_type */
        Route::post('competition_type/create', 'App\Http\Controllers\Api\v1\CompetitionTypeController@create');
        // /* Update a competition_type */
        Route::put('competition_type/update', 'App\Http\Controllers\Api\v1\CompetitionTypeController@update');
        /* Get competition_type detail by id */
        Route::get('competition_type/{competition_typeId}', 'App\Http\Controllers\Api\v1\CompetitionTypeController@getById');
        /* delete competition_type by id */
        Route::delete('competition_type/delete/{competition_typeId}', 'App\Http\Controllers\Api\v1\CompetitionTypeController@delete');

        /* Get all competitions details*/
        Route::get('competitions', 'App\Http\Controllers\Api\v1\CompetitionController@getAll');
        // /* Add a Competition */
        Route::post('competition/create', 'App\Http\Controllers\Api\v1\CompetitionController@create');
        // /* Update a Competition */
        Route::put('competition/update', 'App\Http\Controllers\Api\v1\CompetitionController@update');
        /* Get Competition detail by id */
        Route::get('competition/{competitionId}', 'App\Http\Controllers\Api\v1\CompetitionController@getById');
        /* delete Competition by id */
        Route::delete('competition/delete/{competitionId}', 'App\Http\Controllers\Api\v1\CompetitionController@delete');
    });

    Route::group(['middleware' => ['jwt.auth']], function() {



        // /* Show all teams */
        // Route::get('teams', 'Api\v1\TeamController@index');


        // /* Player actions */
        // Route::prefix('player')->group(function () {
        //     /* Delete a player */
        //     Route::delete('{player}', 'Api\v1\PlayerController@destroy');
        //     /* Update a player in a team */
        //     Route::patch('{player}', 'Api\v1\PlayerController@update');
        // });

    });

});
