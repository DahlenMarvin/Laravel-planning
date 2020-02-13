@extends('layouts/app')

@section('css')

    <style>

    </style>

@endsection

@section('content')

    <div class="container">

        <table class="table table-bordered">
            <thead>
            <tr style="text-align: center">
                <th scope="col">Numéro semaine</th>
                <th scope="col">Nom employé</th>
                <th scope="col">Signature coordinatrice</th>
                <th scope="col">Etat</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($signatures as $signature)
                <tr style="text-align: center; vertical-align: middle">
                    <td>{{ $signature->nSemaine }}</td>
                    <td>{{ $signature->employee->name . " " . $signature->employee->lastname}}</td>
                    <td>{{ $signature->user_hasSigned == null ? "Pas de signature" : "Signature effectuée" }}</td>
                    <td>{{ $signature->etat}}</td>
                    <td><a class="btn btn-warning" href="{{ route('signature.validateWeekForAdmin', ['employee_id' => $signature->employee_id, 'nSemaine' => $signature->nSemaine, 'nAnnee' => $signature->nAnnee]) }}"><i class="fas fa-file-signature"> Valider cette semaine</i> </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>

@endsection

@section('js')

    <script>
        $(document).ready(function() {
            // SOMETHING
        })

    </script>

@endsection
