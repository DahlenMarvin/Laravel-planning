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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('employee', 'EmployeeController');
Route::resource('planning', 'PlanningController');

Route::get('updateHours', 'PlanningController@updateHours')->name('planning.updateHours');
Route::post('addEvent', 'PlanningController@addEvent')->name('planning.addEvent');

// Gestion des routes admin
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function (){
    Route::get('showFormChoosePlanning', 'AdminController@showFormChoosePlanning')->name('admin.showFormChoosePlanning');
    Route::post('planning', 'AdminController@planning')->name('admin.planning');
    Route::get('signature', 'SignatureController@index')->name('signature.index');
    Route::post('signature/store', 'SignatureController@store')->name('signature.store');
});

