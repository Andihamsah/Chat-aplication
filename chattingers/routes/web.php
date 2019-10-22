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
Route::put('/mobile/edit', 'AuthController@mobileupdate');
Route::put('/password/edit', 'AuthController@privasi');
Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
Route::get('tampil/{id}', 'AuthController@index');

//freind 
Route::post('friend/add','AuthController@addFriend');
Route::get('friend/{id}','AuthController@getFriend');


// Chat
Route::get('/chat/{id}','chatController@index');
Route::delete('/chat/delete/{id}','chatController@destroy');
Route::get('/search','chatController@search');
Route::post('/chat/send','chatController@store');
Route::get('/chat/show/{sender_id}/{receiver_id}','chatController@show');


// //demo
// Route::get('/demo/register','AuthController@registerDemo')->name('demoRegister');
// Route::post('/demo/register/send','AuthController@storeDemo')->name('demoSendRegister');
// Route::get('/demo/login','AuthController@loginDemo')->name('demoLogin');
// Route::post('/demo/login/send','AuthController@loginDemoSend')->name('demoSendLogin');
// Route::get('/demo/chat/{sender_id}/{receiver_id}','AuthController@demoChat')->name('demoChat');
// Route::post('/demo/send/chat','AuthController@demoSendChat')->name('demoSendChat');
// // chat
// Route::get('/chat','chatController@index');
// Route::post('/chat/send','chatController@store');
// Route::get('/chat/show/{sender_id}/{receiver_id}','chatController@show');
// // Route::put('/chat/edit/');

//fix chat
Route::get('/message/{sender_id}/{receiver_id}','chatController@getMessage');
Route::post('/message/send','chatController@sendMessage');