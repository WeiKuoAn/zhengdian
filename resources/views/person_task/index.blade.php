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
            'title' => '【' . Auth::user()->name . '】' . '個人待辦',
            'subtitle' => '個人待辦',
        ])

        <div class="row">
            <!-- Kanban Board Structure -->
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">已被指派，待確認</h4>
                        <p class="sub-header">已被指派，待確認的派工項目</p>

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
                                    <h5 class="mt-0"><b><a href="javascript: void(0);" class="text-dark">
                                                @if (isset($task->task_data->task_template_data))
                                                    {{ $task->task_data->task_template_data->name }}
                                                @endif
                                            </a></b></h5>
                                    <p>
                                        @if (isset($task->task_data->project_data->user_data))
                                            {{ $task->task_data->project_data->user_data->name }}
                                        @endif
                                    </p>
                                    <div class="clearfix"></div>
                                    <p class="font-13 mt-2 mb-0"><i class="mdi mdi-calendar"></i>預計完成時間：@if (isset($task->task_data->estimated_end))
                                            {{ $task->task_data->estimated_end }}
                                        @endif
                                    </p>
                                    <p class="font-13 mt-2 mb-0"><i class="mdi mdi-account  "></i>派工人：@if (isset($task->task_data->user_data))
                                            {{ $task->task_data->user_data->name }}
                                        @endif
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">已接收</h4>
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
                                    <h5 class="mt-0"><b><a href="javascript: void(0);" class="text-dark">
                                                @if (isset($task->task_data->task_template_data))
                                                    {{ $task->task_data->task_template_data->name }}
                                                @endif
                                            </a></b></h5>
                                    <p>
                                        @if (isset($task->task_data->project_data->user_data))
                                            {{ $task->task_data->project_data->user_data->name }}
                                        @endif
                                    </p>
                                    <div class="clearfix"></div>
                                    <p class="font-13 mt-2 mb-0"><i class="mdi mdi-calendar"></i>預計完成時間：@if (isset($task->task_data->estimated_end))
                                            {{ $task->task_data->estimated_end }}
                                        @endif
                                    </p>
                                    <p class="font-13 mt-2 mb-0"><i class="mdi mdi-account  "></i>派工人：@if (isset($task->task_data->user_data))
                                            {{ $task->task_data->user_data->name }}
                                        @endif
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">執行中</h4>
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
                                    <h5 class="mt-0"><b><a href="javascript: void(0);" class="text-dark">
                                                @if (isset($task->task_data->task_template_data))
                                                    {{ $task->task_data->task_template_data->name }}
                                                @endif
                                            </a></b></h5>
                                    <p>
                                        @if (isset($task->task_data->project_data->user_data))
                                            {{ $task->task_data->project_data->user_data->name }}
                                        @endif
                                    </p>
                                    <div class="clearfix"></div>
                                    <p class="font-13 mt-2 mb-0"><i class="mdi mdi-calendar"></i>預計完成時間：@if (isset($task->task_data->estimated_end))
                                            {{ $task->task_data->estimated_end }}
                                        @endif
                                    </p>
                                    <p class="font-13 mt-2 mb-0"><i class="mdi mdi-account  "></i>派工人：@if (isset($task->task_data->user_data))
                                            {{ $task->task_data->user_data->name }}
                                        @endif
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">確認中</h4>
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
                                    <h5 class="mt-0"><b><a href="javascript: void(0);" class="text-dark">
                                                @if (isset($task->task_data->task_template_data))
                                                    {{ $task->task_data->task_template_data->name }}
                                                @endif
                                            </a></b></h5>
                                    <p>
                                        @if (isset($task->task_data->project_data->user_data))
                                            {{ $task->task_data->project_data->user_data->name }}
                                        @endif
                                    </p>
                                    <div class="clearfix"></div>
                                    <p class="font-13 mt-2 mb-0"><i class="mdi mdi-calendar"></i>預計完成時間：@if (isset($task->task_data->estimated_end))
                                            {{ $task->task_data->estimated_end }}
                                        @endif
                                    </p>
                                    <p class="font-13 mt-2 mb-0"><i class="mdi mdi-account  "></i>派工人：@if (isset($task->task_data->user_data))
                                            {{ $task->task_data->user_data->name }}
                                        @endif
                                    </p>
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
                                <label class="form-label">預計完成日期：<span class="text-danger">*</span></label>
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
            const modal = new bootstrap.Modal(document.getElementById('taskModal'));

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
