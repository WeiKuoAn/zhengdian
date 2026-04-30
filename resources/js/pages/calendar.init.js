/**
 * Theme: Hyper - Responsive Bootstrap 5 Admin Dashboard
 * Author: Coderthemes
 * Component: Full-Calendar
 */


import { Calendar } from '@fullcalendar/core';
import { Draggable } from '@fullcalendar/interaction';
import interactionPlugin from '@fullcalendar/interaction';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import dayGridPlugin from '@fullcalendar/daygrid';
import { Modal } from "bootstrap";
import zhTwLocale from '@fullcalendar/core/locales/zh-tw';

!function ($) {
    "use strict";

    var CalendarApp = function () {
        this.$body = $("body");
        this.$modal = $('#event-modal');
        this.$calendar = $('#calendar');
        const projectIdRaw = this.$calendar.data('project-id');
        this.projectId = projectIdRaw ? parseInt(projectIdRaw, 10) : null;
        this.hoverOnly = String(this.$calendar.data('hover-only') || '') === '1';
        this.$formEvent = $("#form-event");
        this.$btnNewEvent = $("#btn-new-event");
        this.$btnDeleteEvent = $("#btn-delete-event");
        this.$btnSaveEvent = $("#btn-save-event");
        this.$modalTitle = $("#modal-title");
        this.$calendarObj = null;
        this.$selectedEvent = null;
        this.$newEventData = null;
    };

    /* 設定 CSRF Token 避免 Laravel 拒絕請求 */
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    /* 取得事件資料 */
    CalendarApp.prototype.fetchEvents = function (callback) {
        $.ajax({
            url: "/api/calendar/events",
            method: "GET",
            data: this.projectId ? { project_id: this.projectId } : {},
            success: function (response) {
                let events = response.map(event => ({
                    id: event.id,
                    title: event.title,
                    start: event.start,
                    end: event.end ? event.end : null,
                    className: event.className ? event.className : "bg-primary",
                }));
                callback(events);
            },
            error: function () {
                alert("無法載入行事曆事件，請檢查 API");
            }
        });
    };

    /* 點擊事件 */
    CalendarApp.prototype.onEventClick = function (info) {
        this.$formEvent[0].reset();
        this.$formEvent.removeClass("was-validated");

        this.$newEventData = null;
        if (this.hoverOnly) {
            return;
        }
        this.$btnDeleteEvent.show();
        this.$modalTitle.text('編輯行事曆事件');
        this.$modal.show();
        this.$selectedEvent = info.event;
        $("#event-title").val(this.$selectedEvent.title);
        $("#event-category").val(this.$selectedEvent.classNames[0]);

        $("#form-event").off("submit").on("submit", function (e) {
            e.preventDefault();
            saveEvent(info.event.id);
        });

        $("#btn-delete-event").off("click").on("click", function () {
            deleteEvent(info.event.id);
        });
    };

    /* 選擇日期 */
    CalendarApp.prototype.onSelect = function (info) {
        this.$formEvent[0].reset();
        this.$formEvent.removeClass("was-validated");

        this.$selectedEvent = null;
        this.$newEventData = info;
        this.$btnDeleteEvent.hide();
        this.$modalTitle.text('新增行事曆事件');
        if (this.hoverOnly) {
            return;
        }

        this.$modal.show();
        this.$calendarObj.unselect();

        $("#form-event").off("submit").on("submit", function (e) {
            e.preventDefault();
            saveEvent(null, info.dateStr);
        });
    };

    /* 初始化 FullCalendar */
    CalendarApp.prototype.init = function () {
        this.$modal = new Modal(document.getElementById('event-modal'), { keyboard: false });

        var $this = this;

        this.$calendarObj = new Calendar(this.$calendar[0], {
            plugins: [dayGridPlugin, interactionPlugin, listPlugin, timeGridPlugin],
            locale: zhTwLocale,
            initialView: 'dayGridMonth',
            displayEventTime: false,
            buttonText: {
                today: '今天',
                month: '月',
                week: '週',
                day: '日',
                list: '列表'
            },
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },
            editable: true,
            selectable: true,
            droppable: true,
            events: function (fetchInfo, successCallback, failureCallback) {
                $this.fetchEvents(successCallback);
            },
            dateClick: function (info) {
                $this.onSelect(info);
            },
            eventClick: function (info) {
                $this.onEventClick(info);
            },
            eventDrop: function (info) {
                updateEvent(info.event);
            },
            eventDidMount: function (info) {
                const detail = info.event.extendedProps.detail || info.event.title || '';
                info.el.setAttribute('title', detail);
            },
            eventContent: function (arg) {
                const projectName = arg.event.extendedProps.project_name || '';
                const taskName = arg.event.extendedProps.task_name || arg.event.title || '';
                const wrap = document.createElement('div');

                const projectLine = document.createElement('span');
                projectLine.style.display = 'block';
                projectLine.style.lineHeight = '1.2';
                projectLine.style.whiteSpace = 'nowrap';
                projectLine.style.overflow = 'hidden';
                projectLine.style.textOverflow = 'ellipsis';
                projectLine.textContent = projectName;

                const taskLine = document.createElement('span');
                taskLine.style.display = 'block';
                taskLine.style.lineHeight = '1.2';
                taskLine.style.whiteSpace = 'nowrap';
                taskLine.style.overflow = 'hidden';
                taskLine.style.textOverflow = 'ellipsis';
                taskLine.textContent = taskName;

                wrap.appendChild(projectLine);
                wrap.appendChild(taskLine);
                return { domNodes: [wrap] };
            }
        });

        if (this.hoverOnly) {
            this.$calendarObj.setOption('editable', false);
            this.$calendarObj.setOption('selectable', false);
            this.$calendarObj.setOption('eventStartEditable', false);
            this.$calendarObj.setOption('eventDurationEditable', false);
        }

        this.$calendarObj.render();
    };

    // 新增 / 更新事件
    function saveEvent(eventId = null, start = null) {
        const app = $.CalendarApp;
        var eventData = {
            id: eventId,
            title: $("#event-title").val(),
            start: start ? start : $("#event-start").val(),
            end: $("#event-end").val() ? $("#event-end").val() : null,
            className: $("#event-category").val(),
            project_id: app && app.projectId ? app.projectId : null
        };

        $.ajax({
            url: "/api/calendar/events",
            method: "POST",
            contentType: "application/json",
            data: JSON.stringify(eventData),
            success: function () {
                $("#event-modal").modal("hide");
                location.reload();
            },
            error: function () {
                alert("無法儲存事件，請檢查 API");
            }
        });
    }

    // 更新事件（拖拉變更時間）
    function updateEvent(event) {
        $.ajax({
            url: "/api/calendar/events",
            method: "POST",
            contentType: "application/json",
            data: JSON.stringify({
                id: event.id,
                title: event.title,
                start: event.start.toISOString(),
                end: event.end ? event.end.toISOString() : null,
                className: event.classNames[0]
            }),
            success: function () {
                console.log("事件更新成功");
            },
            error: function () {
                alert("無法更新事件");
            }
        });
    }

    // 刪除事件
    function deleteEvent(eventId) {
        const app = $.CalendarApp;
        $.ajax({
            url: "/api/calendar/events/" + eventId,
            method: "DELETE",
            data: app && app.projectId ? { project_id: app.projectId } : {},
            success: function () {
                $("#event-modal").modal("hide");
                location.reload();
            },
            error: function () {
                alert("刪除事件失敗");
            }
        });
    }

    $.CalendarApp = new CalendarApp();
    $.CalendarApp.Constructor = CalendarApp;

}(window.jQuery),

// 啟動 CalendarApp
function ($) {
    "use strict";
    $.CalendarApp.init();
}(window.jQuery);





    //舊
    /**
 * Theme: Hyper - Responsive Bootstrap 5 Admin Dashboard
 * Author: Coderthemes
 * Component: Full-Calendar
 */


// import {Calendar} from '@fullcalendar/core';
// import {Draggable} from '@fullcalendar/interaction';
// import interactionPlugin from '@fullcalendar/interaction';
// import timeGridPlugin from '@fullcalendar/timegrid';
// import listPlugin from '@fullcalendar/list';
// import dayGridPlugin from '@fullcalendar/daygrid';

// import {Modal} from "bootstrap";

// import bootstrapPlugin from '@fullcalendar/bootstrap';

// !function ($) {
//     "use strict";

//     var CalendarApp = function () {
//         this.$body = $("body")
//         this.$modal = $('#event-modal'),
//             this.$calendar = $('#calendar'),
//             this.$formEvent = $("#form-event"),
//             this.$btnNewEvent = $("#btn-new-event"),
//             this.$btnDeleteEvent = $("#btn-delete-event"),
//             this.$btnSaveEvent = $("#btn-save-event"),
//             this.$modalTitle = $("#modal-title"),
//             this.$calendarObj = null,
//             this.$selectedEvent = null,
//             this.$newEventData = null
//     };


//     /* on click on event */
//     CalendarApp.prototype.onEventClick = function (info) {
//         this.$formEvent[0].reset();
//         this.$formEvent.removeClass("was-validated");

//         this.$newEventData = null;
//         this.$btnDeleteEvent.show();
//         this.$modalTitle.text('Edit Event');
//         this.$modal.show();
//         this.$selectedEvent = info.event;
//         $("#event-title").val(this.$selectedEvent.title);
//         $("#event-category").val(this.$selectedEvent.classNames[0]);
//     },

//         /* on select */
//         CalendarApp.prototype.onSelect = function (info) {
//             this.$formEvent[0].reset();
//             this.$formEvent.removeClass("was-validated");

//             this.$selectedEvent = null;
//             this.$newEventData = info;
//             this.$btnDeleteEvent.hide();
//             this.$modalTitle.text('Add New Event');

//             this.$modal.show();
//             this.$calendarObj.unselect();
//         },

//         /* Initializing */
//         CalendarApp.prototype.init = function () {

//             this.$modal = new Modal(document.getElementById('event-modal'), {
//                 keyboard: false
//             });

//             /*  Initialize the calendar  */
//             var today = new Date($.now());

//             var externalEventContainerEl = document.getElementById('external-events');

//             // init dragable
//             new Draggable(externalEventContainerEl, {
//                 itemSelector: '.external-event',
//                 eventData: function (eventEl) {
//                     return {
//                         title: eventEl.innerText,
//                         className: $(eventEl).data('class')
//                     };
//                 }
//             });

//             var defaultEvents = [{
//                 title: 'Meeting with Mr. Shreyu',
//                 start: new Date($.now() + 158000000),
//                 end: new Date($.now() + 338000000),
//                 className: 'bg-warning'
//             },
//                 {
//                     title: 'Interview - Backend Engineer',
//                     start: today,
//                     end: today,
//                     className: 'bg-success'
//                 },
//                 {
//                     title: 'Phone Screen - Frontend Engineer',
//                     start: new Date($.now() + 168000000),
//                     className: 'bg-info'
//                 },
//                 {
//                     title: 'Buy Design Assets',
//                     start: new Date($.now() + 338000000),
//                     end: new Date($.now() + 338000000 * 1.2),
//                     className: 'bg-primary',
//                 }];

//             var $this = this;

//             // cal - init
//             $this.$calendarObj = new Calendar($this.$calendar[0], {
//                 plugins: [dayGridPlugin, bootstrapPlugin, interactionPlugin, listPlugin, timeGridPlugin],

//                 slotDuration: '00:15:00', /* If we want to split day time each 15minutes */
//                 slotMinTime: '08:00:00',
//                 slotMaxTime: '19:00:00',
//                 themeSystem: 'bootstrap',
//                 bootstrapFontAwesome: false,
//                 buttonText: {
//                     today: 'Today',
//                     month: 'Month',
//                     week: 'Week',
//                     day: 'Day',
//                     list: 'List',
//                     prev: 'Prev',
//                     next: 'Next'
//                 },
//                 initialView: 'dayGridMonth',
//                 handleWindowResize: true,
//                 height: $(window).height() - 200,
//                 headerToolbar: {
//                     left: 'prev,next today',
//                     center: 'title',
//                     right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
//                 },
//                 initialEvents: defaultEvents,
//                 editable: true,
//                 droppable: true, // this allows things to be dropped onto the calendar !!!
//                 // dayMaxEventRows: false, // allow "more" link when too many events
//                 selectable: true,
//                 dateClick: function (info) {
//                     $this.onSelect(info);
//                 },
//                 eventClick: function (info) {
//                     $this.onEventClick(info);
//                 }
//             });

//             $this.$calendarObj.render();

//             // on new event button click
//             $this.$btnNewEvent.on('click', function (e) {
//                 $this.onSelect({date: new Date(), allDay: true});
//             });

//             // save event
//             $this.$formEvent.on('submit', function (e) {
//                 e.preventDefault();
//                 var form = $this.$formEvent[0];

//                 // validation
//                 if (form.checkValidity()) {
//                     if ($this.$selectedEvent) {
//                         $this.$selectedEvent.setProp('title', $("#event-title").val());
//                         $this.$selectedEvent.setProp('classNames', [$("#event-category").val()]);
//                     } else {
//                         var eventData = {
//                             title: $("#event-title").val(),
//                             start: $this.$newEventData.date,
//                             allDay: $this.$newEventData.allDay,
//                             className: $("#event-category").val()
//                         }
//                         $this.$calendarObj.addEvent(eventData);
//                     }
//                     $this.$modal.hide();
//                 } else {
//                     e.stopPropagation();
//                     form.classList.add('was-validated');
//                 }
//             });

//             // delete event
//             $($this.$btnDeleteEvent.on('click', function (e) {
//                 if ($this.$selectedEvent) {
//                     $this.$selectedEvent.remove();
//                     $this.$selectedEvent = null;
//                     $this.$modal.hide();
//                 }
//             }));
//         },

//         //init CalendarApp
//         $.CalendarApp = new CalendarApp, $.CalendarApp.Constructor = CalendarApp

// }(window.jQuery),

//     //initializing CalendarApp
//     function ($) {
//         "use strict";
//         $.CalendarApp.init()
//     }(window.jQuery);
