@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('css')
    @vite(['node_modules/spectrum-colorpicker2/dist/spectrum.min.css', 'node_modules/flatpickr/dist/flatpickr.min.css', 'node_modules/clockpicker/dist/bootstrap-clockpicker.min.css', 'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css'])
    @vite(['node_modules/selectize/dist/css/selectize.bootstrap3.css', 'node_modules/mohithg-switchery/dist/switchery.min.css', 'node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css', 'node_modules/select2/dist/css/select2.min.css', 'node_modules/multiselect/css/multi-select.css'])
@endsection

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', [
            'title' => $data->user_data->name . '專案管理',
            'subtitle' => '專案管理',
        ])

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start mb-3">
                            <div class="w-100 ">
                                <h3 class="mt-1 mb-0">{{ $data->name }}</h3>
                                <p class="mb-1 mt-1 text-muted">計畫登入帳號：ＸＸＸ　計畫登入密碼：ＸＸＸ</p>
                            </div>
                        </div>
                        <ul class="nav nav-tabs nav-bordered nav-justified">
                            <li class="nav-item">
                                <a href="{{ route('project.edit', $data->id) }}" aria-expanded="true"
                                    class="nav-link">
                                    專案基本設定
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.task', $data->id) }}" aria-expanded="false" class="nav-link active">
                                    派工作業
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.plan', $data->id) }}" aria-expanded="false"
                                    class="nav-link">
                                    排程作業
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.background', $data->id) }}" aria-expanded="false" class="nav-link ">
                                    專案背景調查
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.write', $data->id) }}" aria-expanded="false"
                                    class="nav-link">
                                    人事/帶動企業
                                </a>
                            </li>
                            @if($data->type == '3')
                            <li class="nav-item">
                                <a href="{{ route('project.sbir01', $data->id) }}" aria-expanded="false"
                                    class="nav-link">
                                    SBIR內容撰寫
                                </a>
                            </li>
                            @endif
                            <li class="nav-item">
                                <a href="{{ route('project.send', $data->id) }}" aria-expanded="false" class="nav-link">
                                    送件作業
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.midterm', $data->id) }}" aria-expanded="false" class="nav-link">
                                    期中報告/檢核
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.final', $data->id) }}" aria-expanded="false" class="nav-link">
                                    期末報告/結案
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.accounting', $data->id) }}" aria-expanded="false" class="nav-link">
                                    經費報表
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.meet', $data->id) }}" aria-expanded="false" class="nav-link">
                                    會議瀏覽
                                </a>
                            </li>
                        </ul>
                    </div> <!-- end card-body-->

                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <button type="button" class="btn btn-danger waves-effect waves-light"
                                    data-bs-toggle="modal" data-bs-target="#addTaskModal">
                                    <i class="mdi mdi-plus-circle me-1"></i> 新增派工
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-centered  table-striped" id="products-datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">派工項目</th>
                                        <th scope="col">優先序</th>
                                        <th scope="col">負責執行人員</th>
                                        <th scope="col">派工進度</th>
                                        <th scope="col">預計完成時間</th>
                                        <th scope="col">派工主管</th>
                                        <th scope="col">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($task_datas as $key => $task_data)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                @if (isset($task_data->task_template_data))
                                                    {{ $task_data->task_template_data->name }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($task_data->priority == 0)
                                                    <span class="badge bg-danger p-1">緊急</span>
                                                @elseif($task_data->priority == 1)
                                                    <span class="badge bg-primary p-1">高</span>
                                                @elseif($task_data->priority == 2)
                                                    <span class="badge bg-warning p-1">中</span>
                                                @else
                                                    <span class="badge bg-success p-1">低</span>
                                                @endif
                                            </td>
                                            <td>
                                                @foreach ($task_data->items as $item)
                                                    <span class="badge bg-primary p-1 mb-1">{{ $item->user_data->name }}
                                                        @if (isset($item->context))
                                                            （{{ $item->context }}）
                                                        @endif
                                                    </span><br>
                                                @endforeach
                                            </td>
                                            <td>
                                                {{-- @if ($data->status == 0)
                                                    <span class="badge bg-primary p-1">進行中</span>
                                                @elseif($data->status == 1)
                                                    <span class="badge bg-success p-1">送出派工</span>
                                                @elseif($data->status == 2)
                                                    <span class="badge bg-success p-1">接收派工</span>
                                                @elseif($data->status == 3)
                                                    <span class="badge bg-success p-1">進行中</span>
                                                @elseif($data->status == 4)
                                                    <span class="badge bg-success p-1">移轉</span>
                                                @else
                                                    <span class="badge bg-danger p-1">完成</span>
                                                @endif --}}
                                                <div class="button-list" id="tooltip-container">
                                                    <button type="button" class="btn btn-white"
                                                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        title="@foreach ($task_data->items as $item) {{ $item->user_data->name }}（{{ $item->status() }}）、 @endforeach">
                                                        {{ $task_data->status() }}
                                                    </button>
                                                </div>
                                            </td>
                                            <td>{{ $task_data->estimated_end }}</td>
                                            <td>{{ $task_data->user_data->name }}</td>
                                            <td>
                                                @if (Auth::user()->id == $task_data->created_by)
                                                    <button type="button" class="btn btn-sm btn-primary"
                                                        onclick="openEditModal({{ $task_data->id }})">
                                                        <i class="mdi mdi-square-edit-outline"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        data-id="{{ $task_data->id }}" data-bs-toggle="modal"
                                                        data-bs-target="#deleteTaskModal">
                                                        <i class="mdi mdi-trash-can-outline"></i>
                                                    </button>
                                                @endif
                                                <button type="button" class="btn btn-sm btn-secondary "
                                                    onclick="openCopyModal({{ $task_data->id }})">
                                                    <i class="mdi mdi-content-copy"></i>
                                                </button>
                                            </td>


                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->

    </div> <!-- container -->

    <!-- Add Task Modal -->
    <div id="addTaskModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">新增派工</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('project.task.data', $data->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="mb-3">
                                <label for="inputEmail3" class="col-4 col-xl-3 col-form-label">專案名稱：</label>
                                <select class="form-control" data-toggle="select" data-width="100%" name="project_id"
                                    disabled>
                                    <option value="">請選擇</option>
                                    @foreach ($cust_projects as $key => $cust_project)
                                        <option value="{{ $cust_project->id }}"
                                            @if ($data->id == $cust_project->id) selected @endif>
                                            【{{ $cust_project->user_data->name }}】{{ $cust_project->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">專案執行階段：<span class="text-danger">*</span></label>
                                <select class="form-control" data-toggle="select2" data-width="100%"
                                    name="check_status_id" required>
                                    <option value="" selected>請選擇</option>
                                    @foreach ($check_statuss as $key => $check_status)
                                        <optgroup label="{{ $check_status->name }}">
                                            @foreach ($check_status->check_childrens as $num => $check_children)
                                                <option value="{{ $check_children->id }}">{{ $check_children->name }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="project-priority" class="form-label">任務項目<span
                                        class="text-danger">*</span></label>
                                <select class="form-control" data-toggle="select" data-width="100%" name="template_id"
                                    required>
                                    <option value="">請選擇...</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">負責執行人員：<span class="text-danger">*</span></label>
                                <div class="executor-container">
                                    <div class="input-group mb-2 executor-entry">
                                        <select class="form-control" data-toggle="select" data-width="100%"
                                            name="user_ids[]" required>
                                            @foreach ($users as $key => $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                            <option value="">無</option>
                                        </select>
                                        <input type="text" class="form-control" name="contexts[]" placeholder="執行內容">
                                        <button type="button" class="btn btn-danger remove-executor">-</button>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-link add-executor">+ 新增更多人員或執行內容</button>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">預計完成日期：<span class="text-danger">*</span></label>
                                <div id="executor-container">
                                    <div class="input-group mb-2">
                                        <input type="date" class="form-control" name="estimated_end_date"
                                            placeholder="執行內容" required>
                                        <input type="time" name="estimated_end_time" class="form-control"
                                            placeholder="時：分" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="project-priority" class="form-label">優先序<span
                                        class="text-danger">*</span></label>
                                <select class="form-control" data-toggle="select" data-width="100%" name="priority">
                                    <option value="0">緊急</option>
                                    <option value="1">高</option>
                                    <option value="2">中</option>
                                    <option value="3">低</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">任務項目描述<span class="text-danger"></span></label>
                                <textarea class="form-control" id="floatingTextarea" name="comments" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="project-priority" class="form-label">狀態<span
                                        class="text-danger">*</span></label>
                                <select class="form-control" data-toggle="select" data-width="100%" name="status">
                                    <option value="1">送出派工</option>
                                    <option value="2">接收派工</option>
                                    <option value="3">進行中</option>
                                    <option value="4">移轉</option>
                                    <option value="8">人員已完成，待確認</option>
                                    <option value="9">完成</option>
                                </select>
                            </div>
                        </div> <!-- end col-->
                </div>
                <!-- end row -->
                <div class="row mb-3">
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                class="fe-check-circle me-1"></i>新增</button>
                        <button type="reset" class="btn btn-secondary waves-effect waves-light m-1"
                            onclick="history.go(-1)"><i class="fe-x me-1"></i>回上一頁</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Task Modal -->
    <div id="editTaskModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">編輯派工</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editTaskForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="editTaskId" name="task_id">
                        <input type="hidden" id="editProjectId" name="project_id">
                        <div class="row">
                            <div class="mb-3">
                                <label for="editCheckStatusId" class="form-label">專案執行階段：</label>
                                <select class="form-control" id="editCheckStatusId" name="check_status_id" required>
                                    <option value="" selected>請選擇</option>
                                    @foreach ($check_statuss as $check_status)
                                        <optgroup label="{{ $check_status->name }}">
                                            @foreach ($check_status->check_childrens as $check_children)
                                                <option value="{{ $check_children->id }}">{{ $check_children->name }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editTemplateId" class="form-label">任務項目：</label>
                                <select class="form-control" id="editTemplateId" name="template_id" required>
                                    <option value="">請選擇...</option>
                                    @foreach ($task_templates as $task_template)
                                        <option value="{{ $task_template->id }}">{{ $task_template->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">負責執行人員：</label>
                                <div id="editExecutorContainer">
                                    <div class="executor-container">
                                        <!-- 動態填充執行人員數據 -->
                                    </div>
                                </div>
                                <button type="button" class="btn btn-link add-executor">+ 新增更多人員或執行內容</button>

                            </div>
                            <div class="mb-3">
                                <label for="editEstimatedEnd" class="form-label">預計完成日期：</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" id="editEstimatedEndDate"
                                        name="estimated_end_date" required>
                                    <input type="time" class="form-control" id="editEstimatedEndTime"
                                        name="estimated_end_time" required>

                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="editPriority" class="form-label">優先序：</label>
                                <select class="form-control" id="editPriority" name="priority">
                                    <option value="0">緊急</option>
                                    <option value="1">高</option>
                                    <option value="2">中</option>
                                    <option value="3">低</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editComments" class="form-label">任務項目描述：</label>
                                <textarea class="form-control" id="editComments" name="comments" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="editStatus" class="form-label">狀態：</label>
                                <select class="form-control" id="editStatus" name="status">
                                    <option value="1">送出派工</option>
                                    <option value="2">接收派工</option>
                                    <option value="3">進行中</option>
                                    <option value="4">移轉</option>
                                    <option value="8">人員已完成，待確認</option>
                                    <option value="9">完成</option>
                                </select>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success">保存</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="copyTaskModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">複製派工</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="copyTaskForm" method="POST">
                        @csrf
                        <input type="hidden" id="copyTaskId" name="task_id">
                        <input type="hidden" id="copyProjectId" name="project_id">
                        <div class="row">
                            <div class="mb-3">
                                <label for="copyCheckStatusId" class="form-label">專案執行階段：</label>
                                <select class="form-control" id="copyCheckStatusId" name="check_status_id" required>
                                    <option value="" selected>請選擇</option>
                                    @foreach ($check_statuss as $check_status)
                                        <optgroup label="{{ $check_status->name }}">
                                            @foreach ($check_status->check_childrens as $check_children)
                                                <option value="{{ $check_children->id }}">{{ $check_children->name }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="copyTemplateId" class="form-label">任務項目：</label>
                                <select class="form-control" id="copyTemplateId" name="template_id" required>
                                    <option value="">請選擇...</option>
                                    @foreach ($task_templates as $task_template)
                                        <option value="{{ $task_template->id }}">{{ $task_template->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">負責執行人員：</label>
                                <div id="copyExecutorContainer">
                                    <div class="executor-container">
                                        <!-- 動態填充執行人員數據 -->
                                    </div>
                                </div>
                                <button type="button" class="btn btn-link add-executor">+ 新增更多人員或執行內容</button>

                            </div>
                            <div class="mb-3">
                                <label for="copyEstimatedEnd" class="form-label">預計完成日期：</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" id="copyEstimatedEndDate"
                                        name="estimated_end_date" required>
                                    <input type="time" class="form-control" id="copyEstimatedEndTime"
                                        name="estimated_end_time" required>

                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="copyPriority" class="form-label">優先序：</label>
                                <select class="form-control" id="copyPriority" name="priority">
                                    <option value="0">緊急</option>
                                    <option value="1">高</option>
                                    <option value="2">中</option>
                                    <option value="3">低</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="copyComments" class="form-label">任務項目描述：</label>
                                <textarea class="form-control" id="copyComments" name="comments" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="copyStatus" class="form-label">狀態：</label>
                                <select class="form-control" id="copyStatus" name="status">
                                    <option value="1">送出派工</option>
                                    <option value="2">接收派工</option>
                                    <option value="3">進行中</option>
                                    <option value="4">移轉</option>
                                    <option value="8">人員已完成，待確認</option>
                                    <option value="9">完成</option>
                                </select>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success">保存</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="deleteTaskModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">確認刪除</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>您確定要刪除此派工嗎？此操作無法恢復。</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                    <form id="deleteTaskForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">刪除</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    </div>
@endsection
@section('script')
    @vite(['resources/js/pages/form-pickers.init.js'])
    @vite(['resources/js/pages/form-advanced.init.js'])
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editModal = new bootstrap.Modal(document.getElementById('editTaskModal'));

            window.openEditModal = function(taskId) {
                // 發送請求獲取任務詳情
                fetch(`/api/task/${taskId}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log('獲取任務數據成功:', data);
                        // 填充表單數據
                        document.getElementById('editTaskId').value = data.id;
                        document.getElementById('editProjectId').value = data.project_id;
                        document.getElementById('editCheckStatusId').value = data.check_status_id;
                        document.getElementById('editTemplateId').value = data.template_id;
                        document.getElementById('editEstimatedEndDate').value = data.estimated_end_date;
                        document.getElementById('editEstimatedEndTime').value = data.estimated_end_time;
                        document.getElementById('editPriority').value = data.priority;
                        document.getElementById('editComments').value = data.comments;
                        document.getElementById('editStatus').value = data.status;

                        // 動態生成執行人員列表
                        const executorContainer = document.getElementById('editExecutorContainer');
                        executorContainer.innerHTML = '';
                        data.items.forEach(item => {
                            executorContainer.innerHTML += `
                        <div class="input-group mb-2 executor-entry">
                            <select class="form-control" name="user_ids[]" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" ${item.user_id == {{ $user->id }} ? 'selected' : ''}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="text" class="form-control" name="contexts[]" value="${item.context}" placeholder="執行內容">
                            <button type="button" class="btn btn-danger remove-executor">-</button>
                        </div>
                       
                    `;
                        });
                        executorContainer.innerHTML += `<div class="executor-container"> </div>`

                        // 設置表單的動作 URL
                        const editForm = document.getElementById('editTaskForm');
                        editForm.action = `/project/task/update/${taskId}`;

                        // 顯示模態框
                        editModal.show();
                    })
                    .catch(error => {
                        console.error('獲取任務數據失敗:', error);
                        alert('無法加載數據，請稍後再試！');
                    });
            };
        });

        document.addEventListener('DOMContentLoaded', function() {
            const copyModal = new bootstrap.Modal(document.getElementById('copyTaskModal'));

            window.openCopyModal = function(taskId) {
                // 發送請求獲取任務詳情
                fetch(`/api/task/${taskId}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log('獲取任務數據成功:', data);
                        // 填充表單數據
                        document.getElementById('copyTaskId').value = data.id;
                        document.getElementById('copyProjectId').value = data.project_id;
                        document.getElementById('copyCheckStatusId').value = data.check_status_id;
                        document.getElementById('copyTemplateId').value = data.template_id;
                        document.getElementById('copyEstimatedEndDate').value = data.estimated_end_date;
                        document.getElementById('copyEstimatedEndTime').value = data.estimated_end_time;
                        document.getElementById('copyPriority').value = data.priority;
                        document.getElementById('copyComments').value = data.comments;
                        document.getElementById('copyStatus').value = data.status;

                        // 動態生成執行人員列表
                        const executorContainer = document.getElementById('copyExecutorContainer');
                        executorContainer.innerHTML = '';
                        data.items.forEach(item => {
                            executorContainer.innerHTML += `
                        <div class="input-group mb-2 executor-entry">
                            <select class="form-control" name="user_ids[]" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" ${item.user_id == {{ $user->id }} ? 'selected' : ''}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="text" class="form-control" name="contexts[]" value="${item.context}" placeholder="執行內容">
                            <button type="button" class="btn btn-danger remove-executor">-</button>
                        </div>
                       
                    `;
                        });
                        executorContainer.innerHTML += `<div class="executor-container"> </div>`

                        // 設置表單的動作 URL
                        const copyForm = document.getElementById('copyTaskForm');
                        copyForm.action = "{{ route('project.task.data', $data->id) }}";

                        // 顯示模態框
                        copyModal.show();
                    })
                    .catch(error => {
                        console.error('獲取任務數據失敗:', error);
                        alert('無法加載數據，請稍後再試！');
                    });
            };
        });


        $(document).ready(function() {
            // 綁定新增執行人員按鈕
            $(document).on('click', '.add-executor', function() {
                const newRow = `
            <div class="input-group mb-2 executor-entry">
                <select class="form-control" data-toggle="select" data-width="100%" name="user_ids[]" required>
                    @foreach ($users as $key => $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                    <option value="">無</option>
                </select>
                <input type="text" class="form-control" name="contexts[]" placeholder="執行內容">
                <button type="button" class="btn btn-danger remove-executor">-</button>
            </div>
        `;
                $('.executor-container').append(newRow);
            });

            // 綁定刪除執行人員按鈕
            $(document).on('click', '.remove-executor', function() {
                if ($('.executor-entry').length > 1) {
                    $(this).closest('.executor-entry').remove();
                } else {
                    alert('至少需要保留一個執行人員條目');
                }
            });

            $('form').on('submit', function(event) {
                const formId = $(this).attr('id');

                // 新增派工：檢查 24hours-timepicker（只有 addTaskModal 才有這個 id）
                if (formId === undefined && $('#24hours-timepicker').length) {
                    const timepickerValue = $('#24hours-timepicker').val().trim();
                    if (timepickerValue === '') {
                        alert('請輸入預計完成時間！');
                        $('#24hours-timepicker').focus();
                        event.preventDefault();
                    }
                }

                // 複製派工：檢查 copyEstimatedEndDate 和 copyEstimatedEndTime
                if (formId === 'copyTaskForm') {
                    const date = $('#copyEstimatedEndDate').val().trim();
                    const time = $('#copyEstimatedEndTime').val().trim();

                    if (date === '' || time === '') {
                        alert('請輸入完整的預計完成日期與時間！');
                        $('#copyEstimatedEndDate').focus();
                        event.preventDefault();
                    }
                }
            });


            // 專案執行階段變化時更新任務選項
            $('select[name="check_status_id"]').change(function() {
                const checkStatusId = $(this).val();
                const templateSelect = $('select[name="template_id"]');

                // 清空現有選項
                templateSelect.empty().append('<option value="">請選擇...</option>');

                if (!checkStatusId) return;

                $.ajax({
                    url: '/get-tasktemplate-id',
                    method: 'GET',
                    data: {
                        check_status_id: checkStatusId
                    },
                    success: function(response) {
                        response.forEach(function(item) {
                            templateSelect.append(
                                `<option value="${item.id}">${item.name}</option>`);
                        });
                    },
                    error: function() {
                        alert('無法加載資料，請稍後再試！');
                    },
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteTaskModal'));
            const deleteForm = document.getElementById('deleteTaskForm');

            document.querySelectorAll('.btn-danger[data-bs-target="#deleteTaskModal"]').forEach(button => {
                button.addEventListener('click', function() {
                    const taskId = this.dataset.id;
                    deleteForm.action = `/project/task/delete/${taskId}`;
                });
            });
        });
    </script>
@endsection
