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
    'middleware' => 'api'
], function ($router) {

    Route::post('/signup','Auth\RegisterController@signup');
    Route::post('/login','Auth\LoginController@login');
    Route::get('/logout','Auth\LoginController@logout');
    Route::get('/checkAuth', 'Auth\LoginController@getAuthenticatedUser');
    Route::post('/generateResume', 'ResumeController@createResume');
    Route::post('/getMyResumes', 'ResumeController@myResumes');

    Route::get('/downloadPdf/{file}', 'ResumeController@downloadPdf');


});
