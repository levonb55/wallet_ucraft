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

Auth::routes(['verify' => true]);

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    // Card routes
    Route::get('cards', 'CardController@index')->name('cards.index');
    Route::post('cards', 'CardController@store')->name('cards.store');
    Route::delete('cards/{card}', 'CardController@destroy')->name('cards.destroy');

    // Payment routes
    Route::get('payments', 'PaymentController@index')->name('payments.index');
});

// Social routes
Route::get('login/{provider}', 'Auth\SocialController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\SocialController@handleProviderCallback');
