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

Route::name('subcategory.')->group(function () {
    Route::get('subcategory/getAll', 'CategoryController@getAllSub')->name('getAllSub');
});

Route::name('regions.')->group(function () {
    Route::get('region/getAll', 'RegionController@getAll')->name('getAll');
});

Route::name('data.')->group(function () {
    Route::post('data/getAllForCity', 'DataController@getAllForCity')->name('getAllForCity');
    Route::post('data/getListing', 'DataController@getListing')->name('getListing');
    Route::post('data/compare', 'DataController@compare')->name('compare');
});

Route::group(['prefix' => 'v1','middleware' => 'auth:api'], function () {
});