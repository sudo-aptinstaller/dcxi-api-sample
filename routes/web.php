<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();


//temp covid

Route::get('/cov', 'PagesController@get_covid_status');



//Gets Main 

Route::get('/', 'PagesController@index');

Route::get('/dash/{id}' , 'MainController@dashboard');

Route::post('/dash/generate-token', 'MainController@generate_token');


//Status

Route::get('/dash/change-status/{query}', 'MainController@status_ajax_grab');

Route::post('/dash/change-status/{query}', 'MainController@status_ajax_store');


//Token Revoke

Route::post('/dash/revoke-token/{query}', 'MainController@revoke_token');