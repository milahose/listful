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

Route::get('/', 'ItemController@index');

Route::get('/{itemId}', 'ItemController@show');

Route::post('/', 'ItemController@store');

Route::put('/{itemId}', 'ItemController@update');

Route::delete('/{itemId}', 'ItemController@destroy');