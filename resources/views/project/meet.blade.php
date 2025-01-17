@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', ['title' => '設定管理', 'subtitle' => '簽約類別新增'])

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start mb-3">
                            <div class="w-100 ">
                                <h3 class="mt-1 mb-0">{{ $data->user_data->name }}【{{ $data->cust_data->name }}】</h5>
                                    <p class="mb-1 mt-1 text-muted">計畫登入帳號：ＸＸＸ　計畫登入密碼：ＸＸＸ</p>
                            </div>
                        </div>
                        <ul class="nav nav-tabs nav-bordered nav-justified">
                            <li class="nav-item">
                                <a href="{{ route('project.edit', $data->user_id) }}" aria-expanded="true" class="nav-link">
                                    專案基本設定
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.background', $data->user_id) }}" aria-expanded="false"
                                    class="nav-link ">
                                    專案背景調查
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.write', $data->user_id) }}" aria-expanded="false"
                                    class="nav-link">
                                    內容撰寫
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.send', $data->user_id) }}" aria-expanded="false"
                                    class="nav-link">
                                    送件作業
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.plan', $data->user_id) }}" aria-expanded="false"
                                    class="nav-link">
                                    排程作業
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.task', $data->user_id) }}" aria-expanded="false"
                                    class="nav-link">
                                    派工作業
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.midterm', $data->user_id) }}" aria-expanded="false"
                                    class="nav-link">
                                    期中報告/檢核
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.final', $data->user_id) }}" aria-expanded="false"
                                    class="nav-link">
                                    期末報告/結案
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.meet', $data->user_id) }}" aria-expanded="false"
                                    class="nav-link active">
                                    會議瀏覽
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- end row -->

                </div> <!-- end card-body -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap table-striped" id="products-datatable">
                                        <thead>
                                            <tr align="center">
                                                <th scope="col">No</th>
                                                <th scope="col">客戶名稱</th>
                                                <th scope="col">會議時間</th>
                                                <th scope="col">會議名稱</th>
                                                <th scope="col">地點</th>
                                                <th scope="col">錚典待辦</th>
                                                <th scope="col">客戶待辦</th>
                                                <th scope="col">NAS連結</th>
                                                <th scope="col" style="width: 200px;">操作</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col -->
                </div>
            </div> <!-- end card-->
            <!-- end row -->



        </div> <!-- container -->
    @endsection
