@extends('layouts/app')

@section('css')

    <style>
        #external-events {
            position: fixed;
            z-index: 2;
            padding: 0 10px;
            border: 1px solid #ccc;
            background: #ffffff;
            margin-top: 260px;
        }

        #TableHours {
            position: fixed;
            z-index: 2;
            padding: 0 10px;
            border: 1px solid #ccc;
            background: #ffffff;
            width: 10%;
        }

        #external-events .fc-event {
            margin: 1em 0;
            cursor: move;
        }
    </style>

@endsection

@section('content')

    <div style="float: left; margin-left: 5%">
            <table class="table table-bordered" id="TableHours">
                <thead>
                <tr>
                    <th colspan="2">{{ \Carbon\Carbon::now()->format('m / Y') }}</th>
                </tr>
                <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Nb heure</th>
                </tr>
                </thead>
                <tbody id="nbHours">
                @foreach($arrayhoursPerEmployee as $array)
                    @foreach($array as $k => $v)
                        <tr>
                            <th>{{ $k }} </th>
                            <td>{{ $v }} heures</td>
                        </tr>
                    @endforeach
                @endforeach

                </tbody>
            </table>
        <br><br>

        <div id='external-events'>
            <p>
                <strong>Evenement</strong>
            </p>
            <label for="employee">Employé</label>
            <select name="employee_id" id="employee_id" class="form-control">
                @foreach($employees as $employe)
                    <option value="{{ $employe->id }}">{{ $employe->name . ' ' . $employe->lastname }}</option>
                @endforeach
            </select>
            <div class='fc-event'>Matin</div>
            <div class='fc-event'>Après-midi</div>
            <div class='fc-event'>Journée continue</div>
        </div>

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
            var montName = document.getElementsByClassName('fc-center');
            var Draggable = FullCalendarInteraction.Draggable;
            var containerEl = document.getElementById('external-events');
            new Draggable(containerEl, {
                itemSelector: '.fc-event',
                eventData: function(eventEl) {
                    return {
                        title: eventEl.innerText,
                        startTime: '08:30',
                        duration: "04:00"
                    };
                }
            });

            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: [ 'interaction', 'dayGrid', 'timeGrid' ],
                selectable: true,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay, listMonth'
                },
                droppable: true,
                eventLimit: true,
                locale: 'fr',
                weekNumbers: true,
                events : [
                    @foreach($plannings as $planning)
                    {
                            title : '{{$planning->employee()->get()[0]->name . ' ' . $planning->employee()->get()[0]->lastname}}',
                            start : '{{$planning->date}}',
                            end : '{{$planning->date_end}}',
                            url : '{{route('planning.show', $planning)}}',

                    },
                    @endforeach
                ],
                dateClick: function(info) {
                    $('.date').val(info.dateStr + 'T09:00');
                    $('#basicExampleModal').modal();
                },
                drop: function(info) {
                    var employee_id = $('#employee_id').val();
                    var date = info.dateStr;
                    var event = info.draggedEl.textContent;

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        method: 'POST',
                        url: '{{ route('planning.addEvent') }}',
                        data: {
                            employee_id: employee_id,
                            date: date,
                            event: event
                        },
                        dataType: '',
                    })
                        .done(function(data) {
                            location.reload();
                        })
                        .fail(function(data) {
                            console.log(data);
                        });

                }
            });

            calendar.render();

            $('.fc-button-group').on('click', function() {
                $.ajax({
                    method: 'GET',
                    url: '{{ route('planning.updateHours') }}',
                    data: {
                        month: $('.fc-center').text()
                    },
                    dataType: 'html',
                })
                .done(function(data) {
                    $('#TableHours').html(data);
                })
                .fail(function(data) {
                    $('#TableHours').html(data);
                });
            });

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
