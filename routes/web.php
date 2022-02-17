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
Route::get('planning/getHoursEmployees', 'PlanningController@getHoursEmployees')->name('planning.getHoursEmployees');

Route::get('signature', 'SignatureController@index')->name('signature.index');
Route::post('signature/store/{isAdmin}', 'SignatureController@store')->name('signature.store');
Route::post('signature/check', 'SignatureController@check')->name('signature.check');
Route::get('signature/tableProgress/{employee_id}', 'SignatureController@tableProgress')->name('signature.tableProgress');
Route::get('signature/validateWeek/{employee_id}/{nSemaine}/{nAnnee}', 'SignatureController@validateWeek')->name('signature.validateWeek');
Route::get('signature/validateWeekForAdmin/{employee_id}/{nSemaine}/{nAnnee}', 'SignatureController@validateWeekForAdmin')->name('signature.validateWeekForAdmin');
Route::get('signature/validatePlanning', 'SignatureController@validatePlanning')->name('signature.validatePlanning');
Route::post('signature/showWeekValidate', 'SignatureController@showWeekValidate')->name('signature.showWeekValidate');
Route::get('signature/showWeek', 'SignatureController@showWeek')->name('signature.showWeek');
Route::get('signature/formForMass', 'SignatureController@formForMass')->name('signature.formForMass');
Route::post('signature/exportMass', 'SignatureController@exportMass')->name('signature.exportMass');
Route::post('signature/updateName', 'SignatureController@updateName')->name('signature.updateName');

Route::get('employee/profil/{employee}', 'EmployeeController@profil')->name('employee.profil');
Route::get('employee/desactivate/{employee}', 'EmployeeController@desactivate')->name('employee.desactivate');
Route::get('employee/activate/{employee}', 'EmployeeController@activate')->name('employee.activate');
Route::get('employee/ask/{employee}', 'EmployeeController@ask')->name('employee.ask');
Route::post('employee/ask/{employee}', 'EmployeeController@storeAsk')->name('employee.storeAsk');

// Gestion des routes admin
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function (){
    Route::get('showFormChoosePlanning', 'AdminController@showFormChoosePlanning')->name('admin.showFormChoosePlanning');
    Route::post('planning', 'AdminController@planning')->name('admin.planning');
});

Route::group(['middleware' => 'auth'], function (){
    Route::resource('employee', 'EmployeeController');
    Route::get('employee/updatePassword/{employee}', 'EmployeeController@updatePassword')->name('employee.updatePassword');
    Route::resource('planning', 'PlanningController');
    Route::post('planning/addCP', 'PlanningController@addCP')->name('planning.addCP');
    Route::post('planning/addRecup', 'PlanningController@addRecup')->name('planning.addRecup');
});

