<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

}
