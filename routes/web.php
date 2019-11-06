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



Route::get('/activation', 'LoginController@activation')->name('activation');

Route::get('/help', 'HomeController@help')->name('help');
Route::get('/notice', 'HomeController@notice')->name('notice');
Route::Post('/getrsg', 'HomeController@getrsg')->name('getrsg');

Route::get('/product/detail', 'ProductController@detail')->name('detail');
Route::get('/{customer_email?}', 'HomeController@index')->name('home');


Route::post('/signup', 'LoginController@signup')->name('signup');
Route::post('/signup_handle', 'LoginController@signupHandle')->name('signup_handle');

Route::post('/signin', 'LoginController@signin')->name('signin');
Route::post('/signin_handle', 'LoginController@signinHandle')->name('signin_handle');
