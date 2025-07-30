@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', [
            'title' => $project->user_data->name . '專案管理',
            'subtitle' => '專案管理',
        ])

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start mb-3">
                            <div class="w-100 ">
                                <h3 class="mt-1 mb-0">{{ $project->name }}</h3>
                                <p class="mb-1 mt-1 text-muted">計畫登入帳號：ＸＸＸ　計畫登入密碼：ＸＸＸ</p>
                            </div>
                        </div>
                        <ul class="nav nav-tabs nav-bordered nav-justified">
                            <li class="nav-item">
                                <a href="{{ route('project.edit', $project->id) }}" aria-expanded="false"
                                    class="nav-link ">
                                    專案基本設定
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.task', $project->id) }}" aria-expanded="false" class="nav-link">
                                    派工作業
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.plan', $project->id) }}" aria-expanded="false"
                                    class="nav-link">
                                    排程作業
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.background', $project->id) }}" aria-expanded="false" class="nav-link ">
                                    專案背景調查
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.write', $project->id) }}" aria-expanded="false"
                                    class="nav-link">
                                    人事/帶動企業
                                </a>
                            </li>
                            @if($project->type == '3')
                            <li class="nav-item">
                                <a href="{{ route('project.sbir01', $project->id) }}" aria-expanded="false"
                                    class="nav-link active">
                                    SBIR內容撰寫
                                </a>
                            </li>
                            @endif
                            <li class="nav-item">
                                <a href="{{ route('project.send', $project->id) }}" aria-expanded="false" class="nav-link">
                                    送件作業
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.midterm', $project->id) }}" aria-expanded="false" class="nav-link">
                                    期中報告/檢核
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.final', $project->id) }}" aria-expanded="false" class="nav-link">
                                    期末報告/結案
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.accounting', $project->id) }}" aria-expanded="true" class="nav-link ">
                                    經費報表
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.meet', $project->id) }}" aria-expanded="false" class="nav-link">
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
                                            <h4 class="mt-3">儲存SBIR資料成功！</h4>
                                        </div>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
                    </div> <!-- end row-->
                </div>
                <!-- end row -->
            </div> <!-- end card-body -->
        </div> <!-- end card-->
        <!-- end row -->

        <div class="row">
            <form action="{{ route('project.sbir08.data', $project->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-12 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <!--選單-->
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir01', $project->id) }}" class="nav-link ">
                                                    壹、計畫書基本資料
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir02', $project->id) }}" class="nav-link ">
                                                    貳、計畫申請表
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir03', $project->id) }}" class="nav-link ">
                                                    參、計畫摘要表
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir04', $project->id) }}" class="nav-link ">
                                                    肆、公司概況
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir05', $project->id) }}" class="nav-link ">
                                                    伍、研發動機
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir06', $project->id) }}" class="nav-link ">
                                                    陸、計畫目標
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir07', $project->id) }}" class="nav-link">
                                                    柒、實施方式
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir08', $project->id) }}"
                                                    class="nav-link active">
                                                    捌、智財分析
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir09', $project->id) }}" class="nav-link">
                                                    玖、計畫執行查核點說明
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir10', $project->id) }}" class="nav-link">
                                                    拾、經費需求
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.appendix', $project->id) }}" class="nav-link">
                                                    拾壹、附件
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.supplement', $project->id) }}" class="nav-link">
                                                    拾貳、補充資料
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="card-body">
                                            <table class="table table-bordered" id="patentTable">
                                                <thead>
                                                    <tr>
                                                        <th>輸入查詢字串</th>
                                                        <th>檢索內容（專利之標題）</th>
                                                        <th>與本計畫研究之異同分析</th>
                                                        <th>操作</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (count($datas) > 0)
                                                        @foreach ($datas as $data)
                                                            <tr>
                                                                <td><input type="text" name="query[]"
                                                                        class="form-control" value="{{ $data->query }}">
                                                                </td>
                                                                <td><input type="text" name="search_result[]"
                                                                        class="form-control"
                                                                        value="{{ $data->search_result }}"></td>
                                                                <td>
                                                                    <textarea name="analysis[]" class="form-control" rows="2">{{ $data->analysis }}</textarea>
                                                                </td>
                                                                <td><button type="button" class="btn btn-danger"
                                                                        onclick="removePatentRow(this)">刪除</button></td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td><input type="text" name="query[]"
                                                                    class="form-control">
                                                            </td>
                                                            <td><input type="text" name="search_result[]"
                                                                    class="form-control"></td>
                                                            <td>
                                                                <textarea name="analysis[]" class="form-control" rows="2"></textarea>
                                                            </td>
                                                            <td><button type="button" class="btn btn-danger"
                                                                    onclick="removePatentRow(this)">刪除</button></td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>

                                            <div class="mb-3">
                                                <button type="button" class="btn btn-secondary"
                                                    onclick="addPatentRow()">新增一列</button>
                                            </div>
                                            <hr>
                                            <div class="d-flex justify-content-start gap-2">
                                                <button type="submit" class="btn btn-teal btn-success">送出存檔</button>
                                                <button type="button" class="btn btn-primary">回上一頁</button>
                                            </div>
                                            <!-- 匯出 Word 按鈕 -->
                                            <div class="text-end mt-4">
                                                <a href="{{ route('sbir08.export', $project->id) }}"
                                                    class="btn btn-success">
                                                    匯出計畫書 Word 檔
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </form>
        </div>

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
    <!-- TinyMCE + Modal 操作邏輯 -->
    <!--預設，誤動 -->
    <script src="https://cdn.jsdelivr.net/npm/tinymce@7/tinymce.min.js"></script>
    <script>
        const projectId = {{ $project->id }};
    </script>
    <script>
        // 新增一列
        function addPatentRow() {
            const tableBody = document.querySelector('#patentTable tbody');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td><input type="text" name="query[]" class="form-control"></td>
                <td><input type="text" name="search_result[]" class="form-control"></td>
                <td><textarea name="analysis[]" class="form-control" rows="2"></textarea></td>
                <td><button type="button" class="btn btn-danger" onclick="removePatentRow(this)">刪除</button></td>
            `;
            tableBody.appendChild(newRow);
        }

        // 刪除一列
        function removePatentRow(button) {
            button.closest('tr').remove();
        }
    </script>
@endsection
