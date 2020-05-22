@extends('layouts/app')

@section('content')

    <div class="container">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <!-- Row -->
        <div class="row">
            <!-- Column -->
            <div class="col-lg-4 col-xlg-3 col-md-5">
                <div class="card">
                    <div class="card-body">
                        <div style="text-align: center;">
                            <h4 class="card-title mt-2">{{ $employee->name . ' ' . $employee->lastname }}</h4>
                            <h6 class="card-subtitle">{{ $employee->user->name }}</h6> <br>
                            <h6 class="card-subtitle">{{ $employee->user->email }}</h6>
                        </div>
                    </div>
                    <div>
                        <hr>
                    </div>
                    <div class="card-body">
                        <small class="text-muted">Type de contrat </small>
                        <h6>En cours de développement</h6>
                        <small class="text-muted">État des heures </small>
                        <h6>En cours de développement</h6>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-lg-8 col-xlg-9 col-md-7">
                <div class="card">
                    <!-- Tabs -->
                    <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#last-month"
                               role="tab" aria-controls="pills-profile" aria-selected="true">Historiques</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-setting-tab" data-toggle="pill" href="#previous-month"
                               role="tab" aria-controls="pills-setting" aria-selected="false">Paramètres</a>
                        </li>
                    </ul>
                    <!-- Tabs -->
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="last-month" role="tabpanel"
                             aria-labelledby="pills-profile-tab">
                            <div class="card-body">
                                <div class="profiletimeline mt-2">
                                    @foreach($activities as $activity)
                                        <div class="sl-item">
                                            <div class="sl-left"> </div>
                                            <div class="sl-right">
                                                <div><span class="sl-date">{{ $activity->created_at }}</span>
                                                    <p>
                                                        {{ $activity->comment }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="previous-month" role="tabpanel"
                             aria-labelledby="pills-setting-tab">
                            <div class="card-body">
                                <form class="form-horizontal form-material">
                                    <div class="form-group">
                                        @if($employee->state == 0)
                                            <p class="text-muted">Actuellement cet employé est inactif dans le magasin, si cette personne retravaille dans votre magasin vous pouvez l'activer en cliquant sur le bouton ci-dessous.</p>
                                            <a class="btn btn-primary" href="{{ route('employee.activate', $employee) }}"><i class="fab fa-vuejs"> Activer</i> </a>
                                        @else
                                            <p class="text-muted">Actuellement cet employé est actif dans le magasin, si cette personne ne travaille plus dans votre magasin vous pouvez la désactiver en cliquant sur le bouton ci-dessous.</p>
                                            <a class="btn btn-primary" href="{{ route('employee.desactivate', $employee) }}"><i class="fas fa-times"> Désactiver</i> </a>
                                        @endif
                                    </div>
                                    <!--
                                    <div class="form-group">
                                        <p class="text-muted">Si { { $employee->name . ' ' . $employee->lastname }} ne se souvient plus de son mot de passe, vous pouvez en générer un nouveau en cliquant sur le lien ci-dessous.</p>
                                        <a class="btn btn-warning" href="{ { route('employee.updatePassword', $employee) }}"><i class="fas fa-redo-alt"> Générer nouveau mot de passe</i> </a>
                                    </div>
                                    -->
                                </form>
                                <form action="{{ route('employee.update', $employee->id) }}" method="post">
                                    @method('PUT')
                                    @csrf
                                    <fieldset>Mettre à jour ses informations</fieldset>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="name">Nom</label>
                                        <div class="col-sm-10">
                                            <input type="text" value="{{$employee->name}}" class="form-control form-control-line" id="name" name="name">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="lastname">Prénom</label>
                                        <div class="col-sm-10">
                                            <input type="text" value="{{$employee->lastname}}" class="form-control form-control-line" id="lastname" name="lastname">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="color">Couleur</label>
                                        <div class="col-sm-10">
                                            <input type="color" value="{{$employee->color}}" class="form-control form-control-line" id="color" name="color">
                                        </div>
                                    </div>
                                    <div class="form-group text-center">
                                        <div class="col-sm-10">
                                            <button class="btn btn-success">Mettre à jour</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
        </div>
        <!-- Row -->
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right sidebar -->
        <!-- ============================================================== -->
        <!-- .right-sidebar -->
        <!-- ============================================================== -->
        <!-- End Right sidebar -->
        <!-- ============================================================== -->
    </div>


@endsection
