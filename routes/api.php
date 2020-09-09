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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*
Route::get('/object/myKey', 'KeyController@get_key');
Route::post('/object/myKey', 'KeyController@set_key');
*/
Route::get('/object/{key_id}', 'API\KeyController@get_key');
Route::post('/object', 'API\KeyController@add_key');
Route::get('/get_all_key', 'API\KeyController@get_all_key');


