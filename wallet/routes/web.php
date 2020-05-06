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

Route::get('/', 'WalletsController@index')->name('index');

//metodo desde la vista html
Route::post('/generarllave', 'WalletsController@generarllave');
//metodo de llamada public desde url
Route::get('generarllaveWeb/{palabras}/{email}/{plata}', [
    'as' => 'generarllaveWeb', 'uses' => 'WalletsController@generarllaveWeb']);

Route::post('/moverplata', 'WalletsController@moverplata');
Route::post('/verificar', 'WalletsController@verificar');
