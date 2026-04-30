@extends('layouts.vertical', ['title' => '個人行事曆'])

@section('css')
    @vite(['node_modules/fullcalendar/main.min.css'])
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/locales-all.global.min.js"></script>
    <style>
        #personTaskCalendar .pt-event-line {
            display: block;
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        @include('layouts.shared.page-title', [
            'title' => ($calendarTitle ?? '個人行事曆') . '【' . ($calendarUserName ?? Auth::user()->name) . '】',
            'subtitle' => $calendarSubtitle ?? '個人待辦',
        ])

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div id="personTaskCalendar"
                            data-events-url="{{ isset($calendarUserId) ? route('person.task.calendar.user.events', $calendarUserId) : route('person.task.calendar.events') }}"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('personTaskCalendar');
            if (!calendarEl || !window.FullCalendar) return;

            const eventsUrl = calendarEl.getAttribute('data-events-url');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'zh-tw',
                initialView: 'dayGridMonth',
                editable: false,
                selectable: false,
                eventStartEditable: false,
                eventDurationEditable: false,
                displayEventTime: false,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth',
                },
                buttonText: {
                    today: '今天',
                    month: '月',
                    week: '週',
                    day: '日',
                    list: '列表',
                },
                events: function(_fetchInfo, successCallback, failureCallback) {
                    fetch(eventsUrl)
                        .then(function(resp) {
                            return resp.json();
                        })
                        .then(function(data) {
                            successCallback(data);
                        })
                        .catch(function() {
                            failureCallback();
                        });
                },
                eventDidMount: function(info) {
                    const detail = info.event.extendedProps.detail || '';
                    const tooltip = detail ? (info.event.title + '\n' + detail) : info.event.title;
                    info.el.setAttribute('title', tooltip);
                },
                eventContent: function(arg) {
                    const projectName = arg.event.extendedProps.project_name || '';
                    const dispatchTask = arg.event.extendedProps.dispatch_task || '';
                    const wrap = document.createElement('div');

                    const projectLine = document.createElement('span');
                    projectLine.className = 'pt-event-line';
                    projectLine.textContent = projectName;

                    const taskLine = document.createElement('span');
                    taskLine.className = 'pt-event-line';
                    taskLine.textContent = dispatchTask;

                    wrap.appendChild(projectLine);
                    wrap.appendChild(taskLine);
                    return { domNodes: [wrap] };
                },
            });

            calendar.render();
        });
    </script>
@endsection
