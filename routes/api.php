<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::name('category.')->group(function () {
    Route::get('category/getAll', 'CategoryController@getAll')->name('getAll');
});

Route::name('regions.')->group(function () {
    Route::get('region/getAll', 'RegionController@getAll')->name('getAll');
});

Route::name('data.')->group(function () {
    Route::post('data/getAll', 'DataController@getAll')->name('getAll');
    Route::post('data/getListing', 'DataController@getListing')->name('getListing');
});

Route::group(['prefix' => 'v1','middleware' => 'auth:api'], function () {
});

// localization
// show listing
// compare ?
// export ?