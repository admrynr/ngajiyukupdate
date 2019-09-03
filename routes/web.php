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

Route::get('/', 'HomeController@index')->name('home');


Route::get('main', 'DefaultController@index');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/list', 'ListModelController@index')->name('list');
Route::get('/list/add', 'ListModelController@add')->name('add');
Route::post('/list/store', 'ListModelController@store')->name('store');
Route::get('/list/edit/{id}', 'ListModelController@edit')->name('edit');
Route::post('/list/update/{id}', 'ListModelController@update')->name('update');
Route::get('/list/hapus/{id}', 'ListModelController@delete')->name('hapus');

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/unverified', 'Auth\LoginController@unverify')->name('unverified');
Route::get('/login/regsuccess', 'Auth\LoginController@regsuccess')->name('regsuccess');
Route::post('/login', 'Auth\LoginController@authenticate')->name('login');

Route::get('/register', 'RegController@index')->name('register');
Route::post('/register/store', 'RegController@register')->name('store');

Route::get('/authuser', 'AuthenticateUserController@index')->name('authuser');
Route::get('/verify/{id}', 'AuthenticateUserController@verify')->name('verify');


