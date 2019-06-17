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
//App::setLocale('ja');

Route::get('/help', 'HomeController@help')->name('help');
Route::get('/notice', 'HomeController@notice')->name('notice');
Route::Post('/getrsg', 'HomeController@getrsg')->name('getrsg');
Route::get('/{customer_email?}', 'HomeController@index')->name('home');


