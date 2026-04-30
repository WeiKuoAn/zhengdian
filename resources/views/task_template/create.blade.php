@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', [
            'title' => '專案狀態類別新增',
            'subtitle' => '專案狀態類別新增',
        ])

        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('TaskTemplate.create.data') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="mb-3">
                                    <label class="form-label">派工項目名稱<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" value="" required>
                                </div>
                                <div class="mb-3">
                                    <label for="project-priority" class="form-label">專案狀態<span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" id="check_status_parent_id" data-toggle="select"
                                        data-width="100%" name="check_status_parent_id">
                                        <option value="">無</option>
                                        @foreach ($check_status_parent_ids as $key => $check_status_parent_id)
                                            <option value="{{ $check_status_parent_id->id }}">{{ $check_status_parent_id->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="project-priority" class="form-label">專案階段<span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" id="check_status_id" data-toggle="select"
                                        data-width="100%" name="check_status_id">
                                        <option value="">無</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">描述</label>
                                    <input type="text" class="form-control" name="description" value="" >
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">執行時數</label>
                                    <input type="number" class="form-control" name="duration_hours" value="0"
                                        min="0" step="0.5">
                                    <div class="form-text">可自行輸入時數；排程作業會以 8 小時 = 1 天換算執行天數。</div>
                                </div>
                                <div class="mb-1">
                                    <label for="project-priority" class="form-label">狀態<span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" data-toggle="select" data-width="100%" name="status">
                                        <option value="up">上架</option>
                                        <option value="down">下架</option>
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

    <!-- JavaScript -->
    <script>
        $(document).ready(function () {
            // 當 check_status_parent_id 改變時執行 AJAX 請求
            $('#check_status_parent_id').change(function () {
                let parentId = $(this).val(); // 獲取選擇的值
                let childSelect = $('#check_status_id'); // 專案階段 select

                // 清空現有選項
                childSelect.empty().append('<option value="">無</option>');

                // 若 parentId 為空，停止執行
                if (!parentId) {
                    return;
                }

                // 發送 AJAX 請求
                $.ajax({
                    url: '/get-child-id',
                    method: 'GET',
                    data: { parent_id: parentId }, // 傳遞 parent_id 作為參數
                    success: function (response) {
                        // 將回傳資料新增到 select 元素
                        response.forEach(function (item) {
                            childSelect.append('<option value="' + item.id + '">' + item.name + '</option>');
                        });
                    },
                    error: function () {
                        alert('無法加載資料，請稍後再試！');
                    }
                });
            });
        });
    </script>
@endsection
