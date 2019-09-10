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
        return redirect('/dashboard');
    });
    Auth::routes();
    Route::resource('dashboard','DashboardController');
    Route::resource('visitas','VisitaController');
    Route::resource('localidades','LocalidadController');
    Route::resource('departamentos','DepartamentoController');
    Route::resource('comentarios','ComentarioController');
    Route::prefix('setting')->group(function () {
        Route::resource('localidad','SettingLocalidadController');
        Route::resource('departamento','SettingDepartamentoController');
    });  
    
});


// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/home', 'HomeController@index')->name('home');
Route::resource('demo','DemoController');