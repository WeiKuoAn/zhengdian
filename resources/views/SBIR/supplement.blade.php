@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('content')
    <style>
        textarea {
            white-space: pre-line !important;
            word-break: break-all !important;
            overflow-x: hidden !important;
            resize: vertical;
            /* 這行是關鍵，讓內容自動換行 */
            overflow-wrap: break-word !important;
        }

        /* th.table-light {
                        background-color: #eeeeeebe !important;
                    } */
    </style>
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
                                <a href="{{ route('project.edit', $project->id) }}" aria-expanded="false" class="nav-link ">
                                    專案基本設定
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.task', $project->id) }}" aria-expanded="false" class="nav-link">
                                    派工作業
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.plan', $project->id) }}" aria-expanded="false" class="nav-link">
                                    排程作業
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.background', $project->id) }}" aria-expanded="false"
                                    class="nav-link ">
                                    專案背景調查
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.write', $project->id) }}" aria-expanded="false" class="nav-link">
                                    人事/帶動企業
                                </a>
                            </li>
                            @if ($project->type == '3')
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
                                <a href="{{ route('project.midterm', $project->id) }}" aria-expanded="false"
                                    class="nav-link">
                                    期中報告/檢核
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.final', $project->id) }}" aria-expanded="false" class="nav-link">
                                    期末報告/結案
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.accounting', $project->id) }}" aria-expanded="true"
                                    class="nav-link ">
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
            <form action="{{ route('project.supplement.data', $project->id) }}" method="POST">
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
                                                <a href="{{ route('project.sbir04', $project->id) }}" class="nav-link">
                                                    肆、公司概況
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir05', $project->id) }}" class="nav-link">
                                                    伍、研發動機
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir06', $project->id) }}" class="nav-link">
                                                    陸、計畫目標
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir07', $project->id) }}" class="nav-link">
                                                    柒、實施方式
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir08', $project->id) }}" class="nav-link">
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
                                                <a href="{{ route('project.appendix', $project->id) }}"
                                                    class="nav-link ">
                                                    拾壹、附件
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.supplement', $project->id) }}"
                                                    class="nav-link active">
                                                    拾貳、補充資料
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="card-body mt-3">
                                            <div id="supplementTables">
                                                @if (count($datas) > 0)
                                                    @foreach ($datas as $data)
                                                        <table class="table table-bordered" id="patentTable">
                                                            <thead>
                                                                <tr align="center">
                                                                    <th class="table-light">日期</th>
                                                                    <th class="table-light">問題</th>
                                                                    <th class="table-light">備註</th>
                                                                    <th class="table-light">緊急度</th>
                                                                    <th class="table-light">確認無誤</th>
                                                                    <th class="table-light">操作</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody align="center">
                                                                <tr>
                                                                    <td>
                                                                        <input type="date" name="date[]"
                                                                            class="form-control"
                                                                            value="{{ $data->date ?? $now }}">
                                                                    </td>
                                                                    <td>
                                                                        <textarea name="question[]" class="form-control" rows="4">{{ $data->question }}</textarea>
                                                                    </td>
                                                                    <td>
                                                                        <textarea name="note[]" class="form-control" rows="4">{{ $data->note }}</textarea>
                                                                    </td>
                                                                    <td>
                                                                        <select name="is_urgent[]" class="form-select">
                                                                            <option value="1"
                                                                                {{ isset($data) && $data->is_urgent ? 'selected' : '' }}>
                                                                                緊急</option>
                                                                            <option value="0"
                                                                                {{ isset($data) && !$data->is_urgent ? 'selected' : '' }}>
                                                                                一般</option>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select name="is_confirmed[]" class="form-select">
                                                                            <option value="0"
                                                                                {{ isset($data) && !$data->is_confirmed ? 'selected' : '' }}>
                                                                                待確認</option>
                                                                            <option value="1"
                                                                                {{ isset($data) && $data->is_confirmed ? 'selected' : '' }}>
                                                                                已確認</option>
                                                                        </select>
                                                                    </td>

                                                                    <td>
                                                                        @if ($data->is_confirmed == 0)
                                                                            <button type="button" class="btn btn-danger"
                                                                                onclick="removePatentRow(this)">刪除</button>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th colspan="7" class="table-light">回復</th>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="7">
                                                                        <textarea name="answer[]" class="form-control" rows="4">{{ $data->answer }}</textarea>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    @endforeach
                                                @else
                                                    <table class="table table-bordered" id="patentTable">
                                                        <thead>
                                                            <tr align="center">
                                                                <th class="table-light">日期</th>
                                                                <th class="table-light">問題</th>
                                                                <th class="table-light">備註</th>
                                                                <th class="table-light">緊急度</th>
                                                                <th class="table-light">確認無誤</th>
                                                                <th class="table-light">操作</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody align="center">
                                                            <tr>
                                                                <td>
                                                                    <input type="date" name="date[]" class="form-control"
                                                                        value="{{ $data->date ?? $now }}">
                                                                </td>
                                                                <td>
                                                                    <textarea name="question[]" class="form-control" rows="4"></textarea>
                                                                </td>
                                                                <td>
                                                                    <textarea name="note[]" class="form-control" rows="4"></textarea>
                                                                </td>
                                                                <td>
                                                                    <select name="is_urgent[]" class="form-select">
                                                                        <option value="1">緊急</option>
                                                                        <option value="0">一般</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select name="is_confirmed[]" class="form-select">
                                                                        <option value="0">待確認</option>
                                                                        <option value="1">已確認</option>
                                                                    </select>
                                                                </td>

                                                                <td>
                                                                    <button type="button" class="btn btn-danger"
                                                                        onclick="removePatentRow(this)">刪除</button>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th colspan="7" class="table-light">回復</th>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="7">
                                                                    <textarea name="answer[]" class="form-control" rows="4"></textarea>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                @endif
                                            </div>

                                            <div class="mb-3">
                                                <button type="button" class="btn btn-secondary mb-2"
                                                    id="addRowBtn">新增一列</button>
                                            </div>
                                            <hr>
                                            <div class="d-flex justify-content-start gap-2">
                                                <button type="submit" class="btn btn-teal btn-success">送出存檔</button>
                                            </div>

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/js/twzipcode-1.4.1-min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // 新增一列
            $('#addRowBtn').click(function() {
                var today = new Date().toISOString().slice(0, 10);

                var newTable = `
                    <table class="table table-bordered" id="patentTable">
                        <thead>
                            <tr align="center">
                                <th class="table-light">日期</th>
                                <th class="table-light">問題</th>
                                <th class="table-light">備註</th>
                                <th class="table-light">緊急度</th>
                                <th class="table-light">確認無誤</th>
                                <th class="table-light">操作</th>
                            </tr>
                        </thead>
                        <tbody align="center">
                            <tr>
                                <td><input type="date" name="date[]" class="form-control" value="` + today + `"></td>
                                <td><textarea name="question[]" class="form-control" rows="4"></textarea></td>
                                <td><textarea name="note[]" class="form-control" rows="4"></textarea></td>
                                <td>
                                    <select name="is_urgent[]" class="form-select">
                                        <option value="1">緊急</option>
                                        <option value="0" selected>一般</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="is_confirmed[]" class="form-select">
                                        <option value="0" selected>待確認</option>
                                        <option value="1">已確認</option>
                                    </select>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger" onclick="removePatentTable(this)">刪除</button>
                                </td>
                            </tr>
                            <tr>
                                <th colspan="6" class="table-light">回復</th>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    <textarea name="answer[]" class="form-control" rows="4"></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                `;
                $('#supplementTables').append(newTable);
            });

            // 刪除一列（委派事件，支援動態新增的列）
            $('#patentTable').on('click', '.btn-danger', function() {
                $(this).closest('tr').remove();
            });
        });

        // 若你有原本的 removePatentRow function，可以直接移除或保留
        function removePatentRow(btn) {
            $(btn).closest('tr').remove();
        }

        // 新的刪除 function
        function removePatentTable(btn) {
            $(btn).closest('table').remove();
        }
    </script>
@endsection
