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

Route::get('users/{user}/listing', 'ListingController@index')->name('listing.index');

Route::get('users/{user}/listing/create', 'ListingController@create')->name('listing.create');

Route::post('users/{user}/listing', 'ListingController@store')->name('listing.store');

Route::get('listing/{listing}', 'ListingController@show')->name('listing.show');

Route::delete('listing/{listing}', 'ListingController@destroy')->name('listing.destroy');

Route::middleware('auth')->group(function()
{
    Route::post('listing/{listing}/transaction', 'TransactionController@store')->name('transaction.store');
    
    Route::get('transaction/{transaction}/edit', 'TransactionController@edit')->name('transaction.edit');
    
    Route::patch('transaction/{transaction}', 'TransactionController@update')->name('transaction.update');

    Route::get('transactions/{transaction}', 'TransactionController@show')->name('transaction.show');
    
    Route::get('users/{user}/transactions', 'TransactionController@index')->name('transaction.index');

    Route::patch('transaction/{transaction}/shipped', 'TransactionController@markShipped')->name('transaction.shipped');
    
    Route::patch('transaction/{transaction}/received', 'TransactionController@markDelivered')->name('transaction.received');

    Route::patch('transaction/{transaction}/contest', 'TransactionController@makeClaim')->name('transaction.contest');
});

Route::post('/pay', 'PaymentController@payNow')->name('pay');

Route::get('/success', 'PaymentController@handleGatewayCallback')->name('paystack.success');

Route::webhooks('/webhook', 'paystack');

Route::webhooks('/nexmo/webhook', 'nexmo');

Route::get('/contact', 'ContactUsController@create')->name('contact.create');

Route::post('/contact/store', 'ContactUsController@store')->name('contact.store');
