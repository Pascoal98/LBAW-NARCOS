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
// Home
Route::get('/', 'HomeController@show')->name('home');

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// User
Route::get('user/{id}', 'UserController@show')->name('userProfile')->where(['id' => '[0-9]+']);
Route::get('user/{id}/edit', 'UserController@edit')->name('editProfile')->where(['id' => '[0-9]+']);

//Static Pages
Route::get('about', 'StaticPagesController@getAboutUs')->name('about');
Route::get('faq', 'StaticPagesController@getFAQ')->name('faq');