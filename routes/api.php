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
    Route::get('profiles/list', 'Api\ProfileController@getList');
    Route::get('profiles/{profile}/properties', 'Api\ProfileController@getProperties');
    Route::get('profiles/{profile}/bookings', 'Api\ProfileController@getBookings');
    Route::get('profiles/{profile}/feedbacks', 'Api\ProfileController@getFeedbacks');
    Route::get('profiles/gender', 'Api\ProfileController@getGender');
    Route::apiResource('profiles', 'Api\ProfileController');

    Route::get('properties/list', 'Api\PropertyController@getList');
    Route::get('properties/{property}/profiles', 'Api\PropertyController@getProfiles');
    Route::get('properties/{property}/bookings', 'Api\PropertyController@getBookings');
    Route::get('properties/{property}/feedbacks', 'Api\PropertyController@getFeedbacks');
    Route::get('properties/{property}/calendars', 'Api\PropertyController@getCalendars');
    Route::get('properties/host_types', 'Api\PropertyController@getHostTypes');
    Route::apiResource('properties', 'Api\PropertyController');

    Route::apiResource('property_types', 'Api\PropertyTypeController');
    Route::apiResource('calendars', 'Api\CalendarController');
    Route::apiResource('bookings', 'Api\BookingController');
    Route::apiResource('feedbacks', 'Api\FeedbackController');

    Route::get('countries', 'Api\GeoController@getCountries');
    Route::get('countries/{country}/states', 'Api\GeoController@getStatesByCountry');
    Route::get('states/{state}/country', 'Api\GeoController@getCountryByState');
    Route::get('states/{state}/cities', 'Api\GeoController@getCitiesByState');
    Route::get('cities/{city}/state', 'Api\GeoController@getStateByCity');
});


Route::get('profiles/', 'Api\ProfileController@index');
Route::get('properties/', 'Api\PropertyController@index');


