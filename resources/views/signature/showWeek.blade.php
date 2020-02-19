@extends('layouts/app')

@section('css')

    <style>

    </style>

@endsection

@section('content')

    <div class="container">
<<<<<<< HEAD
        <form method="post" action="{{route('signature.showWeekValidate')}}">
            {{ csrf_field() }}
            <div class="form-group row">
                <label for="employee" class="col-sm-2 col-form-label">Choix de l'employé</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="employee" id="employee" placeholder="Vous devez saisir le nom de votre employé dans ce champs">
                </div>
            </div>
            <div class="form-group row tableUsername" style="display: none">
                <div class="col-sm-12">
                    <table id="username" class="table table-bordered">

                    </table>
                </div>
            </div>
            <div class="form-group row">
                <label for="employee_id" class="col-sm-2 col-form-label">Employé sélectionné</label>
                <div class="col-sm-10">
                    <select name="employee_id" id="employee_id" class="form-control">
                        <option value="">En attente de la selection d'un employé</option>
=======

        <form method="post" action="{{route('signature.showWeekValidate')}}">
            {{ csrf_field() }}
            <div class="form-group row">
                <label for="employee_id" class="col-sm-2 col-form-label">Choix de l'employé</label>
                <div class="col-sm-10">
                    <select name="employee_id" id="employee_id" class="form-control">
                        @foreach($employees as $employee)
                            <option value="{{$employee->id}}">{{ $employee->name . " " . $employee->lastname }}</option>
                        @endforeach
>>>>>>> master
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="nSemaine" class="col-sm-2 col-form-label">Numéro de la semaine</label>
                <div class="col-sm-10">
<<<<<<< HEAD
                    <input type="text" class="form-control" name="nSemaine" id="nSemaine" placeholder="2" required>
=======
                    <input type="text" class="form-control" name="nSemaine" id="nSemaine" placeholder="2">
>>>>>>> master
                </div>
            </div>
            <div class="form-group row">
                <label for="nAnnee" class="col-sm-2 col-form-label">Année</label>
                <div class="col-sm-10">
<<<<<<< HEAD
                    <input type="text" class="form-control" name="nAnnee" id="nAnnee" placeholder="2020" required>
=======
                    <input type="text" class="form-control" name="nAnnee" id="nAnnee" placeholder="2020">
>>>>>>> master
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
<<<<<<< HEAD

            $('.setUsername').click(function() {
               alert($(this).val());
            });

            $( "#employee" ).on("input",function() {
                //Test en ajax
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    method: 'POST',
                    url: '{{ route('signature.updateName') }}',
                    data: {
                        name: $(this).val()
                    },
                    dataType: 'html',
                })
                .done(function(data) {
                    console.log(data);
                    $('#username').html(data);
                    $('.tableUsername').show();
                })
                .fail(function(data) {
                    alert(data);
                });
            });

        })
=======
            // SOMETHING
        })

>>>>>>> master
    </script>

@endsection
