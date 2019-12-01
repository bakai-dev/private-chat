<?php



Route::get('/', function () {
    return view('welcome');
});

Route::post('getFriend', 'HomeController@getFriend');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();
