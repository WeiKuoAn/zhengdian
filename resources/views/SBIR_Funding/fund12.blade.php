@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('content')
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
                                <a href="{{ route('project.edit', $project->id) }}" aria-expanded="true" class="nav-link ">
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
                                <a href="{{ route('project.write', $project->id) }}" aria-expanded="false"
                                    class="nav-link active">
                                    SBIR內容撰寫
                                </a>
                            </li>
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
            <form action="{{ route('project.fund12.data', $project->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-12 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-bordered" id="cooperationTable">
                                            <thead>
                                                <tr>
                                                    <th>合作單位統編</th>
                                                    <th>合作單位</th>
                                                    <th>內容</th>
                                                    <th>合作金額</th>
                                                    <th>管理</th>
                                                </tr>
                                            </thead>
                                            <tbody id="cooperationTableBody">
                                                @if (isset($datas))
                                                    @foreach ($datas as $data)
                                                        <tr>
                                                            <td><input type="text" name="tax_id[]" class="form-control"
                                                                    value="{{ $data->tax_id }}"></td>
                                                            <td><input type="text" name="company_name[]"
                                                                    class="form-control" value="{{ $data->company_name }}">
                                                            </td>
                                                            <td><input type="text" name="content[]" class="form-control"
                                                                    value="{{ $data->content }}"></td>
                                                            <td><input type="number" name="total[]" class="form-control"
                                                                    step="1" value="{{ $data->total }}"></td>
                                                            <td><button type="button" class="btn btn-danger btn-sm"
                                                                    onclick="removeCooperationRow(this)">刪除</button></td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="3" class="text-end text-danger">合計</td>
                                                    <td id="cooperationTotal" class="text-danger">0</td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <button class="btn btn-secondary" type="button"
                                            onclick="addCooperationRow()">新增一列</button>

                                        <!-- 按鈕 -->
                                        <div class="d-flex justify-content-start gap-2 mt-4">
                                            <button type="submit" class="btn btn-teal btn-success">送出存檔</button>
                                            <a href="{{ route('project.sbir10', $project->id) }}"><button type="button"
                                                    class="btn btn-primary">回上一頁</button></a>
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
    <script>
        function addCooperationRow() {
            const tbody = document.getElementById('cooperationTableBody');
            const row = document.createElement('tr');
            row.innerHTML = `
                <td><input type="text" name="tax_id[]" class="form-control"></td>
                <td><input type="text" name="company_name[]" class="form-control"></td>
                <td><input type="text" name="content[]" class="form-control"></td>
                <td><input type="number" name="total[]" class="form-control" step="1"></td>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="removeCooperationRow(this)">刪除</button></td>
            `;
            tbody.appendChild(row);
            row.querySelectorAll('input').forEach(input => {
                input.addEventListener('input', updateCooperationTotal);
            });
            updateCooperationTotal();
        }

        function removeCooperationRow(btn) {
            btn.closest('tr').remove();
            updateCooperationTotal();
        }

        function updateCooperationTotal() {
            let total = 0;
            document.querySelectorAll('[name="total[]"]').forEach(input => {
                total += parseFloat(input.value) || 0;
            });
            document.getElementById('cooperationTotal').textContent = total.toFixed(2);
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[name="total[]"]').forEach(input => {
                input.addEventListener('input', updateCooperationTotal);
            });
            updateCooperationTotal();
        });
    </script>
@endsection
