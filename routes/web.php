<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/test',function(){
   return \App\User::all();
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/Picker','\TCG\Voyager\Http\Controllers\VoyagerMediaController@picker');
Route::get('/Test',function (){
    return view('test');
});

Route::get('configs',function (){
    phpinfo();
});