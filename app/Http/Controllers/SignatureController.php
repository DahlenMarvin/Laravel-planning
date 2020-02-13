<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Planning;
use App\Signature;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SignatureController extends Controller
{
    public function index() {
        return view('signature.index');
    }

    public function store(Request $request, $isAdmin = null) {
        if($isAdmin == 1) {
            //On encode/decode l'image
            $encoded_image = explode(",", $request->get('dataUri'))[1];
            $decoded_image = base64_decode($encoded_image);
            //On stock le fichier dans le système de fichier
            $filename = Str::random(32) . ".png";
            while(Storage::disk('public')->exists('signature/'.$filename)) {
                $filename = Str::random(32) . ".png";
            }
            Storage::disk('public')->put('signature/'.$filename, $decoded_image);
            //On lie la signature avec la BDD
            $signature = Signature::where('employee_id', $request->get('employee_id'))->where('nSemaine', $request->get('nSemaine'))->where('nAnnee', $request->get('nAnnee'))->first();
            $signature->user_hasSigned = $filename;
            $signature->etat = "Valider";
            $signature->save();
        } else {
            //On encode/decode l'image
            $encoded_image = explode(",", $request->get('dataUri'))[1];
            $decoded_image = base64_decode($encoded_image);
            //On stock le fichier dans le système de fichier
            $filename = Str::random(32) . ".png";
            while(Storage::disk('public')->exists('signature/'.$filename)) {
                $filename = Str::random(32) . ".png";
            }
            Storage::disk('public')->put('signature/'.$filename, $decoded_image);
            //On lie la signature avec la BDD
            $signature = Signature::where('employee_id', $request->get('employee_id'))->where('nSemaine', $request->get('nSemaine'))->where('nAnnee', $request->get('nAnnee'))->first();
            $signature->comment = $request->get('comment');
            $signature->employee_hasSigned = $filename;
            $signature->etat = "Signé par l'employé";
            $signature->save();
        }
    }

    public function check(Request $request) {
        // On récupère l'employé qui a ce mot de passe
        $employees = Employee::all();
        foreach ($employees as $employee) {
            if(Hash::check($request->get('password'), $employee->password)){
                return Redirect::route("signature.tableProgress", ['employee_id' => $employee->id])->withSuccess("Connexion établie !");
            } else {
                // On ne redirige pas
            }
        }
        return Redirect::to("/signature")->withFail("Mot de passe incorrect !");
    }

    public function tableProgress($employee_id) {
        $employee = Employee::find($employee_id);
        $signatures = Signature::where('employee_id', $employee_id)->where('employee_hasSigned', null)->get();
        //$signaturesDone = Signature::where('employee_id', $employee_id)->where('employee_hasSigned','!=',null)->get();
        return view('signature.tableProgress', compact('signatures', 'employee'));
    }

    public function validateWeek($employee_id, $nSemaine, $nAnnee) {
        $employee = Employee::find($employee_id);
        $startOfWeek = Carbon::now();
        $endOfWeek = Carbon::now();
        $startOfWeek->setISODate($nAnnee,$nSemaine);
        $endOfWeek->setISODate($nAnnee,$nSemaine);
        $startOfWeek = $startOfWeek->startOfWeek();
        $endOfWeek = $endOfWeek->endOfWeek();

        //On récupère les events de l'employée sur la semaine données en params
        $plannings = Planning::where('employee_id', $employee_id)->where('date', '>=', $startOfWeek)->where('date_end', '<=', $endOfWeek)->get();
        return view('signature.validateWeek', compact('plannings', 'employee', 'nSemaine', 'nAnnee'));
    }

    public function validateWeekForAdmin($employee_id, $nSemaine, $nAnnee) {
        $employee = Employee::find($employee_id);
        $startOfWeek = Carbon::now();
        $endOfWeek = Carbon::now();
        $startOfWeek->setISODate($nAnnee,$nSemaine);
        $endOfWeek->setISODate($nAnnee,$nSemaine);
        $startOfWeek = $startOfWeek->startOfWeek();
        $endOfWeek = $endOfWeek->endOfWeek();
        $signature = Signature::where('employee_id', $employee_id)->where('nSemaine', $nSemaine)->where('nAnnee', $nAnnee)->first();
        //On récupère les events de l'employée sur la semaine données en params
        $plannings = Planning::where('employee_id', $employee_id)->where('date', '>=', $startOfWeek)->where('date_end', '<=', $endOfWeek)->get();
        return view('signature.validateWeekForAdmin', compact('plannings', 'employee', 'nSemaine', 'nAnnee', 'signature'));
    }

    public function validatePlanning() {
        //$signatures = Signature::where('user_id', Auth::user()->id)->where('employee_hasSigned','!=',null)->get();
        $signatures = Signature::where('user_id', 24)->where('employee_hasSigned','!=',null)->where('etat','!=',"Valider")->get();
        return view('signature.validatePlanning', compact('signatures'));
    }

    public function showWeek() {
        $employees = Employee::all();
        return view('signature.showWeek', compact('employees'));
    }

    public function showWeekValidate(Request $request) {
        $employee = Employee::find($request->get('employee_id'));
        $startOfWeek = Carbon::now();
        $endOfWeek = Carbon::now();
        $startOfWeek->setISODate($request->get('nAnnee'),$request->get('nSemaine'));
        $endOfWeek->setISODate($request->get('nAnnee'),$request->get('nSemaine'));
        $startOfWeek = $startOfWeek->startOfWeek();
        $endOfWeek = $endOfWeek->endOfWeek();

        //On récupère les events de l'employée sur la semaine données en params
        $plannings = Planning::where('employee_id', $employee->id)->where('date', '>=', $startOfWeek)->where('date_end', '<=', $endOfWeek)->get();
        $signature = Signature::where('employee_id', $employee->id)->where('nSemaine', $request->get('nSemaine'))->where('nAnnee', $request->get('nAnnee'))->first();

        if($plannings->count() == 0 || $signature->count() == 0) {
            return Redirect::route("signature.showWeek")->withFail("Pas encore de planning pour cette période !");
        }
        return view('signature.showWeekValidate', compact('plannings', 'signature', 'employee'));
    }

    public function updateName(Request $request) {
        $employees = Employee::where('name', 'LIKE', '%' . $request->name . '%')->orWhere('lastname', 'LIKE', '%' . $request->name . '%')->take(5)->get();
        $return = '<tr>';
        $return .= '<td><b>Nom / Prénom</b></td>';
        $return .= '</tr>';
        foreach ($employees as $employee) {
            $return .= '<tr>';
            $return .= "<td style=\"cursor: pointer\" onclick=\"const str = this.innerText; let res = str.split(' '); document.getElementById('employee_id').innerHTML = '<option value=\'' + res[2] + '\'>' + res[0] + ' ' + res[1] + '</option>'; $('.tableUsername').hide();\">" . $employee->name . " " . $employee->lastname . " " . $employee->id . "</td>";
            $return .= '</tr>';
        }
        return $return;
    }

}
