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
// User
Route::get('tampil/{id}', 'AuthController@index');
Route::get('tampil', 'AuthController@show');
Route::put('/avatar/edit', 'AuthController@updateavatar');
Route::put('/user/edit', 'AuthController@updateuser');
Route::put('/mobile/edit', 'AuthController@mobileupdate');
Route::put('/password/edit', 'AuthController@privasi');
Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');

// Chat
Route::post('/chat/send','chatController@store');
Route::get('/chat/show/{sender_id}/{receiver_id}','chatController@show');
Route::get('/message/{sender_id}/{receiver_id}','chatController@getMessage');
Route::post('/message/send','chatController@sendMessage');