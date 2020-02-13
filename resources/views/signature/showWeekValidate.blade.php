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

@endsection

@section('js')

    <script>
        $(document).ready(function() {
            // SOMETHING
        })

    </script>

@endsection
