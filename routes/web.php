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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/Product/create', 'ProductController@create')->name('product.create');
Route::post('/Product', 'ProductController@store')->name('product');
Route::get('/Product/{product}', 'ProductController@show')->name('product.show');

Route::get('/Catagory/{catagory}', 'CatagoryController@show')->name('catagory.show');

Route::patch('/rating/{product}', 'RatingController@update')->name('rating.update');

Route::get('/Comment/create', 'CommentController@create')->name('comment.create');
Route::delete('/Comment/{comment}', 'CommentController@destroy')->name('comment.destroy');
Route::patch('/Comment/{comment}', 'CommentController@update')->name('comment.update');