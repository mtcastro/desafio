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


Route::post('login', 'AuthController@login');
Route::post('contact/register/flow/{flow_key}', 'ContactController@createFlow');


Route::group(['middleware' => ['apiJwt']], function(){
    Route::get('user', 'AuthController@getUser');
    Route::post('contact/register', 'ContactController@create');
    Route::post('contact/update/{id}', 'ContactController@update');
    Route::get('contact/getbyid/{id}', 'ContactController@getById');
    Route::get('contact/delete/{id}', 'ContactController@delete');
    Route::post('contact/search', 'ContactController@getByName');

    Route::get('logout', 'AuthController@logout');
});


