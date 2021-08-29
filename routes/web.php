<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware('guest')->group(function () {
	Route::get('/login', 'CommonController@login')->name('login');
	Route::post('/login', 'CommonController@loginProcess')->name('login.process');
});

Route::middleware('auth')->group(function () {
	Route::get('/logout', 'CommonController@logout')->name('logout');
	Route::get('/home', 'CommonController@home')->name('home');

	Route::get('/account', 'CommonController@account')->name('account');
	Route::post('/account', 'CommonController@accountUpdate')->name('account.update');
	Route::post('/configs', 'CommonController@configsUpdate')->name('configs.update');

	Route::prefix('category')->group(function () {
		Route::get('/', 'CategoryController@index')->name('category.index');
		Route::get('/form/{uuid?}', 'CategoryController@form')->name('category.form');
		Route::post('/store', 'CategoryController@store')->name('category.store');
		Route::post('/{uuid}/update', 'CategoryController@update')->name('category.update');
		Route::get('/{uuid}/destroy', 'CategoryController@destroy')->name('category.destroy');
	});
	Route::prefix('link')->group(function () {
		Route::get('/', 'LinkController@index')->name('link.index');
		Route::get('/form/{uuid?}', 'LinkController@form')->name('link.form');
		Route::post('/store', 'LinkController@store')->name('link.store');
		Route::post('/{uuid}/update', 'LinkController@update')->name('link.update');
		Route::get('/{uuid}/destroy', 'LinkController@destroy')->name('link.destroy');
	});
});

Route::get('/', 'CommonController@index')->name('homepage');
Route::get('/{custom}', 'LinkController@goto');
