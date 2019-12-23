<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Planning;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function showFormChoosePlanning() {
        $magasins = User::where('type', '=', 'Magasin')->get();
        return view('admin.showFormChoosePlanning', compact('magasins'));
    }

    public function planning(Request $request) {

        $employees = Employee::where('user_id', '=', $request->get('user_id'))->get();
        $employeesIds = Employee::where('user_id', '=', $request->get('user_id'))->pluck('id')->toArray();
        $plannings = Planning::whereIn('employee_id', $employeesIds)->get();

        //On calcul le quota actuel du mois par vendeuse
        $start = new Carbon('first day of next month');
        $end = new Carbon('last day of next month');
        $total = 0;
        $arrayhoursPerEmployee = [];

        foreach ($employees as $employee) {
            $planningsEmployee = Planning::where('employee_id', '=', $employee->id)->where('date', '>=', $start)->where('date_end', '<=', $end)->get();
            foreach ($planningsEmployee as $planningEmployee) {
                $total = $total + Carbon::parse($planningEmployee->date_end)->diffInMinutes(Carbon::parse($planningEmployee->date));
            }
            array_push($arrayhoursPerEmployee, [
                $employee->name => $total
            ]);
            $total = 0;
        }



        return view('admin.index', compact('employees', 'plannings', 'arrayhoursPerEmployee'));

    }

}
