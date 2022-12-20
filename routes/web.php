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
Route::put('user/{id}', 'UserController@update')->name('editProfile')->where(['id' => '[0-9]+']);
Route::delete('user/{id}', 'UserController@delete')->name('deleteUser')->where(['id' => '[0-9]+']);
Route::post('user/{id}/report', 'UserController@report')->where(['id' => '[0-9]+']);
Route::get('user/{id}/followed', 'UserController@followed')->name('followedUsers')->where(['id' => '[0-9]+']);
Route::post('user/{id}/follow', 'UserController@follow')->where(['id' => '[0-9]+']);
Route::post('user/{id}/unfollow', 'UserController@unfollow')->where(['id' => '[0-9]+']);

// Articles
Route::get('article', 'ArticleController@createForm')->name('createArticle');
Route::post('article', 'ArticleController@create');
Route::get('article/{id}', 'ArticleController@show')->name('article')->where(['id' => '[0-9]+']);
Route::get('article/{id}/edit', 'ArticleController@edit')->name('editArticle')->where(['id' => '[0-9]+']);
Route::put('article/{id}/edit', 'ArticleController@update')->where(['id' => '[0-9]+']);
Route::delete('article/{id}', 'ArticleController@delete')->where(['id' => '[0-9]+']);


// Search
Route::get('search', 'SearchController@show')->name('search');
Route::get('search/users', 'SearchController@searchUsers');
Route::get('search/articles', 'SearchController@searchArticles');

// Comments
Route::post('comment', 'CommentController@create');
Route::put('comment/{id}', 'CommentController@update')->where(['id' => '[0-9]+']);
Route::delete('comment/{id}', 'CommentController@destroy')->where(['id' => '[0-9]+']);

// Content
Route::delete('content/{id}', 'ContentController@removeFeedback')->where(['id' => '[0-9]+']);
Route::put('content/{id}', 'ContentController@giveFeedback')->where(['id' => '[0-9]+']);

// Admin
Route::get('admin', 'AdminController@show')->name('admin');
Route::get('admin/suspensions', 'AdminController@suspensions');
Route::post('user/{id}/suspend', 'AdminController@suspendUser')->where(['id' => '[0-9]+']);
Route::put('user/{id}/unsuspend', 'AdminController@unsuspendUser')->where(['id' => '[0-9]+']);
Route::get('admin/reports', 'AdminController@reports');
Route::get('admin/topics', 'AdminController@topics');
Route::put('admin/reports/{id}/close', 'AdminController@closeReport')->where(['id' => '[0-9]+']);

// Topic
Route::put('topics/{topic_id}/accept', 'TopicController@accept')->where(['topic_id' => '[0-9]+']);
Route::put('topics/{topic_id}/reject', 'TopicController@reject')->where(['topic_id' => '[0-9]+']);
Route::put('topics/{topic_id}/add_favorite', 'TopicController@addUserFavorite')->where(['topic_id' => '[0-9]+']);
Route::put('topics/{topic_id}/remove_favorite', 'TopicController@removeUserFavorite')->where(['topic_id' => '[0-9]+']);
Route::delete('topics/{topic_id}', 'TopicController@destroy')->where(['topic_id' => '[0-9]+']);
Route::post('topics/new', 'TopicController@propose');


//Static Pages
Route::get('about', 'StaticPagesController@getAboutUs')->name('about');
Route::get('faq', 'StaticPagesController@getFAQ')->name('faq');