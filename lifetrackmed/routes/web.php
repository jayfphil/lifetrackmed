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
Route::resource('coronas', 'App\Http\Controllers\CoronaController');
Route::view('/lifetrack', 'lifetrack');
Route::post('/lifetrack/post', 'App\Http\Controllers\LifeTrackController@store');
Route::get('/lifetrack/test', 'App\Http\Controllers\LifeTrackController@index');