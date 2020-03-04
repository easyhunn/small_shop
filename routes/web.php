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

Route::get('/product/create', 'ProductController@create')->name('product.create');
Route::post('/product', 'ProductController@store')->name('product.store');
Route::get('/product/{product}-{slug}', 'ProductController@show')->name('product.show');
Route::get('/product/search', 'ProductController@search')->name('product.search');
Route::get('/product/getAll', 'ProductController@getAll')->name('product.getAll');


Route::get('/Catagory/{catagory}', 'CatagoryController@show')->name('catagory.show');

Route::patch('/rating/{product}', 'RatingController@update')->name('rating.update');

Route::get('/Comment/create', 'CommentController@create')->name('comment.create');
Route::delete('/Comment/{comment}', 'CommentController@destroy')->name('comment.destroy');
Route::patch('/Comment/{comment}', 'CommentController@update')->name('comment.update');
Route::post('/Comment/{comment}/like', 'CommentController@like')->name('comment.like');

Route::post('/Comment/{comment}/store', 'ReplyController@store')->name('reply.store');
Route::delete('/reply/{reply}', 'ReplyController@destroy')->name('reply.destroy');

Route::get('/cart', 'CartController@index')->name('cart.index');
Route::post('/cart', 'CartController@store')->name('cart.store');
Route::patch('/cart/{cart}', 'CartController@update')->name('cart.update');
Route::get('/get-carts', 'CartController@getCarts')->name('cart.get-carts');
Route::delete('/cart/{cart}', 'CartController@destroy')->name('cart.destroy');
Route::post('/cart/add-to-cart', 'CartController@addToCart')->name('cart.add-to-cart');

Route::post('/auxilary-cart', 'AuxiliaryCartController@store')->name('auxiliary-cart.store');
Route::delete('/auxilary-cart/{auxiliaryCart}', 'AuxiliaryCartController@destroy')->name('auxiliary-cart.destroy');

Route::get('/account/', 'AccountController@show')->name('account.show');
Route::get('/account/change-password', 'AccountController@changePassword')->name('account.change-password');
Route::patch('/account', 'AccountController@update')->name('account.update');
Route::patch('/account/update-password', 'AccountController@updatePassWord')->name('account.update-password');
