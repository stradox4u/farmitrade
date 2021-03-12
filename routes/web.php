<?php

use TCG\Voyager\Facades\Voyager;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

Route::middleware('auth')->group(function()
{
    Route::get('users/{user:uuid}/profile/create', 'ProfileController@create')->name('profile.create');
    
    Route::post('users/{user:uuid}/profile', 'ProfileController@store')->name('profile.store');
    
    Route::get('profile/{profile:uuid}', 'ProfileController@show')->name('profile.show');
    
    Route::get('profile/{profile:uuid}/edit', 'ProfileController@edit')->name('profile.edit');
    
    Route::patch('profile/{profile:uuid}', 'ProfileController@update')->name('profile.update');
    
    Route::delete('profile/{profile:uuid}', 'ProfileController@destroy')->name('profile.destroy');
    
    Route::get('users/{user:uuid}/listing', 'ListingController@index')->name('listing.index');
    
    Route::get('users/{user:uuid}/listing/create', 'ListingController@create')->name('listing.create');
    
    Route::post('users/{user:uuid}/listing', 'ListingController@store')->name('listing.store');
    
    Route::get('listing/{listing:uuid}', 'ListingController@show')->name('listing.show');
    
    Route::delete('listing/{listing:uuid}', 'ListingController@destroy')->name('listing.destroy');
    
    Route::post('listing/{listing:uuid}/transaction', 'TransactionController@store')->name('transaction.store');
    
    Route::get('transaction/{transaction:uuid}/edit', 'TransactionController@edit')->name('transaction.edit');
    
    Route::patch('transaction/{transaction:uuid}', 'TransactionController@update')->name('transaction.update');

    Route::get('transactions/{transaction:uuid}', 'TransactionController@show')->name('transaction.show');
    
    Route::get('users/{user:uuid}/transactions', 'TransactionController@index')->name('transaction.index');

    Route::patch('transaction/{transaction:uuid}/shipped', 'TransactionController@markShipped')->name('transaction.shipped');
    
    Route::patch('transaction/{transaction:uuid}/received', 'TransactionController@markDelivered')->name('transaction.received');

    Route::patch('transaction/{transaction:uuid}/contest', 'TransactionController@makeClaim')->name('transaction.contest');
    
    Route::middleware('verified')->group(function() 
    {
        Route::get('/contact', 'ContactUsController@create')->name('contact.create');
        
        Route::post('/contact/store', 'ContactUsController@store')->name('contact.store');
    });
});

Route::post('/pay', 'PaymentController@payNow')->name('pay');

Route::get('/success', 'PaymentController@handleGatewayCallback')->name('paystack.success');

Route::webhooks('/webhook', 'paystack');

// Route::webhooks('/nexmo/webhook', 'nexmo');


Route::middleware('auth')->group(function()
{
    Route::get('users/{transaction:uuid}/rate', 'RatingsController@edit')->name('rating.edit');
    
    Route::post('users/{user:uuid}/rating', 'RatingsController@update')->name('rating.update');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

    Route::middleware('can:create-subaccount')->group(function() {

        Route::get('/subaccount/create', 'PaystackSubaccountController@create')->name('subaccount.create')->middleware('auth');
    
        Route::post('/subaccount/store', 'PaystackSubaccountController@store')->name('subaccount.store')->middleware('auth');
    });
});


