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
Route::get('tampil/{id}', 'AuthController@index');
Route::put('/avatar/edit', 'AuthController@updateavatar');
Route::put('/user/edit', 'AuthController@updateuser');
Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
Route::put('/user','AuthController@edit');

// Chat
Route::get('/chat/{id}','chatController@index');
Route::post('/chat/send','chatController@store');
Route::get('/chat/show/{sender_id}/{receiver_id}','chatController@show');


//demo
Route::get('/demo/register','AuthController@registerDemo')->name('demoRegister');
Route::post('/demo/register/send','AuthController@storeDemo')->name('demoSendRegister');
Route::get('/demo/login','AuthController@loginDemo')->name('demoLogin');
Route::post('/demo/login/send','AuthController@loginDemoSend')->name('demoSendLogin');
Route::get('/demo/chat/{sender_id}/{receiver_id}','AuthController@demoChat')->name('demoChat');
Route::post('/demo/send/chat','AuthController@demoSendChat')->name('demoSendChat');