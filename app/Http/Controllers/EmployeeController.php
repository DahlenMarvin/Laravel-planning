<?php

namespace App\Http\Controllers;

use App\Employee;
use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Psy\Command\Command;

class EmployeeController extends Controller
{
    /**
     * Show all the employees
     *
     * @return Factory|View
     */
    public function index()
    {
        $employees = Employee::where('user_id', '=', Auth::user()->id)->get();;
        return view('employee.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('employee.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        try {

            $employe = new Employee();
            $employe->name = $request->get('name');
            $employe->lastname = $request->get('lastname');
            $employe->user()->associate(Auth::user());
            $employe->save();

            return Redirect::to("/employee")->withSuccess('Employé créé');
        } catch (\Exception $e) {
            return Redirect::to("/employee")->withErrors('Employé non créé');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
       $employee = Employee::find($id);
       $employee->delete();

        return Redirect::to("/employee")->withSuccess('Employé supprimé');
    }

    /**
     * @param Employee $employee
     * @return RedirectResponse
     */
    public function updatePassword($employee) {
        $employee = Employee::find($employee);
        Artisan::call('employee:password', ['employee_id' => $employee->id]);
        return Redirect::to("/employee")->withSuccess("Mot de passe généré avec succés !");
    }

    /**
     * @param Employee $employee
     * @return Factory|View
     */
    public function profil($employee) {
        $employee = Employee::find($employee);
        return view('employee.profil', compact('employee'));
    }
}
