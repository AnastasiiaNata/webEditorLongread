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


Route::get('/', 'LongreadController@logout');



Auth::routes();

Route::get('/longread', 'LongreadsController@load');
Route::get('/longread/load', 'LongreadsController@loadList');
Route::post('/longread/create', 'LongreadsController@create');
Route::post('/longread/save', 'LongreadsController@save');
Route::post('/longread/delete', 'LongreadsController@deleteLongread');
Route::post('/longread/publish', 'LongreadsController@publishLongread');


Route::get('/longread/{id}', 'LongreadController@loadLongread');
Route::get('/longread/{id}/load', 'LongreadController@loadBlocks');
Route::post('/longread/{id}/save', 'LongreadController@saveBlocks');
Route::post('/longread/{id}/publish', 'LongreadController@publishLongread');

Route::get('/longread/{id}/preview', 'LongreadController@loadPreview');
Route::get('/longread/{id}/preview/load', 'LongreadController@loadBlocks');

Route::get('/view/{url}', 'LongreadController@showLongread');

