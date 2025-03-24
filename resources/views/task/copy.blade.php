@extends('layouts.vertical', ['title' => 'CRM Customers'])
@section('css')
    @vite(['node_modules/spectrum-colorpicker2/dist/spectrum.min.css', 'node_modules/flatpickr/dist/flatpickr.min.css', 'node_modules/clockpicker/dist/bootstrap-clockpicker.min.css', 'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css'])
    @vite(['node_modules/selectize/dist/css/selectize.bootstrap3.css', 'node_modules/mohithg-switchery/dist/switchery.min.css', 'node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css', 'node_modules/select2/dist/css/select2.min.css', 'node_modules/multiselect/css/multi-select.css'])
@endsection
@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', [
            'title' => '複製派工',
            'subtitle' => '派工管理',
        ])

        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('task.copy.data', $data->id) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="mb-3">
                                    <label for="inputEmail3" class="col-4 col-xl-3 col-form-label">專案名稱：<span class="text-danger">*</span></label>
                                    <select class="form-control" data-toggle="select2" data-width="100%" name="project_id">
                                        <option value="" selected>請選擇</option>
                                        @foreach ($cust_projects as $key => $cust_project)
                                            <option value="{{ $cust_project->id }}"
                                                {{ $data->project_id == $cust_project->id ? 'selected' : '' }}>
                                                【{{ $cust_project->user_data->name }}】{{ $cust_project->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">專案執行階段：<span class="text-danger">*</span></label>
                                    <select class="form-control" data-toggle="select2" data-width="100%"
                                        name="check_status_id">
                                        <option value="" selected>請選擇</option>
                                        @foreach ($check_statuss as $key => $check_status)
                                            <optgroup label="{{ $check_status->name }}">
                                                @foreach ($check_status->check_childrens as $num => $check_children)
                                                    <option value="{{ $check_children->id }}"
                                                        {{ $data->check_status_id == $check_children->id ? 'selected' : '' }}>
                                                        {{ $check_children->name }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="project-priority" class="form-label">任務項目<span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" data-toggle="select" data-width="100%" name="template_id">
                                        @foreach ($task_templates as $key => $task_template)
                                            <option value="{{ $task_template->id }}"
                                                {{ $data->template_id == $task_template->id ? 'selected' : '' }}>
                                                {{ $task_template->name }}</option>
                                        @endforeach
                                        <option value="">無</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">負責執行人員：<span class="text-danger">*</span></label>
                                    <div id="executor-container">
                                        @foreach ($data->items as $item)
                                            <div class="input-group mb-2 executor-entry">
                                                <select class="form-control" data-toggle="select" data-width="100%"
                                                    name="user_ids[]" required>
                                                    @foreach ($users as $key => $user)
                                                        <option value="{{ $user->id }}"
                                                            {{ $item->user_id == $user->id ? 'selected' : '' }}>
                                                            {{ $user->name }}</option>
                                                    @endforeach
                                                    <option value="">無</option>
                                                </select>
                                                <input type="text" class="form-control" name="contexts[]"
                                                    placeholder="執行內容" value="{{ $item->context }}">
                                                <button type="button" class="btn btn-danger remove-executor">-</button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" class="btn btn-link" id="add-executor">+ 新增更多人員或執行內容</button>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">預計完成日期：<span class="text-danger">*</span></label>
                                    <div class="input-group mb-2">
                                        <input type="date" class="form-control" id="end_date" placeholder="日期" required name="estimated_end_date" value="{{ substr($data->estimated_end, 0, 10) }}">
                                        <input type="time" class="form-control" id="end_time" placeholder="時間" required name="estimated_end_time" value="{{ substr($data->estimated_end, 11, 5) }}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="project-priority" class="form-label">優先序<span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" data-toggle="select" data-width="100%" name="priority">
                                        <option value="0" {{ $data->priority == 0 ? 'selected' : '' }}>緊急</option>
                                        <option value="1" {{ $data->priority == 1 ? 'selected' : '' }}>高</option>
                                        <option value="2" {{ $data->priority == 2 ? 'selected' : '' }}>中</option>
                                        <option value="3" {{ $data->priority == 3 ? 'selected' : '' }}>低</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">任務項目描述<span class="text-danger"></span></label>
                                    <textarea class="form-control" id="floatingTextarea" name="comments" rows="3">{{ $data->comments }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="project-priority" class="form-label">主要派工人<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="created_by" value="{{ Auth::user()->name }}"  readonly>
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
                                    class="fe-check-circle me-1"></i>複製派工</button>
                            <button type="reset" class="btn btn-secondary waves-effect waves-light m-1"
                                onclick="history.go(-1)"><i class="fe-x me-1"></i>回上一頁</button>
                        </div>
                    </div>
                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col-->
        <!-- end row -->

    </div> <!-- container -->
@endsection
@section('script')
    @vite(['resources/js/pages/form-pickers.init.js'])
    @vite(['resources/js/pages/form-advanced.init.js'])
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#add-executor').off('click').on('click', function() {
                var newRow = `
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
                $('#executor-container').append(newRow);
            });

            $(document).on('click', '.remove-executor', function() {
                if ($('.executor-entry').length > 1) {
                    $(this).closest('.executor-entry').remove();
                }
            });

            $('form').on('submit', function(event) {
                let timepickerValue = $('#24hours-timepicker').val().trim(); // 取得輸入值並去除空格

                if (timepickerValue === '') {
                    alert('請輸入預計完成時間！'); // 顯示警告
                    $('#24hours-timepicker').focus(); // 將焦點放到該輸入框
                    event.preventDefault(); // 阻止表單提交
                }
            });
        });

        $(document).ready(function() {
            // 當 check_status_id 改變時執行 AJAX 請求
            $('select[name="check_status_id"]').change(function() {
                let checkStatusId = $(this).val(); // 獲取選中的 check_status_id 值
                let templateSelect = $('select[name="template_id"]'); // 目標 template_id 的 <select>

                // 清空現有選項
                templateSelect.empty().append('<option value="">請選擇...</option>');

                // 若 check_status_id 為空，停止執行
                if (!checkStatusId) {
                    return;
                }

                // 發送 AJAX 請求
                $.ajax({
                    url: '/get-tasktemplate-id', // 請求的路由
                    method: 'GET',
                    data: {
                        check_status_id: checkStatusId
                    }, // 傳遞的參數
                    success: function(response) {
                        // 動態添加回傳的資料到 <select> 選單
                        response.forEach(function(item) {
                            templateSelect.append('<option value="' + item.id + '">' +
                                item.name + '</option>');
                        });
                    },
                    error: function() {
                        alert('無法加載資料，請稍後再試！');
                    }
                });
            });
        });
    </script>
@endsection
