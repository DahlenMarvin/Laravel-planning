<?php

namespace App\Http\Controllers;

use App\Employee;
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

    public function store(Request $request) {
        //On encode/decode l'image
        $encoded_image = explode(",", $request->get('dataUri'))[1];
        $decoded_image = base64_decode($encoded_image);
        //On stock le fichier dans le système de fichier
        $filename = Str::random(32);
        Storage::disk('local')->put('signature/'.$filename.'.png', $decoded_image);
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
        dd($employee);
    }

}
