@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', ['title' => '設定管理', 'subtitle' => '簽約類別新增'])

        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('project.create.data') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="mb-3">
                                    <label class="form-label">專案起始日期<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="date" value="" required>
                                </div>
                                <div class="mb-3">
                                    <label for="project-priority" class="form-label">專案類型<span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" data-toggle="select" data-width="100%" name="type">
                                        <option value="up">商業服務業</option>
                                        <option value="down">製造業</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="project-priority" class="form-label">客戶名稱<span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" data-toggle="select" data-width="100%" name="user_id">
                                        <option value="" selected>請選擇</option>
                                        @foreach ($cust_datas as $key => $cust_data)
                                            <option value="{{ $cust_data->id }}">{{ $cust_data->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">計畫登入帳號<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="account" value="" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">計畫登入密碼<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="password" value="" required>
                                </div>
                                <div class="mb-3">
                                    <label for="project-priority" class="form-label">專案狀態<span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" data-toggle="select" data-width="100%" name="check_status">
                                        @foreach ($check_statuss as $key => $check_status)
                                            <option value="{{ $check_status->id }}">{{ $check_status->name }}</option>
                                        @endforeach
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