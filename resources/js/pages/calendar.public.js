import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import interactionPlugin from '@fullcalendar/interaction';
import zhTwLocale from '@fullcalendar/core/locales/zh-tw';

document.addEventListener('DOMContentLoaded', function () {
    const el = document.getElementById('public-calendar');
    if (!el) {
        return;
    }

    const eventsUrl = el.getAttribute('data-events-url');
    const calendar = new Calendar(el, {
        plugins: [dayGridPlugin, interactionPlugin, listPlugin, timeGridPlugin],
        locale: zhTwLocale,
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
                .then((resp) => resp.json())
                .then((data) => successCallback(data))
                .catch(() => failureCallback());
        },
    });

    calendar.render();
});
