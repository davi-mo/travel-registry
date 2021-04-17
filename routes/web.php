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

Route::get('/login', '\App\Http\Controllers\AuthGoogleController@redirectToProvider')->name('login');
Route::get('/callback', '\App\Http\Controllers\AuthGoogleController@handleProviderCallback')->name('callback');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', '\App\Http\Controllers\HomeController@home')->name('home');
    Route::get('/regions', '\App\Http\Controllers\RegionController@getAllRegions')->name('getAllRegions');
    Route::group(['middleware' => ['existing-region']], function () {
        Route::put('/region/{regionId}/update', '\App\Http\Controllers\RegionController@updateRegion')->name('updateRegion');
        Route::get('/regions/{regionId}/countries', '\App\Http\Controllers\CountryController@getCountriesByRegion')->name('getCountriesByRegion');
    });

    Route::group(['middleware' => ['existing-country']], function () {
        Route::get('/country/{countryId}/edit','\App\Http\Controllers\CountryController@editCountryPage')->name('editCountryPage');
        Route::put('/country/{countryId}/update', '\App\Http\Controllers\CountryController@updateCountry')->name('updateCountry');
        Route::get('/country/{countryId}/cities', '\App\Http\Controllers\CityController@getCitiesByCountry')->name('getCitiesByCountry');
    });

    Route::get("visited-cities", '\App\Http\Controllers\VisitedCityController@getByUser')->name('visitedCities');

    Route::group(['middleware' => ['validate-visited-city']], function() {
        Route::get('/visited-cities/{visitedCityId}/edit','\App\Http\Controllers\VisitedCityController@editVisitedCity')->name('editVisitedCity');
        Route::put('/visited-cities/{visitedCityId}/update', '\App\Http\Controllers\VisitedCityController@updateVisitedCity')->name('updateVisitedCity');
        Route::delete('/visited-cities/{visitedCityId}', '\App\Http\Controllers\VisitedCityController@deleteVisitedCity')->name('deleteVisitedCity');
    });

    Route::group(['middleware' => ['existing-city']], function () {
        Route::get('/city/{cityId}/edit','\App\Http\Controllers\CityController@editCityPage')->name('editCityPage');
        Route::put('/city/{cityId}/update', '\App\Http\Controllers\CityController@updateCity')->name('updateCity');
    });
});
