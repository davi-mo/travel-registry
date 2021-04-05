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
    });
    Route::get('/regions/countries', '\App\Http\Controllers\RegionController@getActiveRegions')->name('getActiveRegions');
    Route::post('/countries', '\App\Http\Controllers\CountryController@getCountriesByRegion')->name('getCountriesByRegion');
});
