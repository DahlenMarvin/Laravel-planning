<?php

namespace App\Repository;

use App\Employee;
use App\Planning;
use Carbon\Carbon;

class AppRepository
{

    public function __construct()
    {

    }

    public function dateStringToDateTime($dateString) {
        $explode = explode(' ',$dateString);
        if($explode[0] == "janvier") {
            $month = "01";
        } elseif ($explode[0] == "février") {
            $month = "02";
        } elseif ($explode[0] == "mars") {
            $month = "03";
        } elseif ($explode[0] == "avril") {
            $month = "04";
        } elseif ($explode[0] == "mai") {
            $month = "05";
        } elseif ($explode[0] == "juin") {
            $month = "06";
        } elseif ($explode[0] == "juillet") {
            $month = "07";
        } elseif ($explode[0] == "août") {
            $month = "08";
        } elseif ($explode[0] == "septembre") {
            $month = "09";
        } elseif ($explode[0] == "octobre") {
            $month = "10";
        } elseif ($explode[0] == "novembre") {
            $month = "11";
        } elseif ($explode[0] == "décembre") {
            $month = "12";
        } else {
            $month = "error";
        }

        $date = new Carbon($explode[1] . '-' . $month);
        return $date;
    }

    public function recupHoursEmployees($user_id, $start, $end) {
        $employees = Employee::where('user_id', '=', $user_id)->get();

        $total = 0;
        $arrayhoursPerEmployee = [];

        foreach ($employees as $employee) {
            $planningsEmployee = Planning::where('employee_id', '=', $employee->id)->where('date', '>=', $start)->where('date_end', '<=', $end)->get();
            foreach ($planningsEmployee as $planningEmployee) {
                $total = $total + Carbon::parse($planningEmployee->date_end)->diffInMinutes(Carbon::parse($planningEmployee->date));
            }
            array_push($arrayhoursPerEmployee, [
                $employee->name => $total / 60
            ]);
            $total = 0;
        }

        return $arrayhoursPerEmployee;
    }

}
