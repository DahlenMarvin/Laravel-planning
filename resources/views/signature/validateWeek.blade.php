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
            left: 0;
            top: 0;
            width:400px;
            height:200px;
            background-color: white;
        }
    </style>

@endsection

@section('content')

    <div class="container">

        <table class="table table-bordered">
            <thead>
            <tr style="text-align: center">
                <th scope="col">Date début</th>
                <th scope="col">Date fin</th>
                <th scope="col">Total</th>
            </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                @foreach($plannings as $planning)
                    @if($planning->isCP == 1)
                        <tr style="text-align: center">
                            <td colspan="2">CP ==> {{ ucfirst(\Carbon\Carbon::parse($planning->date)->localeDayOfWeek) . ' ' . \Carbon\Carbon::parse($planning->date)->format('d') . ' ' . \Carbon\Carbon::parse($planning->date)->localeMonth . ' ' . \Carbon\Carbon::parse($planning->date)->format('Y') }}</td>
                            <td>{{ (\Carbon\Carbon::parse($planning->date_end)->diffInMinutes(\Carbon\Carbon::parse($planning->date)))/60 }} H</td>
                            <?php $total = $total + (\Carbon\Carbon::parse($planning->date_end)->diffInMinutes(\Carbon\Carbon::parse($planning->date)))/60; ?>
                        </tr>
                    @else
                        <tr style="text-align: center">
                            <td>{{  ucfirst(\Carbon\Carbon::parse($planning->date)->localeDayOfWeek) . ' ' . \Carbon\Carbon::parse($planning->date)->format('d') . ' ' . \Carbon\Carbon::parse($planning->date)->localeMonth . ' ' . \Carbon\Carbon::parse($planning->date)->format('Y H\hi\m') }}</td>
                            <td>{{  ucfirst(\Carbon\Carbon::parse($planning->date_end)->localeDayOfWeek) . ' ' . \Carbon\Carbon::parse($planning->date_end)->format('d') . ' ' . \Carbon\Carbon::parse($planning->date_end)->localeMonth . ' ' . \Carbon\Carbon::parse($planning->date_end)->format('Y H\hi\m') }}</td>
                            <td>{{ (\Carbon\Carbon::parse($planning->date_end)->diffInMinutes(\Carbon\Carbon::parse($planning->date)))/60 }} H</td>
                            <?php $total = $total + (\Carbon\Carbon::parse($planning->date_end)->diffInMinutes(\Carbon\Carbon::parse($planning->date)))/60; ?>
                        </tr>
                    @endif
                @endforeach
                <tr style="text-align: center">
                    <td colspan="2" style="font-weight: bold">TOTAL</td>
                    <td colspan="2">{{ $total }} H</td>
                </tr>
            </tbody>
        </table>

        <div class="form-group row">
            <div class="col-sm-12">
                <textarea name="comment" id="comment" rows="5" placeholder="Votre commentaire" class="form-control"></textarea>
            </div>
        </div>

        <div class="wrapper text-center">
            <canvas id="signature-pad" class="signature-pad" width=400 height=200 style="border:1px solid black"></canvas>
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
                    url: '{{ route('signature.store', ['isAdmin' => 0]) }}',
                    data: {
                        dataUri: data,
                        comment: $('#comment').val(),
                        employee_id: {{ $employee->id }},
                        nSemaine: $('#nSemaine').val(),
                        nAnnee: $('#nAnnee').val(),
                    },
                    dataType: '',
                })
                    .done(function(data) {
                        window.location.href = "http://planning.magasin-leseleveursdelacharentonne.fr/signature/tableProgress/" + {{ $employee->id }} ;
                    })
                    .fail(function(data) {
                        alert(data);
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
