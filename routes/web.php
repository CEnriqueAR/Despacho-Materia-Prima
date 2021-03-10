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
Auth::routes();



Route::group(["middleware" => "auth"], function () {
    Route::get('/', function () {
        return view('index');
    });
//Despacho de Capa
    Route::group(['middleware' => 'capa'], function () {

        Route::get('/DesCapa', 'DesCapa@index')->name('DesCapa.index');
    });


    //Despacho de tripa y banda

    Route::group(['middleware' => 'banda'], function () {
        Route::get('/DesBanda', 'DesBanda@index')->name('DesBanda.index');

    });

});



