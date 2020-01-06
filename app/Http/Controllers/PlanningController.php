<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Planning;
use App\Repository\AppRepository;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PlanningController extends Controller
{

    public $repository;

    public function __construct()
    {
        $this->repository = new AppRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     * @throws \Exception
     */
    public function index()
    {
        $employees = Employee::where('user_id', '=', Auth::user()->id)->get();
        $employeesIds = Employee::where('user_id', '=', Auth::user()->id)->pluck('id')->toArray();
        $plannings = Planning::whereIn('employee_id', $employeesIds)->get();

        //On calcul le quota actuel du mois par vendeuse
        $start = new Carbon('first day of this month');
        $end = new Carbon('last day of this month');

        $arrayhoursPerEmployee = $this->repository->recupHoursEmployees(Auth::user()->id, $start, $end->addDay());


        return view('planning.index', compact('employees', 'plannings', 'arrayhoursPerEmployee'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    public function store(Request $request)
    {
        $planning = new Planning();
        $planning->date = $request->get('date');
        $planning->date_end = $request->get('date_end');
        $planning->employee()->associate($request->get('employee_id'));
        $planning->save();
        return 0;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Factory|View
     */
    public function show($id)
    {
        $employees = Employee::all();
        $planning = Planning::find($id);
        return view('planning.show', compact('planning','employees'));
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
        $planning = Planning::find($id);
        $planning->date = $request->get('date');
        $planning->date_end = $request->get('date_end');
        $planning->employee()->associate($request->get('employee_id'));
        $planning->save();

        return Redirect::to("/planning")->withSuccess('Planning mis à jour');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $planning = Planning::find($id);
        $planning->delete();

        return Redirect::to("/planning")->withSuccess('Planning supprimé');
    }

    public function updateHours(Request $request) {

        $month = $request->get('month');
        $user_id = $request->get('user_id');

        $date = $this->repository->dateStringToDateTime($month);
        $start = $date->firstOfMonth()->format('Y-m-d H:i:s');
        $end = $date->endOfMonth()->addDay()->format('Y-m-d H:i:s');
        if(isset($user_id)) {
            $array = $this->repository->recupHoursEmployees($request->get('user_id'), $start, $end);
        } else {
            $array = $this->repository->recupHoursEmployees(Auth::user()->id, $start, $end);
        }

        $html = "<thead>";
        $html .= "<tr>";
        $html .= "<th colspan=\"2\">" . $date->format('m / Y') . "</th>";
        $html .= "</tr>";
        $html .= "<tr>";
        $html .= "<th scope=\"col\">Nom</th>";
        $html .= "<th scope=\"col\">Nb heure</th>";
        $html .= "</tr>";
        $html .= "</thead>";
        $html .= "<tbody id=\"nbHours\">";
        foreach ($array as $item) {
            foreach ($item as $k => $v) {
                $html .= "<tr>";
                $html .= "<th> " . $k . " </th>";
                $html .= "<td> " . $v . " heures </td>";
                $html .= "</tr>";
            }
        }
        $html .= "</tbody>";

        echo $html;
        return 0;
    }

    public function addEvent(Request $request) {
        $planning = new Planning();
        if($request->get('event') == "Matin") {
            $planning->date = $request->get('date') . "T08:30";
            $planning->date_end = $request->get('date') . "T12:30";
        } elseif ($request->get('event') == "Après-midi") {
            $planning->date = $request->get('date') . "T14:30";
            $planning->date_end = $request->get('date') . "T19:30";
        } else {
            $planning->date = $request->get('date') . "T08:30";
            $planning->date_end = $request->get('date') . "T19:30";
        }
        $planning->employee()->associate($request->get('employee_id'));
        $planning->save();
        return 0;
    }

}
