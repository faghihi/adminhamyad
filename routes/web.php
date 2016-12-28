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
    return redirect('/admin');
});

Auth::routes();

Auth::routes();

//Route::get('/Picker','\TCG\Voyager\Http\Controllers\VoyagerMediaController@picker');
//Route::get('/Test',function (){
//    return view('test');
//});

//Route::get('configs',function (){
//    phpinfo();
//});