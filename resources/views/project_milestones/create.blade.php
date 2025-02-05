@extends('layouts.vertical', ['title' => 'CRM Customers'])
@section('css')
    @vite(['node_modules/spectrum-colorpicker2/dist/spectrum.min.css', 'node_modules/flatpickr/dist/flatpickr.min.css', 'node_modules/clockpicker/dist/bootstrap-clockpicker.min.css', 'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css'])
@endsection
@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', [
            'title' => '專案排程新增',
            'subtitle' => '排程管理',
        ])

        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('projectMilestones.create.data') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="mb-3">
                                    <label class="form-label">客戶名稱<span class="text-danger">*</span></label>
                                    <select class="form-control" data-toggle="select" data-width="100%" id="user_id"
                                        name="user_id">
                                        @foreach ($cust_datas as $key => $cust_data)
                                            <option value="{{ $cust_data->id }}">{{ $cust_data->name }}</option>
                                        @endforeach
                                        <option value="">無</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">專案/任務名稱：<span class="text-danger">*</span></label>
                                    <select class="form-control" data-toggle="select" data-width="100%" id="project_id"
                                        name="project_id">
                                        <option value="">無</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="project-priority" class="form-label">排程日期<span
                                            class="text-danger">*</span></label>
                                    <div class="row">
                                        <div class="col-4 mb-1">
                                            <label for="project-priority" class="form-label">專案流程</label>
                                        </div>
                                        <div class="col-4 mb-1">
                                            <label for="project-priority" class="form-label">預計時間</label>
                                        </div>
                                        <div class="col-4 mb-1">
                                            <label for="project-priority" class="form-label">正式時間</label>
                                        </div>
                                    </div>
                                    @foreach ($check_statuss as $key => $check_status)
                                        <div class="row">
                                            <div class="col-4 mb-1">
                                                <input type="text" class="form-control" name="milestone_names[]"
                                                    value="{{ $check_status->name }}">
                                                <input type="hidden" class="form-control" name="milestone_types[]"
                                                    value="{{ $check_status->id }}">
                                            </div>
                                            <div class="col-4 mb-1">
                                                <input type="date" class="form-control" name="milestone_dates[]"
                                                    value="" placeholder="預計時間">
                                            </div>
                                            <div class="col-4 mb-1">
                                                <input type="date" class="form-control" name="formal_dates[]"
                                                    value="" placeholder="正式時間">
                                            </div>
                                        </div>
                                    @endforeach
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
        $(document).ready(function() {
            $('#user_id').on('change', function() {
                var userId = $(this).val();
                var projectSelect = $('#project_id');

                // 清空專案選單，並加入 "載入中" 選項
                projectSelect.html('<option value="">載入中...</option>');

                if (userId) {
                    $.ajax({
                        url: '/api/projects/' + userId,
                        type: 'GET',
                        success: function(data) {
                            // 清空後重新加入專案資料
                            projectSelect.empty();
                            if (data.length > 0) {
                                $.each(data, function(key, project) {
                                    projectSelect.append('<option value="' + project
                                        .id + '">' + project.name + '</option>');
                                });
                            } else {
                                projectSelect.append('<option value="">無專案</option>');
                            }
                        },
                        error: function() {
                            projectSelect.html('<option value="">載入失敗</option>');
                        }
                    });
                } else {
                    projectSelect.html('<option value="">無</option>');
                }
            });
        });
        $.ajaxSetup({
            headers: {
                'csrftoken': '{{ csrf_token() }}'
            }
        });
    </script>
@endsection
