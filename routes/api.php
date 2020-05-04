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

/*
Route::group(['prefix' => 'auth.jwt'], function() {
        Route::post('register', 'Auth\AuthController@register');
        Route::post('login', 'Auth\AuthController@login');
        Route::get('refresh', 'Auth\AuthController@refresh');
        Route::group(['middleware' => 'auth:api'], function(){
            Route::get('user', 'Auth\AuthController@user');
            Route::post('logout', 'Auth\AuthController@logout');
        });
});
*/

//Route::group(['middleware' => 'auth.jwt'], function () {
    Route::post('auth/register', 'Auth\AuthController@register');

    Route::get('profiles/gender', 'Admin\ProfileController@getGender');
    Route::apiResource('profiles', 'Admin\ProfileController');

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

//});


