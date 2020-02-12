@extends('layouts/app')

@section('content')

    <div class="container">

        <div id="employeAdd">
            <a href="{{route('employee.create')}}" class="btn btn-success"><i class="fas fa-plus-square"></i> Ajouter un employé</a>
        </div>
        <br>
        <div id="showTableEmployees">
            @if(!empty($employees))
            <table class="table table-dark">
                <col width="30%">
                <col width="30%">
                <col width="40%">
                <thead>
                <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($employees as $employee)
                        <tr>
                            <th>{{$employee->name}}</th>
                            <td>{{$employee->lastname}}</td>
                            <td>
                                <form action="{{ route('employee.destroy', $employee)}}" method="post" style="float: left">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit"><i class="fas fa-times-circle"> Supprimer</i> </button>
                                </form>
                                <a class="btn btn-warning" href="{{ route('employee.updatePassword', $employee) }}" style="margin-left: 10px"><i class="fas fa-redo-alt"> Générer nouveau mot de passe</i> </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @else
                <p>Vous n'avez pas d'employés sur ce magasin pour le moment</p>
            @endif
        </div>

    </div>


@endsection
