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
    return view('welcome');
});

Route::get('/we', function () {
    return view('home');
});


Route::get('/templ', function () {
    return view('image');
});

Auth::routes();


Route::get('/longread', 'LongreadController@load');
Route::get('/longread/{id}', 'LongreadController@loadLongread');
Route::get('/longread/{id}/load', 'LongreadController@loadBlocks');
Route::post('/longread/{id}/save', 'LongreadController@saveBlocks');
// Route::get('/home', 'HomeController@index')->name('home');
