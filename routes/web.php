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


Route::post('/rsg_signup', 'RsgLoginController@signup')->name('rsg_signup');
Route::post('/rsg_signup_handle', 'RsgLoginController@signupHandle')->name('rsg_signup_handle');

Route::post('/rsg_signin', 'RsgLoginController@signin')->name('rsg_signin');
Route::post('/rsg_signin_handle', 'RsgLoginController@signinHandle')->name('rsg_signin_handle');

Route::get('/rsg_activation', 'RsgLoginController@activation')->name('rsg_activation');
Route::get('/rsg_logout', 'RsgLoginController@logout')->name('rsg_logout');


Route::get('/help', 'HomeController@help')->name('help');
Route::get('/notice', 'HomeController@notice')->name('notice');
Route::Post('/getrsg', 'HomeController@getrsg')->name('getrsg');

Route::get('/product/detail', 'ProductController@detail')->name('detail');

Route::get('/terms', 'HomeController@terms')->name('terms');
Route::get('/private_policy', 'HomeController@private_policy')->name('private_policy');

/*
 * 弹窗插件模块
 */
Route::match(['post','get'],'/api/getCode', 'ApiController@getCode');//得到验证码方法，
Route::match(['post','get'],'/api/verifyCode', 'ApiController@verifyCode');//验证填写的验证码是否正确


//这一行代码一定要放在最下面。若有get路由放在它后面，则这些get路由不能正常工作。
Route::get('/{customer_email?}', 'HomeController@index')->name('home');
