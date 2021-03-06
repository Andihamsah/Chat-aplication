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

//freind 
Route::post('friend/{id_login}/{friend_id}','AuthController@addFriend');
Route::get('friend/{id}','AuthController@getFriend');
Route::delete('unfriend/{id}/{userid}','AuthController@unfriend');


// Chat
Route::post('/chat/send','chatController@store');
Route::delete('/chat/delete/{id}','chatController@destroy');
Route::get('/chat/show/{sender_id}/{receiver_id}','chatController@show');
Route::post('/search','chatController@search');
Route::get('/message/{sender_id}/{receiver_id}','chatController@getMessage');
Route::post('/message/send','chatController@sendMessage');