@extends('layouts/app')

@section('content')
    <div class="container">
        <h2 style="text-align: center">Semaine n°{{$signature->nSemaine}} | Année {{$signature->nAnnee}} | Employé : {{ $employee->name . " " . $employee->lastname }}</h2>
        <table class="table table-bordered">
            <thead>
            <tr style="text-align: center">
                <th scope="col">Date début</th>
                <th scope="col">Date fin</th>
            </tr>
            </thead>
            <tbody>
            <?php $countDown = 0; ?>
            @foreach($plannings as $planning)

                @if($planning->isCP == 1 && $planning->isRecup == 0)
                    <tr style="text-align: center">
                        <td colspan="2">CP ==> {{ ucfirst(\Carbon\Carbon::parse($planning->date)->localeDayOfWeek) . ' ' . \Carbon\Carbon::parse($planning->date)->format('d/m/Y') }} ({{ (\Carbon\Carbon::parse($planning->date_end)->diffInMinutes(\Carbon\Carbon::parse($planning->date)))/60 }} H)</td>
                    </tr>
                    <?php
                    $fin = new \Carbon\Carbon($planning->date_end);
                    $diff = $fin->diffInMinutes($planning->date);
                    $countDown = $countDown + $diff;
                    ?>
                @elseif($planning->isCP == 0 && $planning->isRecup == 1)
                    <tr style="text-align: center">
                        <td colspan="2">Recup ==> {{ ucfirst(\Carbon\Carbon::parse($planning->date)->localeDayOfWeek) . ' ' . \Carbon\Carbon::parse($planning->date)->format('d/m/Y') }} ({{ (\Carbon\Carbon::parse($planning->date_end)->diffInMinutes(\Carbon\Carbon::parse($planning->date)))/60 }} H)</td>
                    </tr>
                    <?php
                    $fin = new \Carbon\Carbon($planning->date_end);
                    $diff = $fin->diffInMinutes($planning->date);
                    $countDown = $countDown + $diff;
                    ?>
                @else
                    <tr style="text-align: center">
                        <td>{{  ucfirst(\Carbon\Carbon::parse($planning->date)->localeDayOfWeek) . ' ' . \Carbon\Carbon::parse($planning->date)->format('d/m/Y H\hi\m') }}</td>
                        <td>{{  ucfirst(\Carbon\Carbon::parse($planning->date_end)->localeDayOfWeek) . ' ' . \Carbon\Carbon::parse($planning->date_end)->format('d/m/Y H\hi\m') }}</td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
        <div class="form-group row">
            <div class="col-sm-12 text-center">
                <table class="table table-bordered">
                    <col width="50%">
                    <col width="50%">
                    <thead>
                    <tr>
                        <th>Le jour</th>
                        <th>Les heures</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $total=0 ?>
                    @foreach($array as $jour => $nbHeure)
                        <tr>
                            <td>{{  ucfirst(\Carbon\Carbon::parse($jour)->localeDayOfWeek) . ' ' . \Carbon\Carbon::parse($jour)->format('d/m/Y') }}</td>
                            <td>{{$nbHeure/60}} H</td>
                            @php
                              $total=$total+($nbHeure/60)
                            @endphp
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="2">TOTAL SEMAINE : <b>{{ $total }} H {{ $countDown > 0 ? "(" . $countDown/60 . " heures CP ou RECUP)" : "" }}</b></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @if($signature->user_hasSigned != null && $signature->employee_hasSigned != null)
            <div class="form-group row">
                <div class="col-sm-12 text-center">
                    <b>Le commentaire de l'employé :</b>
                    <p>
                        {{$signature->comment != null ? $signature->comment : "Pas de commentaire"}}
                    </p>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12 text-center">
                    <b>Le commentaire de la coordinatrice :</b>
                    <p>
                        {{$signature->comment_admin != null ? $signature->comment_admin : "Pas de commentaire"}}
                    </p>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                <tr class="text-center">
                    <th scope="col">Signature coordinatrice</th>
                    <th scope="col">Signature de {{ $employee->name . " " . $employee->lastname }}</th>
                </tr>
                </thead>
                <tbody>
                <tr class="text-center">
                    <td> <img src="{{ url('storage/signature/' . $signature->user_hasSigned) }}" alt="SignatureCoordinatrice" width="300px"></td>
                    <td> <img src="{{ url("storage/signature/" . $signature->employee_hasSigned) }}" alt="SignatureEmployee" width="300px"></td>
                </tr>
                </tbody>
            </table>
        @else
            <p class="text-center">
                Cette semaine n'est pas encore validée pour le moment
            </p>
        @endif
    </div>
@endsection

@section('js')

    <script>
        $(document).ready(function() {
            // SOMETHING
        })

    </script>

@endsection
