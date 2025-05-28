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
                                <a href="{{ route('project.edit', $data->id) }}" aria-expanded="false" class="nav-link ">
                                    專案基本設定
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.task', $data->id) }}" aria-expanded="false" class="nav-link">
                                    派工作業
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.plan', $data->id) }}" aria-expanded="false" class="nav-link">
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
                                    人事/帶動企業
                                </a>
                            </li>
                            @if ($data->type == '3')
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
                                <a href="{{ route('project.accounting', $data->id) }}" aria-expanded="true"
                                    class="nav-link active">
                                    經費報表
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.meet', $data->id) }}" aria-expanded="false" class="nav-link">
                                    會議瀏覽
                                </a>
                            </li>
                        </ul>

                        <div id="success-btn" class="modal fade" tabindex="-1" aria-labelledby="success-btnLabel"
                            aria-hidden="true" data-bs-scroll="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="text-center">
                                            <i class="bx bx-check-circle display-1 text-success"></i>
                                            <h4 class="mt-3">儲存商業類資料成功！</h4>
                                        </div>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
                    </div> <!-- end card-body -->
                </div> <!-- end card-->
                <!-- end row -->
            </div>
        </div>

        <form action="{{ route('project.write.data', $data->id) }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            處理中..
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div> <!-- container -->
@endsection
@section('script')
    @if (session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var successModal = new bootstrap.Modal(document.getElementById('success-btn'));
                successModal.show();
            });
        </script>
    @endif

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
