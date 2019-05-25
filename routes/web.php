<?php

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
    return view('imports');
});

Route::group(['middleware' => 'auth'], function () {
    Route::name('import.')->group(function () {
        Route::get('import', 'ImportController@index')->name('index');

        Route::post('import/region', 'ImportController@region')->name('region');
        Route::post('import/city', 'ImportController@city')->name('city');
        Route::post('import/township', 'ImportController@township')->name('township');

        Route::post('import/hospital', 'ImportController@hospital')->name('hospital');
        Route::post('import/drinking_water', 'ImportController@drinking_water')->name('drinking_water');
        Route::post('import/religion', 'ImportController@religion')->name('religion');
        Route::post('import/live_stock', 'ImportController@live_stock')->name('live_stock');
        Route::post('import/diaster', 'ImportController@diaster')->name('diaster');
        Route::post('import/heritage', 'ImportController@heritage')->name('heritage');
    });

    Route::resource('profiles', 'ProfileController');
});