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
            <form action="{{ route('project.fund05.data', $project->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-12 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-bordered" id="travelTable">
                                            <thead>
                                                <tr>
                                                    <th>出差事由</th>
                                                    <th>地點</th>
                                                    <th>天數</th>
                                                    <th>人次</th>
                                                    <th>機票</th>
                                                    <th>車資</th>
                                                    <th>住宿費</th>
                                                    <th>膳雜費</th>
                                                    <th>其他</th>
                                                    <th>全程費用概算</th>
                                                    <th>管理</th>
                                                </tr>
                                            </thead>
                                            <tbody id="travelTableBody">
                                                <!-- 動態新增列 -->
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="9" class="text-end text-danger">合計</td>
                                                    <td id="travelTotal" class="text-danger">0</td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <button class="btn btn-secondary" type="button"
                                            onclick="addTravelRow()">新增一列</button>

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
        function addTravelRow() {
            const tbody = document.getElementById('travelTableBody');
            const row = document.createElement('tr');
            row.innerHTML = `
            <td><input type="text" name="purpose[]" class="form-control"></td>
            <td><input type="text" name="location[]" class="form-control"></td>
            <td><input type="number" name="days[]" class="form-control"></td>
            <td><input type="number" name="people[]" class="form-control"></td>
            <td><input type="number" name="airfare[]" class="form-control" step="0.01"></td>
            <td><input type="number" name="transport[]" class="form-control" step="0.01"></td>
            <td><input type="number" name="accommodation[]" class="form-control" step="0.01"></td>
            <td><input type="number" name="meals[]" class="form-control" step="0.01"></td>
            <td><input type="number" name="others[]" class="form-control" step="0.01"></td>
            <td class="travelEstimate">0</td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="removeTravelRow(this)">刪除</button></td>
          `;
            tbody.appendChild(row);
            row.querySelectorAll('input').forEach(input => {
                input.addEventListener('input', () => calculateTravelRow(row));
            });
            calculateTravelRow(row);
        }

        function removeTravelRow(btn) {
            btn.closest('tr').remove();
            updateTravelTotal();
        }

        function calculateTravelRow(row) {
            const airfare = parseFloat(row.querySelector('[name="airfare[]"]').value) || 0;
            const transport = parseFloat(row.querySelector('[name="transport[]"]').value) || 0;
            const accommodation = parseFloat(row.querySelector('[name="accommodation[]"]').value) || 0;
            const meals = parseFloat(row.querySelector('[name="meals[]"]').value) || 0;
            const others = parseFloat(row.querySelector('[name="others[]"]').value) || 0;
            const estimate = airfare + transport + accommodation + meals + others;
            row.querySelector('.travelEstimate').textContent = estimate.toFixed(2);
            updateTravelTotal();
        }

        function updateTravelTotal() {
            let total = 0;
            document.querySelectorAll('.travelEstimate').forEach(cell => {
                total += parseFloat(cell.textContent) || 0;
            });
            document.getElementById('travelTotal').textContent = total.toFixed(2);
        }
    </script>
@endsection
