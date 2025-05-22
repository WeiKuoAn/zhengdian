@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('css')
    @vite('node_modules/tippy.js/dist/tippy.css')
    @vite(['node_modules/spectrum-colorpicker2/dist/spectrum.min.css', 'node_modules/flatpickr/dist/flatpickr.min.css', 'node_modules/clockpicker/dist/bootstrap-clockpicker.min.css', 'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.css">
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
                                        <p class="font-13 mt-1 mb-0"><i class="mdi mdi-tooltip"></i>任務項目：
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
                                                    任務項目描述 <i class="mdi mdi-menu-down "></i>
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
                                        <p class="font-13 mt-1 mb-0"><i class="mdi mdi-tooltip"></i>任務項目：
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
                                                    任務項目描述 <i class="mdi mdi-menu-down "></i>
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
                                class="badge bg-danger rounded-pill ms-auto">{{ $datas->where('status', 2)->count() }}</span>
                        </h4>
                        <p class="sub-header">正執行中的派工項目</p>

                        <ul class="sortable-list tasklist list-unstyled" id="implement">
                            @foreach ($datas->where('status', 2)->sortBy('seq') as $task)
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
                                        <p class="font-13 mt-1 mb-0"><i class="mdi mdi-tooltip"></i>任務項目：
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
                                                    任務項目描述 <i class="mdi mdi-menu-down "></i>
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
                                        <p class="font-13 mt-1 mb-0"><i class="mdi mdi-tooltip"></i>任務項目：
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
                                                    任務項目描述 <i class="mdi mdi-menu-down "></i>
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
                        <h5 class="modal-title">任務詳情</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{-- <div class="mb-3">
                            <label for="taskContent" class="form-label">任務項目描述</label>
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
                            <div class="mb-3">
                                <label class="form-label">任務項目描述</label>
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
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        let currentTaskId = null;

        function openTaskModal(taskId) {
            currentTaskId = taskId;
            console.log(taskId);
            const modal = new bootstrap.Modal(document.getElementById('taskModal'));

            //抓取特定資料
            $(document).ready(function() {
                taskId = taskId;
            })
            $.ajax({
                url: '/person/task/get-task-comments/' + taskId, // 請求後端 API 端點
                type: 'GET',
                success: function(response) {
                    if (response.status === 'success') {
                        if (response.comments === null) {
                            // 如果回傳的 comments 是 null，顯示查無資料
                            $('#taskComments').html('查無任務資料');
                        } else {
                            // 如果有資料，顯示任務描述
                            $('#taskComments').html(response.comments);
                        }
                    } else {
                        console.error('未找到任務資料');
                    }
                }
            });

            // Fetch task details and populate modal
            fetch(`/person/task/edit/${taskId}`)
                .then(response => response.json())
                .then(data => {
                    const statusMap = {
                        0: 'not-started',
                        1: 'in-progress',
                        2: 'implement',
                        8: 'completed'
                    };
                    conlose.log(data);
                    document.getElementById('taskStatus').value = statusMap[data.status] || 'not-started';
                    document.getElementById('end_date').value = data.end_date || '';
                    document.getElementById('end_time').value = data.end_time || '';
                    document.getElementById('executionTime').value = data.execution_time || '';
                    if (data.status === 9) { // 確保根據數字狀態進行判斷
                        document.getElementById('completionFields').style.display = 'block';
                    } else {
                        document.getElementById('completionFields').style.display = 'none';
                    }
                });


            modal.show();
        }



        function handleStatusChange(status) {
            const completionFields = document.getElementById('completionFields');
            if (status === 'completed') {
                completionFields.style.display = 'block';
            } else {
                completionFields.style.display = 'none';
            }
        }

        function updateTaskStatus() {
            const status = document.getElementById('taskStatus').value;
            const endDate = document.getElementById('end_date').value;
            const endTime = document.getElementById('end_time').value;
            const executionTime = document.getElementById('executionTime').value;

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
                    location.reload();
                } else {
                    alert('更新狀態失敗！');
                }
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            const lists = document.querySelectorAll('.sortable-list');
            lists.forEach(list => {
                new Sortable(list, {
                    group: 'shared',
                    animation: 150,
                    onEnd: function(evt) {
                        const itemId = evt.item.dataset.id; // 獲取拖動項目的 ID
                        const newStatus = evt.to.id; // 獲取目標列表的 ID

                        const order = Array.from(evt.to.children).map((item, index) => ({
                            id: item.dataset.id,
                            seq: index + 1
                        }));

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
                            if (response.ok) {
                                // 如果目標列表是 "completed"，彈出模態窗口
                                if (newStatus === 'completed') {
                                    openTaskModal(itemId); // 顯示模態窗口
                                }
                            } else {
                                alert('更新狀態失敗！');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
