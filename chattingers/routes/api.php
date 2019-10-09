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
Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');

// Chat
Route::post('/chat','chatController@store');
Route::get('/chat/show/{sender_id}/{receiver_id}','chatController@show');
// Route::apiResource('books', 'BookController');
// Route::post('books/{book}/ratings', 'RatingController@store');