<?php

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

Route::get('/', function () {
    return view('welcome');
});
// User
Route::get('/tampil', 'AuthController@show');
Route::put('/avatar/edit', 'AuthController@updateavatar');
Route::put('/user/edit', 'AuthController@updateuser');
Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
Route::get('tampil/{id}', 'AuthController@index');

// chat
Route::get('/chat','chatController@index');
Route::post('/chat/send','chatController@store');
Route::get('/chat/show/{sender_id}/{receiver_id}','chatController@show');
// Route::put('/chat/edit/');
