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
Route::get('/product/{product}-{slug}', 'ProductController@show')->name('product.show');
Route::get('/product/search', 'ProductController@search')->name('product.search');
Route::get('/product/getAll', 'ProductController@getAll')->name('product.getAll');
Route::get('/product/{product}/edit', 'ProductController@edit')->name('product.edit');
Route::post('/product', 'ProductController@store')->name('product.store');
Route::delete('/product/{product}', 'ProductController@destroy')->name('product.destroy');
Route::patch('/product/{product}/', 'ProductController@update')->name('product.update');


Route::get('/Catagory/{catagory}', 'CatagoryController@show')->name('catagory.show');

Route::patch('/rating/{product}', 'RatingController@update')->name('rating.update');

Route::get('/Comment/create', 'CommentController@create')->name('comment.create');
Route::delete('/Comment/{comment}', 'CommentController@destroy')->name('comment.destroy');
Route::patch('/Comment/{comment}', 'CommentController@update')->name('comment.update');
Route::post('/Comment/{comment}/like', 'CommentController@like')->name('comment.like');

Route::post('/Comment/{comment}/store', 'ReplyController@store')->name('reply.store');
Route::delete('/reply/{reply}', 'ReplyController@destroy')->name('reply.destroy');

Route::get('/cart', 'CartController@index')->name('cart.index');
Route::get('/get-carts', 'CartController@getCarts')->name('cart.get-carts');
Route::get('/cart/all', 'CartController@all')->name('cart.all');
Route::get('/cart/search', 'CartController@search')->name('cart.search');
Route::post('/cart', 'CartController@store')->name('cart.store');
Route::patch('/cart/{cart}/finish', 'CartController@finish')->name('cart.finish');
Route::patch('/cart/{cart}', 'CartController@update')->name('cart.update');
Route::patch('/cart/add-to-cart/{cart}', 'CartController@addToCart')->name('cart.add-to-cart');
Route::patch('/cart/safe-for-late/{cart}', 'CartController@safeForLate')->name('cart.safe-for-late');
Route::delete('/cart/{cart}', 'CartController@destroy')->name('cart.destroy');

Route::get('/account/', 'AccountController@show')->name('account.show');
Route::get('/account/change-password', 'AccountController@changePassword')->name('account.change-password');
Route::get('/process/create', 'ProcessController@create')->name('process.create');
Route::get('/process', 'ProcessController@index')->name('process.index');
Route::patch('/account', 'AccountController@update')->name('account.update');
Route::patch('/account/update-password', 'AccountController@updatePassWord')->name('account.update-password');
Route::patch('/process', 'ProcessController@update')->name('process.update');