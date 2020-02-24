@extends('layouts/app')

@section('css')

    <style>

    </style>

@endsection

@section('content')
    <div class="container">
        <h2 style="text-align: center">Semaine n°{{$signature->nSemaine}} | Année {{$signature->nAnnee}} | Employé : {{ $employee->name . " " . $employee->lastname }}</h2>
    <div class="container">
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
        <div class="form-group row">
            <div class="col-sm-12 text-center">
                <table class="table table-bordered">
                    <col width="50%">
                    <col width="50%">
                    <thead>
                    <tr>
                        <th>Le jour</th>
                        <th>Les jours</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $total=0 ?>
                    @foreach($array as $jour => $nbHeure)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($jour)->format('l j F Y') }}</td>
                            <td>{{$nbHeure/60}}H</td>
                            @php
                              $total=$total+($nbHeure/60)
                            @endphp
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="2">TOTAL SEMAINE : <b>{{ $total }}</b></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @if($signature->user_hasSigned != null && $signature->employee_hasSigned != null)
            <div class="form-group row">
                <div class="col-sm-12 text-center">
                    <b>Le commentaire de l'employé :</b>
                    <p>
                        {{$signature->comment != null ? $signature->comment : "Pas de commentaire"}}
                    </p>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12 text-center">
                    <b>Le commentaire de la coordinatrice :</b>
                    <p>
                        {{$signature->comment_admin != null ? $signature->comment_admin : "Pas de commentaire"}}
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
@endsection

@section('js')

    <script>
        $(document).ready(function() {
            // SOMETHING
        })

    </script>

@endsection
