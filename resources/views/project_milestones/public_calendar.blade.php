<!doctype html>
<html lang="zh-Hant">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $project->name }}｜公開行事曆</title>
    @vite(['node_modules/fullcalendar/main.min.css'])
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/locales-all.global.min.js"></script>
    <style>
        body {
            margin: 0;
            background: #f7f9fc;
            color: #1f2937;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Noto Sans TC", "PingFang TC", sans-serif;
        }
        .public-calendar-wrap {
            max-width: 1400px;
            margin: 0 auto;
            padding: 16px;
        }
        .public-calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }
        .public-calendar-title {
            font-size: 22px;
            font-weight: 700;
        }
        .public-calendar-subtitle {
            font-size: 13px;
            color: #6b7280;
            margin-top: 2px;
        }
        .public-calendar-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 12px;
        }
    </style>
</head>
<body>
    <div class="public-calendar-wrap">
        <div class="public-calendar-header">
            <div>
                <div class="public-calendar-title">{{ $project->name }}｜公開行事曆</div>
                <div class="public-calendar-subtitle">此頁為唯讀模式，僅供查看排程。</div>
            </div>
        </div>
        <div class="public-calendar-card">
            <div id="public-calendar" data-events-url="{{ route('calendar.public.events', ['uuid' => $project->calendar_uuid]) }}"></div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const el = document.getElementById('public-calendar');
            if (!el || !window.FullCalendar) return;

            const eventsUrl = el.getAttribute('data-events-url');
            const calendar = new FullCalendar.Calendar(el, {
                locale: 'zh-tw',
                initialView: 'dayGridMonth',
                editable: false,
                selectable: false,
                eventStartEditable: false,
                eventDurationEditable: false,
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
                events: function (_fetchInfo, successCallback, failureCallback) {
                    fetch(eventsUrl)
                        .then(function (resp) { return resp.json(); })
                        .then(function (data) { successCallback(data); })
                        .catch(function () { failureCallback(); });
                },
            });

            calendar.render();
        });
    </script>
</body>
</html>
