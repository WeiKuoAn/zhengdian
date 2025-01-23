@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', [
            'title' => $data->user_data->name . '專案管理',
            'subtitle' => '專案管理',
        ])

        <div class="row">
            <div class="col-xl-12">
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
                                <a href="{{ route('project.edit', $data->id) }}" aria-expanded="true" class="nav-link ">
                                    專案基本設定
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.task', $data->id) }}" aria-expanded="false" class="nav-link">
                                    派工作業
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.plan', $data->id) }}" aria-expanded="false"
                                    class="nav-link active">
                                    排程作業
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.background', $data->id) }}" aria-expanded="false"
                                    class="nav-link ">
                                    專案背景調查
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.write', $data->id) }}" aria-expanded="false" class="nav-link">
                                    內容撰寫
                                </a>
                            </li>
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
                                <a href="{{ route('project.meet', $data->id) }}" aria-expanded="false" class="nav-link">
                                    會議瀏覽
                                </a>
                            </li>
                        </ul>
                        <form action="{{ route('project.plan.data', $data->id) }}" method="POST">
                            @csrf
                            <div class="row mt-3">
                                <div class="mb-3">
                                    <label for="project-priority" class="form-label">排程日期<span
                                            class="text-danger">*</span></label>
                                    <div class="row">
                                        <div class="col-3 mb-1">
                                            <label for="project-priority" class="form-label">專案派工</label>
                                        </div>
                                        <div class="col-3 mb-1">
                                            <label for="project-priority" class="form-label">表訂時間</label>
                                        </div>
                                        <div class="col-3 mb-1">
                                            <label for="project-priority" class="form-label">預計完成時間</label>
                                        </div>
                                        <div class="col-3 mb-1">
                                            <label for="project-priority" class="form-label">實際完成時間</label>
                                        </div>
                                    </div>
                                    @foreach ($task_datas as $key => $task_data)
                                        <div class="row">
                                            <div class="col-3 mb-1">
                                                <input type="text" class="form-control" name=""
                                                    value="【{{ $task_data->check_status_data->name }}】{{ $task_data->name }}"
                                                    readonly>
                                                <input type="hidden" class="form-control" name="milestone_types[]"
                                                    value="{{ $task_data->id }}">
                                            </div>
                                            <div class="col-3 mb-1">
                                                <input type="date" class="form-control" name="order_dates[]"
                                                    value="{{ $task_data->order_date }}" placeholder="預計時間">
                                            </div>
                                            <div class="col-3 mb-1">
                                                <input type="date" class="form-control" name="milestone_dates[]"
                                                    value="{{ $task_data->milestone_date }}" placeholder="預計時間">
                                            </div>
                                            <div class="col-3 mb-1">
                                                <input type="date" class="form-control" name="formal_dates[]"
                                                    value="{{ $task_data->formal_date }}" placeholder="正式時間">
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div> <!-- end col-->
                    </div> <!-- end col-->
                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                    class="fe-check-circle me-1"></i>儲存</button>
                            <button type="reset" class="btn btn-secondary waves-effect waves-light m-1"
                                onclick="history.go(-1)"><i class="fe-x me-1"></i>回上一頁</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            </form>
        </div> <!-- end card-body -->
    </div> <!-- end card-->
    <!-- end row -->

    </div> <!-- container -->
@endsection
