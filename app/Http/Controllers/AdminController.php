<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Planning;
use App\Repository\AppRepository;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public $repository;

    public function __construct()
    {
        $this->repository = new AppRepository();
    }

    public function showFormChoosePlanning() {
        $magasins = User::where('type', '=', 'Magasin')->get();
        return view('admin.showFormChoosePlanning', compact('magasins'));
    }

    public function planning(Request $request) {

        $employees = Employee::where('user_id', '=', $request->get('user_id'))->get();
        $employeesIds = Employee::where('user_id', '=', $request->get('user_id'))->pluck('id')->toArray();
        $plannings = Planning::whereIn('employee_id', $employeesIds)->get();

        //On calcul le quota actuel du mois par vendeuse
        $start = new Carbon('first day of this month');
        $end = new Carbon('last day of this month');

        $arrayhoursPerEmployee = $this->repository->recupHoursEmployees($request->get('user_id'), $start, $end);

        return view('planning.index', compact('employees', 'plannings', 'arrayhoursPerEmployee'));

    }

}
