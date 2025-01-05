@extends('layouts.vertical', ['title' => 'CRM Customers'])
@section('css')
    @vite(['node_modules/spectrum-colorpicker2/dist/spectrum.min.css', 'node_modules/flatpickr/dist/flatpickr.min.css', 'node_modules/clockpicker/dist/bootstrap-clockpicker.min.css', 'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css'])
@endsection
@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', [
            'title' => '計畫狀態類別新增',
            'subtitle' => '計畫狀態類別新增',
        ])

        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('task.create.data') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="mb-3">
                                    <label class="form-label">專案/任務名稱：<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" value="" required>
                                </div>
                                <div class="mb-3">
                                    <label for="project-priority" class="form-label">任務類型<span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" data-toggle="select" data-width="100%" name="template_id">
                                        @foreach ($task_templates as $key => $task_template)
                                            <option value="{{ $task_template->id }}">{{ $task_template->name }}</option>
                                        @endforeach
                                        <option value="">無</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">專案執行階段：<span class="text-danger">*</span></label>
                                    <select class="form-control" data-toggle="select" data-width="100%" name="check_status_id">
                                        @foreach ($check_statuss as $key => $check_status)
                                            <option value="{{ $check_status->id }}">{{ $check_status->name }}</option>
                                        @endforeach
                                        <option value="">無</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">負責執行人員：<span class="text-danger">*</span></label>
                                    <div id="executor-container">
                                        <div class="input-group mb-2 executor-entry">
                                            <select class="form-control" data-toggle="select" data-width="100%" name="user_ids[]">
                                                @foreach ($users as $key => $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                                <option value="">無</option>
                                            </select>
                                            <input type="text" class="form-control" name="contexts[]" placeholder="執行內容" required>
                                            <button type="button" class="btn btn-danger remove-executor">-</button>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-link" id="add-executor">+ 新增更多人員或執行內容</button>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">預計完成日期：<span class="text-danger">*</span></label>
                                    <div id="executor-container">
                                        <div class="input-group mb-2">
                                            <input type="date" class="form-control" name="estimated_end_date" placeholder="執行內容" required>
                                            <input type="text" id="24hours-timepicker" name="estimated_end_time" class="form-control" placeholder="時：分" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="project-priority" class="form-label">優先序<span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" data-toggle="select" data-width="100%" name="priority">
                                        <option value="1">高</option>
                                        <option value="2">中</option>
                                        <option value="3">低</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">備註<span class="text-danger"></span></label>
                                    <textarea class="form-control" id="floatingTextarea" name="comments" rows="3"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="project-priority" class="form-label">狀態<span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" data-toggle="select" data-width="100%" name="status">
                                        <option value="0">待派工</option>
                                        <option value="1">送出派工</option>
                                        <option value="2">接收派工</option>
                                        <option value="3">進行中</option>
                                        <option value="4">移轉</option>
                                        <option value="5">完成</option>
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
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col-->
        <!-- end row -->

    </div> <!-- container -->
@endsection
@section('script')
@vite(['resources/js/pages/form-pickers.init.js'])
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // 避免多次綁定事件，先移除後綁定
        $('#add-executor').off('click').on('click', function () {
            var newRow = `
                <div class="input-group mb-2 executor-entry">
                    <select class="form-control" data-toggle="select" data-width="100%" name="user_ids[]">
                        @foreach ($users as $key => $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                        <option value="">無</option>
                    </select>
                    <input type="text" class="form-control" name="contexts[]" placeholder="執行內容" required>
                    <button type="button" class="btn btn-danger remove-executor">-</button>
                </div>
            `;
            $('#executor-container').append(newRow);
        });

        // 刪除執行人員列，確保最少保留一列
        $(document).on('click', '.remove-executor', function () {
            if ($('.executor-entry').length > 1) {
                $(this).closest('.executor-entry').remove();
            }
        });
    });
</script>
@endsection