@extends('layouts/app')

@section('content')

    <div class="container">

        <form action="{{ route('planning.update', $planning) }}" method="post">
            {{ csrf_field() }}
            @method('PATCH')
            <div class="form-group row">
                <label for="employe" class="col-sm-2 col-form-label">Employé</label>
                <div class="col-sm-10">
                    <select class="form-control" id="employe" name="employee_id">
                        @foreach($employees as $employe)
                            <option value="{{ $employe->id }}" @if($planning->employee_id == $employe->id) selected="selected" @endif>{{ $employe->name . ' ' . $employe->lastname }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="date" class="col-sm-2 col-form-label">Date début</label>
                <div class="col-sm-10">
                    <input type="datetime-local" class="date form-control" id="date" name="date" value="{{ $planning->date }}">
                </div>
            </div>
            <div class="form-group row">
                <label for="date_end" class="col-sm-2 col-form-label">Date fin</label>
                <div class="col-sm-10">
                    <input type="datetime-local" class="date form-control" id="date_end" name="date_end" value="{{ $planning->date_end }}">
                </div>
            </div>
            <div class="form-group row">
                <button type="submit" class="btn btn-success">Mettre à jour</button>
            </div>
        </form>
        <form action="{{ route('planning.destroy', $planning)}}" method="post">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" type="submit"><i class="fas fa-times-circle"> Supprimer</i> </button>
        </form>
    </div>

@endsection

@section('js')
    <script>


    </script>

@endsection
