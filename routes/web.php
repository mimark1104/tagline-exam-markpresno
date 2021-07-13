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
Route::get('/', 'ItemController@index');
Route::get('/catalog', 'ItemController@index');

Route::middleware("admin")->group(function(){
	//Admin CRUD
	Route::get('/admin/additem', 'ItemController@create');
	Route::post('/admin/additem', 'ItemController@store');
	Route::get('/admin/edititem/{id}', 'ItemController@edit');
	Route::patch('/admin/edititem/{id}', 'ItemController@update');
	Route::delete('/admin/delete/{id}', 'ItemController@destroy');

	//User CRUD
	Route::get('/users', 'UserController@index');
	Route::patch('/admin/updateuserrole/{id}', 'UserController@updaterole');

	Route::get('/admin/allorders', 'OrderController@index');
	Route::patch('/admin/cancelorder/{id}', 'OrderController@cancelorder');
	Route::patch('/admin/markaspaid/{id}', 'OrderController@markaspaid');
});

Route::middleware("user")->group(function(){
	//Order CRUD
	Route::get('/cart/checkout', 'OrderController@checkout');
	Route::get('/orders', 'OrderController@indivorder');
});

//Cart CRUD
Route::post('/addtocart/{id}', 'ItemController@addtocart');
Route::get('/cart', 'ItemController@showcart');
Route::delete('/cart/changeqty/{id}', 'ItemController@changeqty');
Route::get('/cart/emptycart', 'ItemController@emptycart');
Route::patch('/cart/updateqty', 'ItemController@updateqty');

