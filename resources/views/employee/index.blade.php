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
                <col width="15%">
                <col width="15%">
                <col width="15%">
                <col width="55%">
                <thead>
                <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">État</th>
                    <th scope="col"> </th>
                </tr>
                </thead>
                <tbody>
                    @foreach($employees as $employee)
                        <tr>
                            <th>{{$employee->name}}</th>
                            <td>{{$employee->lastname}}</td>
                            <td>{{ $employee->state == 0 ? 'Inactif' : 'Actif'  }}</td>
                            <td>
                                <a class="btn btn-success" href="{{ route('employee.profil', $employee) }}"><i class="fas fa-user-cog"> Profil</i> </a>
                                @if($employee->state == 0)
                                    <a class="btn btn-primary" href="{{ route('employee.activate', $employee) }}"><i class="fab fa-vuejs"> Activer</i> </a>
                                @else
                                    <a class="btn btn-primary" href="{{ route('employee.desactivate', $employee) }}"><i class="fas fa-times-circle"> Désactiver</i> </a>
                                @endif
                                <a class="btn btn-warning" href="{{ route('employee.updatePassword', $employee) }}"><i class="fas fa-redo-alt"> Générer nouveau mot de passe</i> </a>
                                <!--<a class="btn btn-success" href="{ { route('employee.profil', $employee) }}" style="margin-left: 10px"><i class="fas fa-user"> Profil</i> </a>-->
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
