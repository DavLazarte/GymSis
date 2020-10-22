<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('layouts/admin');
});
Route::resource('socio/nuevo','SocioController');
Route::resource('membresia/nueva','MembresiaController');
Route::resource('administracion/ingreso','IngresoController');
Route::resource('administracion/salida','SalidaController');
Route::resource('abono/nuevo','AbonoController');