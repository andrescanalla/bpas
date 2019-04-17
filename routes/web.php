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
Route::group(['middleware'=>'auth'], function(){
    Route::get('/', function () {
        return view('dashboard.index');
    });
    Route::resource('dashboard','DashboardController');
    Route::resource('visitas','VisitaController');
    Route::resource('localidades','LocalidadController');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');