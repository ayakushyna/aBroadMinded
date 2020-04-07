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


Route::group(['prefix' => 'profiles'], function () {
    Route::get('/', 'ProfileController@index')->name('profiles');
    Route::get('/{id}', 'ProfileController@show')->where('id', '[0-9]+')->name('profiles.show');
    //Route::middleware(['auth'])->group(function () {
        Route::get('/create', 'ProfileController@create')->name('profiles.create');
        Route::post('/store', 'ProfileController@store')->name('profiles.store');
        Route::get('/{id}/edit', 'ProfileController@edit')->where('id', '[0-9]+')->name('profiles.edit');
        Route::put('/{id}', 'ProfileController@update')->where('id', '[0-9]+')->name('profiles.update');
        Route::delete('/{id}', 'ProfileController@destroy')->where('id', '[0-9]+')->name('profiles.destroy');
    //});
});

Route::group(['prefix' => 'properties'], function () {
    Route::get('/', 'PropertyController@index')->name('properties');
    Route::get('/{id}', 'PropertyController@show')->where('id', '[0-9]+')->name('properties.show');
    //Route::middleware(['auth'])->group(function () {
        Route::get('/create', 'PropertyController@create')->name('properties.create');
        Route::post('/store', 'PropertyController@store')->name('properties.store');
        Route::get('/{id}/edit', 'PropertyController@edit')->where('id', '[0-9]+')->name('properties.edit');
        Route::put('/{id}', 'PropertyController@update')->where('id', '[0-9]+')->name('properties.update');
        Route::delete('/{id}', 'PropertyController@destroy')->where('id', '[0-9]+')->name('properties.destroy');
    //});
});

Route::group(['prefix' => 'bookings'], function () {
    Route::get('/', 'BookingController@index')->name('bookings');
    Route::get('/{id}', 'BookingController@show')->where('id', '[0-9]+')->name('bookings.show');
    //Route::middleware(['auth'])->group(function () {
        Route::get('/create', 'BookingController@create')->name('bookings.create');
        Route::post('/store', 'BookingController@store')->name('bookings.store');
        Route::get('/{id}/edit', 'BookingController@edit')->where('id', '[0-9]+')->name('bookings.edit');
        Route::put('/{id}', 'BookingController@update')->where('id', '[0-9]+')->name('bookings.update');
        Route::delete('/{id}', 'BookingController@destroy')->where('id', '[0-9]+')->name('bookings.destroy');
    //});
});

Route::group(['prefix' => 'feedbacks'], function () {
    Route::get('/', 'FeedbackController@index')->name('feedbacks');
    Route::get('/{id}', 'FeedbackController@show')->where('id', '[0-9]+')->name('feedbacks.show');
    //Route::middleware(['auth'])->group(function () {
        Route::get('/create', 'FeedbackController@create')->name('feedbacks.create');
        Route::post('/store', 'FeedbackController@store')->name('feedbacks.store');
        Route::get('/{id}/edit', 'FeedbackController@edit')->where('id', '[0-9]+')->name('feedbacks.edit');
        Route::put('/{id}', 'FeedbackController@update')->where('id', '[0-9]+')->name('feedbacks.update');
        Route::delete('/{id}', 'FeedbackController@destroy')->where('id', '[0-9]+')->name('feedbacks.destroy');
    //});
});
