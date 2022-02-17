@extends('layouts/app')

@section('content')

    <div class="container">

        <form action="{{ route('admin.planning') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group row">
                <label for="magasin" class="col-sm-2 col-form-label">Magasin</label>
                <div class="col-sm-10">
                    <select class="form-control" id="magasin" name="user_id">
                        @foreach($magasins as $magasin)
                            <option value="{{ $magasin->id }}">{{ $magasin->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Rechercher</button>
                </div>
            </div>
        </form>

    </div>


@endsection
