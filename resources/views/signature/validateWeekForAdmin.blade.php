@extends('layouts/app')

@section('css')

    <style>
        .wrapper {
            position: relative;
            width: 400px;
            height: 200px;
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .signature-pad {
            position: absolute;
            top: 0;
            left:80%;
            width:100%;
            height:200px;
            background-color: white;
        }
    </style>

@endsection

@section('content')

    <div class="container">

        <b>{{$employee->name . " " . $employee->lastname}} | {{ $employee->user->name }} | Heure de cette semaine : {{ $total / 60 }}H</b>

        <table class="table table-bordered">
            <thead>
            <tr style="text-align: center">
                <th scope="col">Date début</th>
                <th scope="col">Date fin</th>
                <th scope="col">Date de la saisie</th>
            </tr>
            </thead>
            <tbody>
            @foreach($plannings as $planning)
                @if($planning->isCP == 1)
                    <tr style="text-align: center">
                        <td colspan="2">CP ==> {{ ucfirst(\Carbon\Carbon::parse($planning->date)->localeDayOfWeek) . ' ' . \Carbon\Carbon::parse($planning->date)->format('d') . ' ' . \Carbon\Carbon::parse($planning->date)->localeMonth . ' ' . \Carbon\Carbon::parse($planning->date)->format('Y') }}</td>
                        <td>{{  ucfirst(\Carbon\Carbon::parse($planning->updated_at)->addHour()->localeDayOfWeek) . ' ' . \Carbon\Carbon::parse($planning->updated_at)->addHour()->format('d') . ' ' . \Carbon\Carbon::parse($planning->updated_at)->addHour()->localeMonth . ' ' . \Carbon\Carbon::parse($planning->updated_at)->addHour()->format('Y H\hi\m') }}</td>
                    </tr>
                @else
                    <tr style="text-align: center">
                        <td>{{  ucfirst(\Carbon\Carbon::parse($planning->date)->localeDayOfWeek) . ' ' . \Carbon\Carbon::parse($planning->date)->format('d') . ' ' . \Carbon\Carbon::parse($planning->date)->localeMonth . ' ' . \Carbon\Carbon::parse($planning->date)->format('Y H\hi\m') }}</td>
                        <td>{{  ucfirst(\Carbon\Carbon::parse($planning->date_end)->localeDayOfWeek) . ' ' . \Carbon\Carbon::parse($planning->date_end)->format('d') . ' ' . \Carbon\Carbon::parse($planning->date_end)->localeMonth . ' ' . \Carbon\Carbon::parse($planning->date_end)->format('Y H\hi\m') }}</td>
                        <td>{{  ucfirst(\Carbon\Carbon::parse($planning->updated_at)->addHour()->localeDayOfWeek) . ' ' . \Carbon\Carbon::parse($planning->updated_at)->addHour()->format('d') . ' ' . \Carbon\Carbon::parse($planning->updated_at)->addHour()->localeMonth . ' ' . \Carbon\Carbon::parse($planning->updated_at)->addHour()->format('Y H\hi\m') }}</td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>

        <div class="form-group row">
            <div class="col-sm-12">
                Commentaire de la personne :
                <p>
                    <b>{{ $signature->comment != null ? $signature->comment : "Pas de commentaire"}}</b>
                </p>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-12">
                <textarea name="comment_admin" id="comment_admin" rows="5" placeholder="Votre commentaire" class="form-control"></textarea>
            </div>
        </div>

        <div class="wrapper text-center">
            <img src="{{ url("storage/signature/" . $signature->employee_hasSigned) }}" alt="SignatureEmployee" width="300px" style="float: left">
            <canvas id="signature-pad" class="signature-pad" width=400 height=200 style="border:1px solid black; float: right"></canvas>
        </div>

        <div class="form-group row">
            <div class="col-sm-5">
                &nbsp;
            </div>
            <div class="col-sm-2">
                <button id="undo">Annuler</button>
                <button id="clear">Nettoyer</button>
            </div>
            <div class="col-sm-5">
                &nbsp;
            </div>
        </div>

        <div class="form-group text-center">
            <input type="submit" class="btn btn-success" value="Signer la semaine" id="save-png">
        </div>

        <input type="hidden" value="{{ $nSemaine }}" id="nSemaine">
        <input type="hidden" value="{{ $nAnnee }}" id="nAnnee">

    </div>

@endsection

@section('js')

    <script>
        $(document).ready(function() {
            var canvas = document.getElementById('signature-pad');

            // Adjust canvas coordinate space taking into account pixel ratio,
            // to make it look crisp on mobile devices.
            // This also causes canvas to be cleared.
            function resizeCanvas() {
                // When zoomed out to less than 100%, for some very strange reason,
                // some browsers report devicePixelRatio as less than 1
                // and only part of the canvas is cleared then.
                var ratio =  Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
            }

            window.onresize = resizeCanvas;
            resizeCanvas();

            var signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(255, 255, 255)' // necessary for saving image as JPEG; can be removed is only saving as PNG or SVG
            });

            $('#save-png').click(function(){
                if (signaturePad.isEmpty()) {
                    return alert("Merci de signé le document avant.");
                }

                var data = signaturePad.toDataURL('image/png');

                //Test en ajax
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    method: 'POST',
                    url: '{{ route('signature.store', ['isAdmin' => 1]) }}',
                    data: {
                        dataUri: data,
                        comment: $('#comment').val(),
                        comment_admin: $('#comment_admin').val(),
                        employee_id: {{ $employee->id }},
                        nSemaine: $('#nSemaine').val(),
                        nAnnee: $('#nAnnee').val(),
                    },
                    dataType: '',
                })
                    .done(function(data) {
                        window.location.href = "http://planning.magasin-leseleveursdelacharentonne.fr/signature/validatePlanning";
                    })
                    .fail(function(data) {
                        alert("Une erreur est survenue lors de la signature de cette personne. Merci de prendre contact avec Dahlen Marvin pour savoir ce qu'il se passe.");
                    });
            });

            $('#save-jpeg').click(function(){
                if (signaturePad.isEmpty()) {
                    return alert("Please provide a signature first.");
                }

                var data = signaturePad.toDataURL('image/jpeg');
                console.log(data);
                window.open(data);
            });

            $('#save-svg').click(function(){
                if (signaturePad.isEmpty()) {
                    return alert("Please provide a signature first.");
                }

                var data = signaturePad.toDataURL('image/svg+xml');
                console.log(data);
                console.log(atob(data.split(',')[1]));
                window.open(data);
            });

            $('#clear').click(function(){
               signaturePad.clear();
            });

            $('#undo').click(function(){
                var data = signaturePad.toData();
                if (data) {
                    data.pop(); // remove the last dot or line
                    signaturePad.fromData(data);
                }
            });

        })

    </script>

@endsection
