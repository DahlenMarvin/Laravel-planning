@extends('layouts/app')

@section('css')

    <style>

    </style>

@endsection

@section('content')
<<<<<<< HEAD
    <div class="container">
        <h2 style="text-align: center">Semaine n°{{$signature->nSemaine}} | Année {{$signature->nAnnee}} | Employé : {{ $employee->name . " " . $employee->lastname }}</h2>
=======

    <div class="container">

>>>>>>> master
        <table class="table table-bordered">
            <thead>
            <tr style="text-align: center">
                <th scope="col">Date début</th>
                <th scope="col">Date fin</th>
            </tr>
            </thead>
            <tbody>
            @foreach($plannings as $planning)
                <tr style="text-align: center">
                    <td>{{ \Carbon\Carbon::parse($planning->date)->format('d/m/Y H:i:s') }}</td>
                    <td>{{ \Carbon\Carbon::parse($planning->date_end)->format('d/m/Y H:i:s') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
<<<<<<< HEAD
        @if($signature->user_hasSigned != null && $signature->employee_hasSigned != null)
            <div class="form-group row">
                <div class="col-sm-12 text-center">
                    <b>Le commentaire de l'employé :</b>
                    <p>
                        {{$signature->comment}}
                    </p>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                <tr class="text-center">
                    <th scope="col">Signature coordinatrice</th>
                    <th scope="col">Signature de {{ $employee->name . " " . $employee->lastname }}</th>
                </tr>
                </thead>
                <tbody>
                <tr class="text-center">
                    <td> <img src="{{ url('storage/signature/' . $signature->user_hasSigned) }}" alt="SignatureCoordinatrice" width="300px"></td>
                    <td> <img src="{{ url("storage/signature/" . $signature->employee_hasSigned) }}" alt="SignatureEmployee" width="300px"></td>
                </tr>
                </tbody>
            </table>
        @else
            <p class="text-center">
                Cette semaine n'est pas encore validée pour le moment
            </p>
        @endif
    </div>
=======

        <div class="form-group row">
            <div class="col-sm-12">
                <b>Le commentaire de l'employé :</b>
                <p>
                    {{$signature->comment}}
                </p>
            </div>
        </div>

        <div class="col-lg-12">
            <img src="{{ url('storage/signature/'.$signature->user_hasSigned) }}" alt="SignatureCoordinatrice" width="300px">
            <img src="{{ asset("storage/signature/" . $signature->employee_hasSigned) }}" alt="SignatureEmployee" width="300px">
        </div>

    </div>

>>>>>>> master
@endsection

@section('js')

    <script>
        $(document).ready(function() {
            // SOMETHING
        })

    </script>

@endsection
