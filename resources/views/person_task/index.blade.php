@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('css')
    @vite('node_modules/tippy.js/dist/tippy.css')
    @vite(['node_modules/spectrum-colorpicker2/dist/spectrum.min.css', 'node_modules/flatpickr/dist/flatpickr.min.css', 'node_modules/clockpicker/dist/bootstrap-clockpicker.min.css', 'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.css">
    <style>
        .person-task-card.is-needs-adjust {
            border: 1px solid #f0b429 !important;
            background: linear-gradient(180deg, #fff9ef 0%, #fff 42%) !important;
            box-shadow: none;
            padding-top: .85rem !important;
        }
        .person-task-needs-adjust-banner {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            margin: 0 0 .5rem;
            padding: .2rem .55rem;
            border-radius: .25rem;
            background: #f59e0b;
            color: #1f2937;
            font-weight: 700;
            font-size: .75rem;
            letter-spacing: .02em;
            line-height: 1.3;
        }
        .person-task-card.is-needs-adjust > h5 {
            margin-top: .15rem !important;
            margin-bottom: .25rem;
            font-size: .98rem;
            line-height: 1.35;
        }
        .person-task-card.is-needs-adjust > h5 a {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .person-task-card.is-needs-adjust > p:first-of-type {
            margin-bottom: .35rem;
            color: #6b7280;
            font-size: .8rem;
        }
        .person-task-meta {
            display: flex;
            flex-wrap: wrap;
            gap: .15rem .75rem;
            margin: 0 0 .55rem;
            font-size: .78rem;
            color: #4b5563;
        }
        .person-task-meta span {
            display: inline-flex;
            align-items: center;
            gap: .2rem;
        }
        .person-task-schedule {
            margin: 0 0 .55rem;
            padding: .45rem .55rem;
            border-radius: .35rem;
            background: #fff7ed;
            border: 1px solid #fed7aa;
            font-size: .78rem;
            line-height: 1.4;
        }
        .person-task-schedule .sched-row {
            display: flex;
            align-items: baseline;
            gap: .4rem;
            flex-wrap: wrap;
        }
        .person-task-schedule .sched-row + .sched-row {
            margin-top: .2rem;
        }
        .person-task-schedule .sched-label {
            flex: 0 0 auto;
            min-width: 3.2rem;
            color: #9a3412;
            font-weight: 600;
            font-size: .72rem;
        }
        .person-task-schedule .sched-orig {
            color: #9ca3af;
            text-decoration: line-through;
        }
        .person-task-schedule .sched-adj {
            color: #9a3412;
            font-weight: 700;
        }
        .person-task-adjust-notes {
            margin: 0 0 .55rem;
            padding: .5rem .6rem;
            border-radius: .35rem;
            background: #fff;
            border: 1px solid #fde68a;
            font-size: .8rem;
            line-height: 1.45;
            color: #7c2d12;
        }
        .person-task-adjust-notes .adjust-note-latest {
            font-size: .82rem;
        }
        .person-task-adjust-notes .adjust-note-label {
            display: block;
            margin-bottom: .15rem;
            font-size: .72rem;
            font-weight: 700;
            color: #b45309;
            letter-spacing: .02em;
        }
        .person-task-adjust-notes .adjust-note-body {
            color: #1f2937;
            white-space: pre-wrap;
            word-break: break-word;
        }
        .person-task-adjust-notes .adjust-note-history {
            margin-top: .45rem;
            padding-top: .4rem;
            border-top: 1px dashed #fde68a;
        }
        .person-task-adjust-notes .adjust-note-history summary {
            cursor: pointer;
            list-style: none;
            font-size: .72rem;
            color: #92400e;
            font-weight: 600;
            user-select: none;
        }
        .person-task-adjust-notes .adjust-note-history summary::-webkit-details-marker {
            display: none;
        }
        .person-task-adjust-notes .adjust-note-item {
            margin-top: .35rem;
            padding-left: .15rem;
            font-size: .75rem;
            color: #6b7280;
        }
        .person-task-adjust-notes .adjust-note-item strong {
            color: #92400e;
            font-weight: 600;
        }
        .person-task-card.is-needs-adjust .person-task-desc-card {
            margin-top: 0 !important;
            border-color: #f3e8d4;
        }
    </style>
@endsection

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', [
            'title' => $title,
            'subtitle' => '個人待辦',
        ])






        {{-- <div class="card">
            <div class="card-body">
                <div class="row justify-content-between">
                    <div class="col-md-10">
                        <form class="d-flex flex-wrap align-items-center" action="{{ route('person.task') }}" method="GET">
                            @csrf
                            <label for="inputPassword2" class="visually-hidden">Search</label>
                            <div class="me-3">
                                <input type="search" class="form-control my-1 my-md-0" id="inputPassword2"
                                    placeholder="專案名稱..." name="project_name" value="{{ request()->get('project_name') }}">
                            </div>
                            <label for="inputPassword2" class="visually-hidden">Search</label>
                            <label for="status-select" class="me-2">專案完成時間</label>
                            <div class="me-3">
                                <input type="date" name="startDate" id="start_date" class="form-control my-1 my-md-0"
                                    value="{{ request()->get('start_date') }}">
                            </div>
                            <div class="me-3">
                                <input type="date" name="endDate" id="endDate" class="form-control my-1 my-md-0"
                                    value="{{ request()->get('end_date') }}">
                            </div>
                            <label for="status-select" class="me-2">專案緊急度</label>
                            <div class="me-3">
                                <select class="form-control" data-toggle="select2" data-width="100%" name="check_status_id"
                                    onchange="this.form.submit()">
                                    <option value="" selected>請選擇</option>
                                </select>
                            </div>
                            <label for="status-select" class="me-2">專案派工人</label>
                            <div class="me-3">
                                <select class="form-control" data-toggle="select3" data-width="100%" name="check_status_id"
                                    onchange="this.form.submit()">
                                    <option value="" selected>請選擇</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success waves-effect waves-light me-1">搜尋</button>
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="row">
            <!-- Kanban Board Structure -->
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">已被指派，待確認
                            <span
                                class="badge bg-danger rounded-pill ms-auto">{{ $datas->where('status', 0)->count() }}</span>
                        </h4>
                        <p class="sub-header">已被指派，待確認的派工項目
                        </p>

                        <ul class="sortable-list tasklist list-unstyled" id="not-started">
                            @foreach ($datas->where('status', 0)->sortBy('seq') as $task)
                                <li id="task{{ $task->id }}" data-id="{{ $task->id }}"
                                    onclick="openTaskModal({{ $task->id }})">
                                    <span class="badge  text-danger float-end">
                                        @if (isset($task->task_data->priority))
                                            @if ($task->task_data->priority == 0)
                                                <span class="badge bg-danger p-1">緊急</span>
                                            @elseif($task->task_data->priority == 1)
                                                <span class="badge bg-primary p-1">高</span>
                                            @elseif($task->task_data->priority == 2)
                                                <span class="badge bg-warning p-1">中</span>
                                            @else
                                                <span class="badge bg-success p-1">低</span>
                                            @endif
                                        @endif
                                    </span>
                                    <h5 class="mt-0"><b><a href="javascript: void(0);" class="text-dark pr-3">
                                                @if (isset($task->context))
                                                    {{ $task->context }}
                                                @endif
                                            </a></b></h5>
                                    <p>
                                        @if (isset($task->task_data->project_data->user_data))
                                            {{ $task->task_data->project_data->user_data->name }}
                                        @endif
                                    </p>
                                    <div class="clearfix"></div>
                                    @if (isset($task->task_data->task_template_data))
                                        <p class="font-13 mt-1 mb-0"><i class="mdi mdi-tooltip"></i>派工項目：
                                            {{ $task->task_data->task_template_data->name }}
                                        </p>
                                    @endif
                                    <p class="font-13 mt-1 mb-0"><i class="mdi mdi-account  "></i>派工人：@if (isset($task->task_data->user_data))
                                            {{ $task->task_data->user_data->name }}
                                        @endif
                                    </p>
                                    <div class="col-12">
                                            <button type="button"
                                                class="btn btn-sm btn-outline-danger  waves-effect waves-light mt-1"
                                                style="width: 100%;" data-bs-container="#tooltip-container"
                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                @if (isset($task->task_data->estimated_end)) title="預計完成時間：{{ $task->task_data->estimated_end }}" @endif>
                                                <i class="mdi mdi-calendar"></i>
                                                @if (isset($task->task_data->estimated_end))
                                                    {{ $task->task_data->estimated_end }}
                                                @endif
                                            </button>
                                        </div>
                                    <div class="card mt-2">
                                        <div id="headingFive">
                                            <h5 class="position-relative btn btn-sm btn-white p-1" style="width: 100%;">
                                                <a class="custom-accordion-title text-reset collapsed d-block"
                                                    data-bs-toggle="collapse" href="#collapseFive{{ $task->id }}"
                                                    aria-expanded="false" aria-controls="collapseFive{{ $task->id }}"
                                                    onclick="event.stopPropagation();">
                                                    派工描述 <i class="mdi mdi-menu-down "></i>
                                                </a>
                                            </h5>
                                        </div>
                                        <div id="collapseFive{{ $task->id }}" class="collapse"
                                            aria-labelledby="headingFive" data-bs-parent="#custom-accordion-one">
                                            <div class="card">
                                                {{ $task->task_data->comments }}
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">已接收
                            <span
                                class="badge bg-danger rounded-pill ms-auto">{{ $datas->where('status', 1)->count() }}</span>
                        </h4>
                        <p class="sub-header">已接收但未執行的派工項目</p>

                        <ul class="sortable-list tasklist list-unstyled" id="in-progress">
                            @foreach ($datas->where('status', 1)->sortBy('seq') as $task)
                                <li id="task{{ $task->id }}" data-id="{{ $task->id }}"
                                    onclick="openTaskModal({{ $task->id }})">
                                    <span class="badge  text-danger float-end">
                                        @if (isset($task->task_data->priority))
                                            @if ($task->task_data->priority == 0)
                                                <span class="badge bg-danger p-1">緊急</span>
                                            @elseif($task->task_data->priority == 1)
                                                <span class="badge bg-primary p-1">高</span>
                                            @elseif($task->task_data->priority == 2)
                                                <span class="badge bg-warning p-1">中</span>
                                            @else
                                                <span class="badge bg-success p-1">低</span>
                                            @endif
                                        @endif
                                    </span>
                                    <h5 class="mt-0"><b><a href="javascript: void(0);" class="text-dark pr-3">
                                                @if (isset($task->context))
                                                    {{ $task->context }}
                                                @endif
                                            </a></b></h5>
                                    <p>
                                        @if (isset($task->task_data->project_data->user_data))
                                            {{ $task->task_data->project_data->user_data->name }}
                                        @endif
                                    </p>
                                    <div class="clearfix"></div>
                                    @if (isset($task->task_data->task_template_data))
                                        <p class="font-13 mt-1 mb-0"><i class="mdi mdi-tooltip"></i>派工項目：
                                            {{ $task->task_data->task_template_data->name }}
                                        </p>
                                    @endif
                                    <p class="font-13 mt-1 mb-0"><i class="mdi mdi-account  "></i>派工人：@if (isset($task->task_data->user_data))
                                            {{ $task->task_data->user_data->name }}
                                        @endif
                                    </p>
                                    <div class="col-12">
                                            <button type="button"
                                                class="btn btn-sm btn-outline-danger  waves-effect waves-light mt-1"
                                                style="width: 100%;" data-bs-container="#tooltip-container"
                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                @if (isset($task->task_data->estimated_end)) title="預計完成時間：{{ $task->task_data->estimated_end }}" @endif>
                                                <i class="mdi mdi-calendar"></i>
                                                @if (isset($task->task_data->estimated_end))
                                                    {{ $task->task_data->estimated_end }}
                                                @endif
                                            </button>
                                        </div>
                                    <div class="card mt-2">
                                        <div id="headingFive">
                                            <h5 class="position-relative btn btn-sm btn-white p-1" style="width: 100%;">
                                                <a class="custom-accordion-title text-reset collapsed d-block"
                                                    data-bs-toggle="collapse" href="#collapseFive{{ $task->id }}"
                                                    aria-expanded="false" aria-controls="collapseFive{{ $task->id }}"
                                                    onclick="event.stopPropagation();">
                                                    派工描述 <i class="mdi mdi-menu-down "></i>
                                                </a>
                                            </h5>
                                        </div>
                                        <div id="collapseFive{{ $task->id }}" class="collapse"
                                            aria-labelledby="headingFive" data-bs-parent="#custom-accordion-one">
                                            <div class="card">
                                                {{ $task->task_data->comments }}
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">執行中
                            <span
                                class="badge bg-danger rounded-pill ms-auto">{{ $datas->whereIn('status', [2, 7])->count() }}</span>
                        </h4>
                        <p class="sub-header">正執行中或需調整的派工項目</p>

                        <ul class="sortable-list tasklist list-unstyled" id="implement">
                            @foreach ($datas->whereIn('status', [2, 7])->sortBy('seq') as $task)
                                @php
                                    $isNeedsAdjust = (int) $task->status === 7;
                                    $origEnd = $task->task_data->estimated_end ?? null;
                                    $adjEnd = $task->task_data->adjusted_estimated_end ?? null;
                                    $origEndLabel = $origEnd ? \Carbon\Carbon::parse($origEnd)->format('Y-m-d H:i') : null;
                                    $adjEndLabel = $adjEnd ? \Carbon\Carbon::parse($adjEnd)->format('Y-m-d H:i') : null;
                                    $adjustments = ($task->task_data->estimated_end_adjustments ?? collect())->sortBy('id')->values();
                                    $latestAdj = $adjustments->last();
                                    $olderAdjustments = $adjustments->slice(0, max(0, $adjustments->count() - 1))->values();
                                    $templateName = $task->task_data->task_template_data->name ?? null;
                                    $contextTitle = trim((string) ($task->context ?? ''));
                                    $showTemplateMeta = $templateName && $templateName !== $contextTitle;
                                @endphp
                                <li id="task{{ $task->id }}" data-id="{{ $task->id }}"
                                    class="{{ $isNeedsAdjust ? 'person-task-card is-needs-adjust' : '' }}"
                                    onclick="openTaskModal({{ $task->id }})">
                                    @if ($isNeedsAdjust)
                                        <span class="person-task-needs-adjust-banner"><i class="mdi mdi-alert"></i>需調整</span>
                                    @else
                                        <span class="badge text-danger float-end">
                                            @if (isset($task->task_data->priority))
                                                @if ($task->task_data->priority == 0)
                                                    <span class="badge bg-danger p-1">緊急</span>
                                                @elseif($task->task_data->priority == 1)
                                                    <span class="badge bg-primary p-1">高</span>
                                                @elseif($task->task_data->priority == 2)
                                                    <span class="badge bg-warning p-1">中</span>
                                                @else
                                                    <span class="badge bg-success p-1">低</span>
                                                @endif
                                            @endif
                                        </span>
                                    @endif
                                    <h5 class="mt-0"><b><a href="javascript: void(0);" class="text-dark pr-3">
                                                @if ($contextTitle !== '')
                                                    {{ $contextTitle }}
                                                @elseif ($templateName)
                                                    {{ $templateName }}
                                                @endif
                                            </a></b></h5>
                                    <p>
                                        @if (isset($task->task_data->project_data->user_data))
                                            {{ $task->task_data->project_data->user_data->name }}
                                        @endif
                                    </p>
                                    <div class="clearfix"></div>

                                    @if ($isNeedsAdjust)
                                        <div class="person-task-meta">
                                            @if ($showTemplateMeta)
                                                <span><i class="mdi mdi-tooltip"></i>{{ $templateName }}</span>
                                            @endif
                                            @if (isset($task->task_data->user_data))
                                                <span><i class="mdi mdi-account"></i>{{ $task->task_data->user_data->name }}</span>
                                            @endif
                                        </div>

                                        @if ($origEndLabel || $adjEndLabel)
                                            <div class="person-task-schedule">
                                                @if ($origEndLabel)
                                                    <div class="sched-row">
                                                        <span class="sched-label">原表訂</span>
                                                        <span class="{{ $adjEndLabel ? 'sched-orig' : '' }}">{{ $origEndLabel }}</span>
                                                    </div>
                                                @endif
                                                @if ($adjEndLabel)
                                                    <div class="sched-row">
                                                        <span class="sched-label">調整後</span>
                                                        <span class="sched-adj">{{ $adjEndLabel }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif

                                        @if ($latestAdj)
                                            <div class="person-task-adjust-notes">
                                                <div class="adjust-note-latest">
                                                    <span class="adjust-note-label">第{{ $adjustments->count() }}次調整說明</span>
                                                    <div class="adjust-note-body">{{ trim((string) ($latestAdj->note ?? '')) !== '' ? $latestAdj->note : '（未填寫）' }}</div>
                                                </div>
                                                @if ($olderAdjustments->isNotEmpty())
                                                    <details class="adjust-note-history" onclick="event.stopPropagation();">
                                                        <summary>先前調整紀錄（{{ $olderAdjustments->count() }}）</summary>
                                                        @foreach ($olderAdjustments as $idx => $adj)
                                                            <div class="adjust-note-item">
                                                                <strong>第{{ $idx + 1 }}次</strong>
                                                                {{ trim((string) ($adj->note ?? '')) !== '' ? $adj->note : '（未填寫）' }}
                                                                @if (!empty($adj->adjusted_estimated_end))
                                                                    · {{ \Carbon\Carbon::parse($adj->adjusted_estimated_end)->format('Y-m-d H:i') }}
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </details>
                                                @endif
                                            </div>
                                        @endif
                                    @else
                                        @if (isset($task->task_data->task_template_data))
                                            <p class="font-13 mt-1 mb-0"><i class="mdi mdi-tooltip"></i>派工項目：
                                                {{ $task->task_data->task_template_data->name }}
                                            </p>
                                        @endif
                                        <p class="font-13 mt-1 mb-0"><i class="mdi mdi-account"></i>派工人：@if (isset($task->task_data->user_data))
                                                {{ $task->task_data->user_data->name }}
                                            @endif
                                        </p>
                                        <div class="col-12">
                                            <button type="button"
                                                class="btn btn-sm btn-outline-danger waves-effect waves-light mt-1"
                                                style="width: 100%;" data-bs-container="#tooltip-container"
                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                @if ($origEnd) title="預計完成時間：{{ $origEnd }}" @endif>
                                                <i class="mdi mdi-calendar"></i>
                                                @if ($origEnd)
                                                    {{ $origEnd }}
                                                @endif
                                            </button>
                                        </div>
                                    @endif

                                    <div class="card mt-2 person-task-desc-card">
                                        <div id="headingFive">
                                            <h5 class="position-relative btn btn-sm btn-white p-1" style="width: 100%;">
                                                <a class="custom-accordion-title text-reset collapsed d-block"
                                                    data-bs-toggle="collapse" href="#collapseFive{{ $task->id }}"
                                                    aria-expanded="false" aria-controls="collapseFive{{ $task->id }}"
                                                    onclick="event.stopPropagation();">
                                                    派工描述 <i class="mdi mdi-menu-down "></i>
                                                </a>
                                            </h5>
                                        </div>
                                        <div id="collapseFive{{ $task->id }}" class="collapse"
                                            aria-labelledby="headingFive" data-bs-parent="#custom-accordion-one">
                                            <div class="card">
                                                {{ $task->task_data->comments }}
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">確認中
                            <span
                                class="badge bg-danger rounded-pill ms-auto">{{ $datas->where('status', 8)->count() }}</span>
                        </h4>
                        <p class="sub-header">已執行完成，正在確認的派工項目</p>

                        <ul class="sortable-list tasklist list-unstyled" id="completed">
                            @foreach ($datas->where('status', 8)->sortBy('seq') as $task)
                                <li id="task{{ $task->id }}" data-id="{{ $task->id }}"
                                    onclick="openTaskModal({{ $task->id }})">
                                    <span class="badge  text-danger float-end">
                                        @if (isset($task->task_data->priority))
                                            @if ($task->task_data->priority == 0)
                                                <span class="badge bg-danger p-1">緊急</span>
                                            @elseif($task->task_data->priority == 1)
                                                <span class="badge bg-primary p-1">高</span>
                                            @elseif($task->task_data->priority == 2)
                                                <span class="badge bg-warning p-1">中</span>
                                            @else
                                                <span class="badge bg-success p-1">低</span>
                                            @endif
                                        @endif
                                    </span>
                                    <h5 class="mt-0"><b><a href="javascript: void(0);" class="text-dark pr-3">
                                                @if (isset($task->context))
                                                    {{ $task->context }}
                                                @endif
                                            </a></b></h5>
                                    <p>
                                        @if (isset($task->task_data->project_data->user_data))
                                            {{ $task->task_data->project_data->user_data->name }}
                                        @endif
                                    </p>
                                    <div class="clearfix"></div>
                                    @if (isset($task->task_data->task_template_data))
                                        <p class="font-13 mt-1 mb-0"><i class="mdi mdi-tooltip"></i>派工項目：
                                            {{ $task->task_data->task_template_data->name }}
                                        </p>
                                    @endif
                                    <p class="font-13 mt-1 mb-0"><i class="mdi mdi-account  "></i>派工人：@if (isset($task->task_data->user_data))
                                            {{ $task->task_data->user_data->name }}
                                        @endif
                                    </p>
                                    <div class="col-12">
                                            <button type="button"
                                                class="btn btn-sm btn-outline-danger  waves-effect waves-light mt-1"
                                                style="width: 100%;" data-bs-container="#tooltip-container"
                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                @if (isset($task->task_data->estimated_end)) title="預計完成時間：{{ $task->task_data->estimated_end }}" @endif>
                                                <i class="mdi mdi-calendar"></i>
                                                @if (isset($task->task_data->estimated_end))
                                                    {{ $task->task_data->estimated_end }}
                                                @endif
                                            </button>
                                        </div>
                                    <div class="card mt-2">
                                        <div id="headingFive">
                                            <h5 class="position-relative btn btn-sm btn-white p-1" style="width: 100%;">
                                                <a class="custom-accordion-title text-reset collapsed d-block"
                                                    data-bs-toggle="collapse" href="#collapseFive{{ $task->id }}"
                                                    aria-expanded="false" aria-controls="collapseFive{{ $task->id }}"
                                                    onclick="event.stopPropagation();">
                                                    派工描述 <i class="mdi mdi-menu-down "></i>
                                                </a>
                                            </h5>
                                        </div>
                                        <div id="collapseFive{{ $task->id }}" class="collapse"
                                            aria-labelledby="headingFive" data-bs-parent="#custom-accordion-one">
                                            <div class="card">
                                                {{ $task->task_data->comments }}
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

        </div>
        <!-- end row -->

        <div id="taskModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">派工詳情</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{-- <div class="mb-3">
                            <label for="taskContent" class="form-label">派工描述</label>
                            <input name="taskComments" id="taskComments" class="form-control" disabled></textarea>
                        </div> --}}


                        <form id="taskForm">
                            <div class="mb-3">
                                <label for="taskStatus" class="form-label">變更狀態</label>
                                <select id="taskStatus" class="form-select" onchange="handleStatusChange(this.value)">
                                    <option value="not-started">已被指派，待確認</option>
                                    <option value="in-progress">已接收</option>
                                    <option value="implement">執行中</option>
                                    <option value="completed">已完成</option>
                                </select>
                            </div>

                            <div class="mb-3" id="completionFields" style="display: none;">
                                <label class="form-label">實際完成日期：<span class="text-danger">*</span></label>
                                <div id="executor-container">
                                    <div class="input-group mb-2">
                                        <input type="date" class="form-control" id="end_date" placeholder="日期"
                                            required>
                                        <input type="time" class="form-control" id="end_time" placeholder="時間"
                                            required>
                                    </div>
                                </div>
                                <label for="executionTime" class="form-label">執行時間 (小時)</label>
                                <input type="text" id="executionTime" class="form-control">
                            </div>
                            <div class="mb-3" id="adjustmentInfoBox" style="display: none;">
                                <label class="form-label text-warning-emphasis">調整說明</label>
                                <div id="adjustmentNotesList" class="border rounded p-2 bg-light small"></div>
                                <div class="form-text mt-1" id="originalScheduleRef"></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">派工項目</label>
                                <textarea class="form-control" id="taskContext" rows="3" readonly></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">派工描述</label>
                                <textarea class="form-control" id="taskComments" name="taskComments" rows="4" readonly></textarea>
                            </div>
                            <button type="button" class="btn btn-primary" onclick="updateTaskStatus()">保存</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div> <!-- container -->
@endsection

@section('script')
    @vite(['resources/js/pages/kanban.init.js'])
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.feather && typeof window.feather.replace === 'function') {
                window.feather.replace();
            }
        });

        let currentTaskId = null;
        let pendingCompletedDrag = false;

        function setCompletionFieldsVisible(status) {
            const completionFields = document.getElementById('completionFields');
            if (!completionFields) {
                return;
            }
            const show = status === 'completed';
            completionFields.style.display = show ? 'block' : 'none';
            if (show) {
                const endDate = document.getElementById('end_date');
                const endTime = document.getElementById('end_time');
                if (endDate && !endDate.value) {
                    const now = new Date();
                    const y = now.getFullYear();
                    const m = String(now.getMonth() + 1).padStart(2, '0');
                    const d = String(now.getDate()).padStart(2, '0');
                    endDate.value = `${y}-${m}-${d}`;
                }
                if (endTime && !endTime.value) {
                    const now = new Date();
                    const hh = String(now.getHours()).padStart(2, '0');
                    const mm = String(now.getMinutes()).padStart(2, '0');
                    endTime.value = `${hh}:${mm}`;
                }
            }
        }

        function openTaskModal(taskId, options = {}) {
            currentTaskId = taskId;
            pendingCompletedDrag = !!options.fromCompletedDrag;
            const forceCompleted = !!options.forceCompleted;
            const modalEl = document.getElementById('taskModal');
            const modal = bootstrap.Modal.getOrCreateInstance(modalEl);

            $.ajax({
                url: '/person/task/get-task-comments/' + taskId,
                type: 'GET',
                success: function(response) {
                    if (response.status === 'success') {
                        $('#taskContext').val(response.context || '查無資料');
                        $('#taskComments').val(response.comments || '查無資料');
                    } else {
                        console.error('未找到任務資料');
                    }
                }
            });

            fetch(`/person/task/edit/${taskId}`)
                .then(response => response.json())
                .then(data => {
                    const statusMap = {
                        0: 'not-started',
                        1: 'in-progress',
                        2: 'implement',
                        7: 'implement',
                        8: 'completed',
                        9: 'completed'
                    };
                    const statusValue = forceCompleted
                        ? 'completed'
                        : (statusMap[data.status] || 'not-started');
                    document.getElementById('taskStatus').value = statusValue;
                    document.getElementById('end_date').value = data.end_date || '';
                    document.getElementById('end_time').value = data.end_time || '';
                    document.getElementById('executionTime').value = data.execution_time || '';
                    setCompletionFieldsVisible(statusValue);

                    const adjustBox = document.getElementById('adjustmentInfoBox');
                    const notesList = document.getElementById('adjustmentNotesList');
                    const scheduleRef = document.getElementById('originalScheduleRef');
                    const adjustments = Array.isArray(data.adjustments) ? data.adjustments : [];
                    if (adjustBox && notesList) {
                        if (adjustments.length > 0 || Number(data.status) === 7) {
                            adjustBox.style.display = 'block';
                            notesList.innerHTML = adjustments.length
                                ? adjustments.map(function(row) {
                                    const note = row.note ? row.note : '（未填寫）';
                                    const due = row.adjusted_estimated_end ? `<div class="text-muted">期限：${row.adjusted_estimated_end}</div>` : '';
                                    return `<div class="mb-2"><strong>第${row.times}次調整說明：</strong>${note}${due}</div>`;
                                }).join('')
                                : '<div class="text-muted">尚無調整說明</div>';
                            if (scheduleRef) {
                                scheduleRef.textContent = data.estimated_end
                                    ? ('參考原派工表訂完成：' + data.estimated_end)
                                    : '';
                            }
                        } else {
                            adjustBox.style.display = 'none';
                            notesList.innerHTML = '';
                            if (scheduleRef) scheduleRef.textContent = '';
                        }
                    }
                })
                .catch(function() {
                    if (forceCompleted) {
                        document.getElementById('taskStatus').value = 'completed';
                        setCompletionFieldsVisible('completed');
                    }
                });

            modal.show();
        }

        function handleStatusChange(status) {
            setCompletionFieldsVisible(status);
        }

        function updateTaskStatus() {
            const status = document.getElementById('taskStatus').value;
            const endDate = document.getElementById('end_date').value;
            const endTime = document.getElementById('end_time').value;
            const executionTime = document.getElementById('executionTime').value;

            if (status === 'completed' && (!endDate || !endTime)) {
                alert('狀態為「已完成」時，請填寫實際完成日期與時間。');
                return;
            }

            fetch(`/tasks/${currentTaskId}/update-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    status: status,
                    end_date: endDate,
                    end_time: endTime,
                    execution_time: executionTime
                })
            }).then(response => {
                if (response.ok) {
                    pendingCompletedDrag = false;
                    location.reload();
                } else {
                    alert('更新狀態失敗！');
                }
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            const taskModalEl = document.getElementById('taskModal');
            if (taskModalEl) {
                taskModalEl.addEventListener('hidden.bs.modal', function() {
                    // 拖曳到已完成但未保存：還原列表
                    if (pendingCompletedDrag) {
                        pendingCompletedDrag = false;
                        location.reload();
                    }
                });
            }

            const lists = document.querySelectorAll('.sortable-list');
            lists.forEach(list => {
                new Sortable(list, {
                    group: 'shared',
                    animation: 150,
                    onEnd: function(evt) {
                        const itemId = evt.item.dataset.id;
                        const newStatus = evt.to.id;
                        const fromStatus = evt.from.id;

                        if (fromStatus === newStatus) {
                            return;
                        }

                        const order = Array.from(evt.to.children).map((item, index) => ({
                            id: item.dataset.id,
                            seq: index + 1
                        }));

                        // 拖到「已完成」：先開 modal 填實際完成日期，確認後再存
                        if (newStatus === 'completed') {
                            openTaskModal(itemId, {
                                fromCompletedDrag: true,
                                forceCompleted: true
                            });
                            return;
                        }

                        fetch(`/tasks/${itemId}/update-status`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                status: newStatus,
                                order: order
                            })
                        }).then(response => {
                            if (!response.ok) {
                                alert('更新狀態失敗！');
                                location.reload();
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
