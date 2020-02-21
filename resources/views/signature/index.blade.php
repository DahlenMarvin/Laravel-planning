@extends('layouts/app')

@section('css')

    <style>

    </style>

@endsection

@section('content')

    <div class="container">

        <form method="post" action="{{route('signature.check')}}">
            {{ csrf_field() }}
            <div class="form-group row">
                <label for="password" class="col-sm-2 col-form-label">Votre mot de passe</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="password" id="password" placeholder="Password">
                </div>
            </div>
            <div class="form-group text-center">
                <input type="submit" class="btn btn-success" value="Connexion">
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
