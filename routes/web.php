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


Route::get('updateHours', 'PlanningController@updateHours')->name('planning.updateHours');
Route::post('addEvent', 'PlanningController@addEvent')->name('planning.addEvent');
Route::get('planning/duplicate/{weekNumber}/{year}/{idPlanning}/{weekToDuplicate}', 'PlanningController@duplicate')->name('planning.duplicate');

Route::get('signature', 'SignatureController@index')->name('signature.index');
Route::post('signature/store', 'SignatureController@store')->name('signature.store');
Route::post('signature/check', 'SignatureController@check')->name('signature.check');
Route::get('signature/tableProgress/{employee_id}', 'SignatureController@tableProgress')->name('signature.tableProgress');


// Gestion des routes admin
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function (){
    Route::get('showFormChoosePlanning', 'AdminController@showFormChoosePlanning')->name('admin.showFormChoosePlanning');
    Route::post('planning', 'AdminController@planning')->name('admin.planning');
});

Route::group(['middleware' => 'auth'], function (){
    Route::resource('employee', 'EmployeeController');
    Route::get('employee/updatePassword/{employee}', 'EmployeeController@updatePassword')->name('employee.updatePassword');
    Route::resource('planning', 'PlanningController');
});

