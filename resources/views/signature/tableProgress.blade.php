@extends('layouts/app')

@section('css')

    <style>
        .info {
            text-align: center;
            margin-bottom: 20px;
            font-size: 20px;
        }
    </style>

@endsection

@section('content')

    <div class="container">

        @if($signatures->count() > 0)
            <div class="info">
                Bienvenue {{ $employee->name . " " . $employee->lastname }} <br>
                Vous avez {{ $signatures->count() > 0 ? $signatures->count() . " semaines" : $signatures->count() . " semaine"}} en attente de votre signature
            </div>

            <table class="table table-bordered">
                <thead>
                <tr style="text-align: center">
                    <th scope="col">Numéro semaine</th>
                    <th scope="col">Votre coordinatrice</th>
                    <th scope="col">Signature coordinatrice</th>
                    <th scope="col">Votre signature</th>
                    <th scope="col">Etat</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($signatures as $signature)
                    <tr style="text-align: center; vertical-align: middle">
                        <td>{{$signature->nSemaine}}</td>
                        <td>{{$signature->user->name}}</td>
                        <td>{{ $signature->user_hasSigned == null ? "Pas de signature" : "Signature effectuée" }}</td>
                        <td>{{ $signature->employee_hasSigned == null ? "Pas de signature" : "Signature effectuée" }}</td>
                        <td>{{$signature->etat}}</td>
                        <td><a class="btn btn-warning" href="{{ route('signature.validateWeek', ['employee_id' => $signature->employee_id, 'nSemaine' => $signature->nSemaine, 'nAnnee' => $signature->nAnnee]) }}"><i class="fas fa-file-signature"> Valider cette semaine</i> </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="info">
                Pas de demande de signature pour le moment
            </div>
        @endif
    </div>

@endsection

@section('js')

    <script>
        $(document).ready(function() {
            // SOMETHING
        })

    </script>

@endsection
