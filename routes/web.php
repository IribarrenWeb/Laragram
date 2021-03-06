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

use Illuminate\Support\Facades\Auth;

Auth::routes(['logout' => false, 'reset' => false, 'verify' => false]);

Route::any('/logout',function(){
    Auth::logout();
    return redirect()->route('login');
});

Route::get('/info',function(){
    phpinfo();
});

// INDEX ROUTE
Route::get('/', 'HomeController@index')->name('home');
Route::get('/getimages', 'HomeController@getImages')->name('home.get');

// USER ROUTES
Route::get('/config', 'UserController@config')->name('uconfig');
Route::post('/user/update', 'UserController@update')->name('update');
Route::get('/user/{nick}', 'UserController@perfil')->name('user.perfil');
Route::get('/gente', 'UserController@index')->name('user.index');
Route::get('/gente/{query}', 'UserController@search')->name('user.search');
Route::get('/user/avatar/{user}/{filename}', 'UserController@getImage')->name('user.avatar');
Route::get('/user/avatar/{filename}', 'UserController@getImage')->name('user.avatar');
Route::get('/getauth', 'UserController@getAuth')->middleware('ajax')->name('user.auth');

// IMAGE ROUTES
Route::get('/image/subir', 'ImageController@create')->name('image.create');
Route::post('/image/save', 'ImageController@save')->name('image.save');
Route::get('/image/get/{filename}', 'ImageController@getImage')->name('image.get');
Route::get('/image/detail/{image_id}', 'ImageController@detail')->name('image.detail');
Route::get('/image/delete/{image}', 'ImageController@delete')->name('image.delete');
Route::get('/image/edit/{image}', 'ImageController@edit')->name('image.edit');
Route::post('/image/update/', 'ImageController@update')->name('image.update');

// COMMENTS ROUTES
Route::post('/comment/save', 'CommentController@create')->name('comment.save');
Route::get('/comment/delete/{id}/{image_id}', 'CommentController@delete')->name('comment.delete');
Route::get('/comment/get/{image}', 'CommentController@getOneComment')->name('comment.get');

// LIKES ROUTES
Route::get('/like/{image}', 'LikeController@like')->name('like.make');
Route::get('/dislike/{image_id}', 'LikeController@dislike')->name('dislike.make');
Route::get('/likes/user', 'LikeController@show_likes')->name('likes.user');
Route::get('/likes/get', 'LikeController@getLikes')->name('likes.get');

