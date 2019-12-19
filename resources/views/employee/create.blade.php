@extends('layouts/app')

@section('content')

    <div class="container">

        <form action="{{ route('employee.store') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Nom</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nom">
                </div>
            </div>
            <div class="form-group row">
                <label for="lastname" class="col-sm-2 col-form-label">Prenom</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Prenom">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus-square"></i> Ajouter</button>
                </div>
            </div>
        </form>

    </div>


@endsection
