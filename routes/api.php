<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(function () {
    // Below mention routes are public, user can access those without any restriction.
    // Create New User
    Route::post('register', 'Auth\AuthController@register');
    // Login User
    Route::post('login', 'Auth\AuthController@login');

    // Refresh the JWT Token
    Route::get('refresh', 'Auth\AuthController@refresh');

    // Below mention routes are available only for the authenticated users.
    Route::middleware('auth:api')->group(function () {
        // Get user info
        Route::get('user', 'Auth\AuthController@user');
        // Logout user from application
        Route::post('logout', 'Auth\AuthController@logout');
    });
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('profiles/{profile}/properties', 'Admin\ProfileController@getProperties');
    Route::get('profiles/{profile}/bookings', 'Admin\ProfileController@getBookings');
    Route::get('profiles/{profile}/feedbacks', 'Admin\ProfileController@getFeedbacks');
    Route::get('profiles/gender', 'Admin\ProfileController@getGender');
    Route::apiResource('profiles', 'Admin\ProfileController');

    Route::get('properties/{property}/profiles', 'Admin\PropertyController@getProfiles');
    Route::get('properties/{property}/bookings', 'Admin\PropertyController@getBookings');
    Route::get('properties/{property}/feedbacks', 'Admin\PropertyController@getFeedbacks');
    Route::get('properties/{property}/calendars', 'Admin\PropertyController@getCalendars');
    Route::get('properties/host_types', 'Admin\PropertyController@getHostTypes');
    Route::apiResource('properties', 'Admin\PropertyController');

    Route::apiResource('property_types', 'Admin\PropertyTypeController');

    Route::apiResource('calendars', 'Admin\CalendarController');

    Route::apiResource('bookings', 'Admin\BookingController');

    Route::apiResource('feedbacks', 'Admin\FeedbackController');

    Route::get('countries', 'Admin\GeoController@getCountries');
    Route::get('countries/{country}/states', 'Admin\GeoController@getStatesByCountry');
    Route::get('states/{state}/country', 'Admin\GeoController@getCountryByState');
    Route::get('states/{state}/cities', 'Admin\GeoController@getCitiesByState');
    Route::get('cities/{city}/state', 'Admin\GeoController@getStateByCity');
});


