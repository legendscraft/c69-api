<?php

use Illuminate\Http\Request;

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

Route::group([

    'middleware' => ['api','cors']

], function () {
    Route::post('login', 'ApiAuthController@login');
    Route::post('register', 'ApiAuthController@register');
    Route::post('logout', 'ApiAuthController@logout');
    Route::post('refresh', 'ApiAuthController@refresh');
    Route::post('resetpwd', 'ApiAuthController@resetpwd');
    Route::group(['middleware' => ['auth:api']],function (){
        Route::apiResource('centres', 'CentreController');
        Route::apiResource('preachings', 'PreachingController');
        Route::apiResource('sacraments', 'SacramentController');
        Route::apiResource('appointments', 'AppointmentController');
        Route::apiResource('appointment-comments', 'AppointmentCommentController');
        Route::apiResource('frequencies', 'FrequencyController');
        Route::apiResource('genders', 'GenderController');
        Route::apiResource('reports', 'ReportController');
        Route::apiResource('recipients', 'RecipientController');
        //Route::apiResource('send-report', 'SendReportController');
    });


});