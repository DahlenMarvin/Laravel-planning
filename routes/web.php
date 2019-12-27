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


// Gestion des routes admin
Route::get('admin/showFormChoosePlanning', 'AdminController@showFormChoosePlanning')->name('admin.showFormChoosePlanning');
Route::post('admin/planning', 'AdminController@planning')->name('admin.planning');
Route::get('updateHours', 'PlanningController@updateHours')->name('planning.updateHours');
Route::post('addEvent', 'PlanningController@addEvent')->name('planning.addEvent');

