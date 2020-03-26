@extends('layouts/app')

@section('css')

    <style>

    </style>

@endsection

@section('content')

    <div class="container">
        <form method="post" action="{{route('signature.exportMass')}}">
            {{ csrf_field() }}
            <div class="form-group row">
                <label for="nSemaine" class="col-sm-2 col-form-label">Numéro de la semaine</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nSemaine" id="nSemaine" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="nAnnee" class="col-sm-2 col-form-label">Année</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nAnnee" id="nAnnee" required>
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

    </script>

@endsection
