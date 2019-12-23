@extends('layouts/app')

@section('content')

    <div style="float: left">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Nb heure</th>
                </tr>
                </thead>
                <tbody>
                @foreach($arrayhoursPerEmployee as $array)
                    @foreach($array as $k => $v)
                        <tr>
                            <th>{{ $k }} </th>
                            <td>{{ $v / 60 }} heures</td>
                        </tr>
                    @endforeach
                @endforeach

                </tbody>
            </table>
    </div>

    <div class="container">

        <div id="calendar"></div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ajouter une journée</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('planning.store') }}" method="post" id="addEmployee">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label for="employe" class="col-sm-2 col-form-label">Employé</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="employe" name="employee_id">
                                    @foreach($employees as $employe)
                                        <option value="{{ $employe->id }}">{{ $employe->name . ' ' . $employe->lastname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="date" class="col-sm-2 col-form-label">Date début</label>
                            <div class="col-sm-10">
                                <input type="datetime-local" class="date form-control" id="date" name="date">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="date_end" class="col-sm-2 col-form-label">Date fin</label>
                            <div class="col-sm-10">
                                <input type="datetime-local" class="date form-control" id="date_end" name="date_end">
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary" id="submit"><i class="fas fa-plus-square"></i> Ajouter</button>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>

        document.addEventListener('DOMContentLoaded', function() {

            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: [ 'interaction', 'dayGrid', 'timeGrid' ],
                selectable: true,
                locale: 'fr',
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events : [
                    @foreach($plannings as $planning)
                    {
                            title : '{{$planning->employee()->get()[0]->name . ' ' . $planning->employee()->get()[0]->lastname}}',
                            start : '{{$planning->date}}',
                            end : '{{$planning->date_end}}',

                    },
                    @endforeach
                ],
                dateClick: function(info) {
                    //
                }
            });

            calendar.render();

            $('#submit').click(function() {
                var form = $('#addEmployee');
                $.ajax({
                    method: form.attr('method'),
                    url: form.attr('action'),
                    data: form.serialize(),
                    dataType: "json"
                })
                .done(function(data) {
                    location.reload();
                })
                .fail(function(data) {
                    console.log(data);
                });
            });

        });

    </script>

@endsection
