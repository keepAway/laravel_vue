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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


//all messages
Route::get('messages', 'PublicController@index');

//single message
Route::get('message/{id}', 'PublicController@show');

//create new message
Route::post('message', 'PublicController@store');

//create new message
Route::put('message', 'PublicController@store');

//delete message
Route::delete('message/{id}', 'PublicController@destroy');



