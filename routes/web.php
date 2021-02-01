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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'LabelNumController@show');
Route::get('/test', 'LabelNumController@test');

Route::get('/dailyCount', 'LabelNumController@dailyCount');

Route::get('/labelSetting', 'LabelSettingController@show');
Route::get('/labelSetting/input', 'LabelSettingController@input');
Route::post('/labelSetting/Save', 'LabelSettingController@save');



Route::post('/LabelNum/input', 'LabelNumController@input');
Route::post('/LabelNum/testPost', 'LabelNumController@testPost');

