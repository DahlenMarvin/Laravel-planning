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

    <!--
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
                @ foreach($arrayhoursPerEmployee as $array)
                    @ foreach($array as $k => $v)
                        <tr>
                            <th>{ { $k }} </th>
                            <td>{ { $v }} heures</td>
                        </tr>
                    @ endforeach
                @ endforeach

                </tbody>
            </table>
        <br><br>

        <div id='external-events'>
            <p>
                <strong>Evenement</strong>
            </p>
            <label for="employee">Employé</label>
            <select name="employee_id" id="employee_id" class="form-control">
                @ foreach($employees as $employe)
                    <option value="{ { $employe->id }}">{ { $employe->name . ' ' . $employe->lastname }}</option>
                @ endforeach
            </select>
            <div class='fc-event'>Matin</div>
            <div class='fc-event'>Après-midi</div>
            <div class='fc-event'>Journée continue</div>
        </div>

    </div>
    -->
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
                                <input type="datetime-local" class="date form-control" id="date" name="date" value="2018-06-12T19:30">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="date_end" class="col-sm-2 col-form-label">Date fin</label>
                            <div class="col-sm-10">
                                <input type="datetime-local" class="date_end form-control" id="date_end" name="date_end">
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

    <!-- Modal -->
    <div class="modal fade" id="modalHours" tabindex="-1" role="dialog" aria-labelledby="modalHours"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Récapitulatif de vos heures</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="contentModal">
                    &nbsp;
                </div>
                <div class="modal-footer">
                    &nbsp;
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="idPlanning" id="idPlanning" value="{{ $idPlanning }}">

@endsection

@section('js')
    <script>

        document.addEventListener('DOMContentLoaded', function() {

            var calendarEl = document.getElementById('calendar');
            var montName = document.getElementsByClassName('fc-center');
            var Draggable = FullCalendarInteraction.Draggable;
            /*
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
            */
            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: [ 'interaction', 'timeGrid' ],
                defaultView: 'timeGridWeek',
                selectable: true,
                customButtons: {
                    duplicate: {
                        text: 'Dupliquer',
                        click: function() {
                            let weekNumber = $('.fc-week-number');
                            let year = $('.fc-center');
                            year = year[0].innerText;
                            weekNumber = weekNumber[0].innerText;
                            weekToDuplicate = $('#select').val();
                            window.location.href = "http://planning.magasin-leseleveursdelacharentonne.fr/planning/duplicate/" + weekNumber + "/" + year + "/" + $('#idPlanning').val() + "/" + weekToDuplicate;
                        }
                    },
                    periode: {
                        text: 'TEMPO',
                        click: function() {
                            //
                        }
                    },
                    cp: {
                        text: 'CP',
                        click: function() {
                            alert('En cours de développement')
                        }
                    },
                    hours: {
                        text: 'Vos heures',
                        click: function() {

                            var dateString = $('.fc-center').text();
                            var weekNumberString = $('.fc-week-number span').text()

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            $.ajax({
                                method: 'GET',
                                url: '{{ route('planning.getHoursEmployees') }}',
                                data: {
                                    magasin_id: {{ \Illuminate\Support\Facades\Auth::user()->id }},
                                    year: dateString.substring(dateString.length - 4),
                                    weekNumber: weekNumberString.substring(weekNumberString.length - 1)
                                },
                                dataType: 'html',
                            })
                                .done(function(data) {
                                    $('#contentModal').html(data);
                                    $('#modalHours').modal();
                                })
                                .fail(function(data) {
                                    console.log(data);
                                });

                        }
                    }
                },
                header: {
                    left: 'prev,next hours cp',
                    center: 'title',
                    right: 'periode duplicate'
                },
                droppable: true,
                eventLimit: true,
                locale: 'fr',
                weekNumbers: true,
                firstDay: 1,
                events : [
                    @foreach($plannings as $planning)
                    {
                            title : '{{$planning->employee()->get()[0]->name . ' ' . $planning->employee()->get()[0]->lastname}}',
                            start : '{{$planning->date}}',
                            end : '{{$planning->date_end}}',
                            url : '{{route('planning.show', $planning)}}',
                            color: '{{ $planning->employee()->get()[0]->color }}',

                    },
                    @endforeach
                ],
                dateClick: function(info) {

                    var string = info.dateStr;

                    //$('.date').val(aaaa+'-'+mm+'-'+jj+'T'+hour+':'+minut);
                    $('.date').val(string.substring(0,16));
                    $('.date_end').val(string.substring(0,16));
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

            $('.fc-today-button').text("Aujourd'hui");

            //Configuration de locale momentjs
            moment.locale('fr', {
                months : 'janvier_février_mars_avril_mai_juin_juillet_août_septembre_octobre_novembre_décembre'.split('_'),
                monthsShort : 'janv._févr._mars_avr._mai_juin_juil._août_sept._oct._nov._déc.'.split('_'),
                monthsParseExact : true,
                weekdays : 'dimanche_lundi_mardi_mercredi_jeudi_vendredi_samedi'.split('_'),
                weekdaysShort : 'dim._lun._mar._mer._jeu._ven._sam.'.split('_'),
                weekdaysMin : 'Di_Lu_Ma_Me_Je_Ve_Sa'.split('_'),
                weekdaysParseExact : true,
                longDateFormat : {
                    LT : 'HH:mm',
                    LTS : 'HH:mm:ss',
                    L : 'DD/MM/YYYY',
                    LL : 'D MMMM YYYY',
                    LLL : 'D MMMM YYYY HH:mm',
                    LLLL : 'dddd D MMMM YYYY HH:mm'
                },
                calendar : {
                    sameDay : '[Aujourd’hui à] LT',
                    nextDay : '[Demain à] LT',
                    nextWeek : 'dddd [à] LT',
                    lastDay : '[Hier à] LT',
                    lastWeek : 'dddd [dernier à] LT',
                    sameElse : 'L'
                },
                relativeTime : {
                    future : 'dans %s',
                    past : 'il y a %s',
                    s : 'quelques secondes',
                    m : 'une minute',
                    mm : '%d minutes',
                    h : 'une heure',
                    hh : '%d heures',
                    d : 'un jour',
                    dd : '%d jours',
                    M : 'un mois',
                    MM : '%d mois',
                    y : 'un an',
                    yy : '%d ans'
                },
                dayOfMonthOrdinalParse : /\d{1,2}(er|e)/,
                ordinal : function (number) {
                    return number + (number === 1 ? 'er' : 'e');
                },
                meridiemParse : /PD|MD/,
                isPM : function (input) {
                    return input.charAt(0) === 'M';
                },
                // In case the meridiem units are not separated around 12, then implement
                // this function (look at locale/id.js for an example).
                // meridiemHour : function (hour, meridiem) {
                //     return /* 0-23 hour, given meridiem token and hour 1-12 */ ;
                // },
                meridiem : function (hours, minutes, isLower) {
                    return hours < 12 ? 'PD' : 'MD';
                },
                week : {
                    dow : 1, // Monday is the first day of the week.
                    doy : 4  // Used to determine first week of the year.
                }
            });

            moment.locale("fr");

            var html = "<div><select id=\"select\">";
            for (let i = 0; i <= 3; i++) {
                var debut = moment().add(i, "w").startOf('isoWeek').format('D|MM|YYYY') + "-" + moment().add(i, "w").endOf('isoWeek').format('D|MM|YYYY');
                html = html.concat("<option value=\""+debut+"\">"+debut+"</option>")
            }
            html = html.concat('</div>');

            $('.fc-periode-button').html(html);

            /*$('.fc-button-group').on('click', function() {
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
            });*/

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
