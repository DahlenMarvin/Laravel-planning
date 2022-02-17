<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Employee;
use App\Mail\PasswordGenerated;
use App\Mail\SendRequest;
use App\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
        if(Auth::user()->type == 'Admin') {
            $employees = Employee::all();

        } else {
            $employees = Employee::where('user_id', '=', Auth::user()->id)->get();
        }
        return view('employee.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        $magasins = User::where('type', 'Magasin')->get();
        return view('employee.create', compact('magasins'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        if(strstr($request->get('name'), ' ')) {
            if(strstr($request->get('lastname'), ' ')) {
                return Redirect::to("/employee")->withFail("Le nom / prénom contiennent un espace");
            } else {
                $password = ucfirst($request->get('lastname')) . $request->get('birthday');
            }
        } else {
            $password = ucfirst($request->get('name')) . $request->get('birthday');
        }

        try {

            $employe = new Employee();
            $employe->name = $request->get('name');
            $employe->lastname = $request->get('lastname');
            $employe->password = Hash::make($password);
            $employe->user()->associate($request->get('magasin'));
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
        $employee = Employee::find($id);
        $employee->name = $request->get('name');
        $employee->lastname = $request->get('lastname');
        $employee->color = $request->get('color');
        $employee->save();

        return Redirect::to("/employee")->withSuccess("Information mise à jour avec succès !");

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
        $activities = Activity::where('employee_id', $employee->id)->take(10)->orderByDesc('created_at')->get();
        return view('employee.profil', compact('employee', 'activities'));
    }

    /**
     * Desactivate Employee
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function desactivate($id)
    {
        $employee = Employee::find($id);
        $employee->state = 0;
        $employee->save();

        return Redirect::to("/employee")->withSuccess('Employé désactivé avec succès');
    }

    /**
     * Activate Employee
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function activate($id)
    {
        $employee = Employee::find($id);
        $employee->state = 1;
        $employee->save();

        return Redirect::to("/employee")->withSuccess('Employé activé avec succès');
    }

    /**
     * un employé demande un congé ou une récup
     *
     * @param Employee $employee
     * @return Application|Factory|RedirectResponse|View
     */
    public function ask(Employee $employee)
    {
        return view('employee.ask', compact('employee'));
    }

    /**
     * On ajoute en base de données la demande de congé / récup
     *
     * @param Request $request
     * @param Employee $employee
     * @return void
     */
    public function storeAsk(Request $request, Employee $employee)
    {
        Mail::to('c.lecanu@ledlc.fr')->send(new SendRequest($employee, $request->get('typeDemande'), $request->get('poste'), $request->get('nSemaine'), $request->get('comment')));
        return Redirect::to("/employee")->withSuccess('Demande envoyée avec succès à Charline');
    }

}
