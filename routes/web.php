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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('users/{user}/profile/create', 'ProfileController@create')->name('profile.create');

Route::post('users/{user}/profile', 'ProfileController@store')->name('profile.store');

Route::get('profile/{profile}', 'ProfileController@show')->name('profile.show');

Route::get('profile/{profile}/edit', 'ProfileController@edit')->name('profile.edit');

Route::patch('profile/{profile}', 'ProfileController@update')->name('profile.update');

Route::delete('profile/{profile}', 'ProfileController@destroy')->name('profile.destroy');
