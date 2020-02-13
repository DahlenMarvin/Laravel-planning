@extends('layouts/app')

@section('css')

    <style>

    </style>

@endsection

@section('content')

    <div class="container">

        <form method="post" action="{{route('signature.showWeekValidate')}}">
            {{ csrf_field() }}
            <div class="form-group row">
                <label for="employee_id" class="col-sm-2 col-form-label">Choix de l'employé</label>
                <div class="col-sm-10">
                    <select name="employee_id" id="employee_id" class="form-control">
                        @foreach($employees as $employee)
                            <option value="{{$employee->id}}">{{ $employee->name . " " . $employee->lastname }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="nSemaine" class="col-sm-2 col-form-label">Numéro de la semaine</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nSemaine" id="nSemaine" placeholder="2">
                </div>
            </div>
            <div class="form-group row">
                <label for="nAnnee" class="col-sm-2 col-form-label">Année</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nAnnee" id="nAnnee" placeholder="2020">
                </div>
            </div>
            <div class="form-group text-center">
                <input type="submit" class="btn btn-success" value="Valider">
            </div>
        </form>

    </div>

@endsection

@section('js')

    <script>
        $(document).ready(function() {
            // SOMETHING
        })

    </script>

@endsection
