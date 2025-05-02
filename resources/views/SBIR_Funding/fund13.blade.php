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
            <form action="{{ route('project.fund13.data', $project->id) }}" method="POST">
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
                                                @if (isset($datas))
                                                    @foreach ($datas as $data)
                                                        <tr>
                                                            <td><input type="text" name="purpose[]" class="form-control"
                                                                    value="{{ $data->purpose }}">
                                                            </td>
                                                            <td><input type="text" name="location[]" value="{{ $data->location }}"
                                                                    class="form-control"></td>
                                                            <td><input type="number" name="days[]" class="form-control" value="{{ $data->days }}"
                                                                    min="0" step="1"></td>
                                                            <td><input type="number" name="people[]" class="form-control" value="{{ $data->people }}"
                                                                    min="0" step="1"></td>
                                                            <td><input type="number" name="airfare[]" class="form-control" value="{{ $data->airfare }}"
                                                                    step="1"></td>
                                                            <td><input type="number" name="transport[]" value="{{ $data->transport }}"
                                                                    class="form-control" step="1"></td>
                                                            <td><input type="number" name="accommodation[]" value="{{ $data->accommodation }}"
                                                                    class="form-control" step="1"></td>
                                                            <td><input type="number" name="meals[]" class="form-control" value="{{ $data->meals }}"
                                                                    step="1"></td>
                                                            <td><input type="number" name="others[]" value="{{ $data->others }}"
                                                                    class="form-control" step="1"></td>
                                                            <td class="travelEstimate">{{ $data->total }}</td>
                                                            <td>
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                    onclick="removeTravelRow(this)">刪除</button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
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
        const tbody = document.getElementById('travelTableBody');

        // 1. 事件代理：監聽 tbody 裡任一 input，只要有輸入就重算該列
        tbody.addEventListener('input', e => {
            const names = [
                'purpose[]', 'location[]',
                'days[]', 'people[]',
                'airfare[]', 'transport[]',
                'accommodation[]', 'meals[]', 'others[]'
            ];
            if (names.includes(e.target.name)) {
                const row = e.target.closest('tr');
                calculateTravelRow(row);
            }
        });

        // 2. 動態新增列
        function addTravelRow() {
            const row = document.createElement('tr');
            row.innerHTML = `
            <td><input type="text" name="purpose[]" class="form-control"></td>
            <td><input type="text" name="location[]" class="form-control"></td>
            <td><input type="number" name="days[]" class="form-control" min="0" step="1"></td>
            <td><input type="number" name="people[]" class="form-control" min="0" step="1"></td>
            <td><input type="number" name="airfare[]" class="form-control" step="1"></td>
            <td><input type="number" name="transport[]" class="form-control" step="1"></td>
            <td><input type="number" name="accommodation[]" class="form-control" step="1"></td>
            <td><input type="number" name="meals[]" class="form-control" step="1"></td>
            <td><input type="number" name="others[]" class="form-control" step="1"></td>
            <td class="travelEstimate">0</td>
            <td>
              <button type="button" class="btn btn-danger btn-sm"
                      onclick="removeTravelRow(this)">刪除</button>
            </td>
          `;
            tbody.appendChild(row);
            // 如果你想預設立刻計算（當預設值不為空時），可加：
            calculateTravelRow(row);
        }

        // 3. 刪除列
        function removeTravelRow(btn) {
            btn.closest('tr').remove();
            updateTravelTotal();
        }

        // 4. 計算單列「全程費用概算」
        function calculateTravelRow(row) {
            const days = parseFloat(row.querySelector('[name="days[]"]').value) || 0;
            const people = parseFloat(row.querySelector('[name="people[]"]').value) || 0;
            const airfare = parseFloat(row.querySelector('[name="airfare[]"]').value) || 0;
            const transport = parseFloat(row.querySelector('[name="transport[]"]').value) || 0;
            const accommodation = parseFloat(row.querySelector('[name="accommodation[]"]').value) || 0;
            const meals = parseFloat(row.querySelector('[name="meals[]"]').value) || 0;
            const others = parseFloat(row.querySelector('[name="others[]"]').value) || 0;

            // 核心計算：(各項費用總和) × 天數 × 人次
            const base = airfare + transport + accommodation + meals + others;
            const estimate = base * days * people;
            row.querySelector('.travelEstimate').textContent = estimate.toFixed(2);

            // 更新整表合計
            updateTravelTotal();
        }

        // 5. 更新表尾「合計」
        function updateTravelTotal() {
            let sum = 0;
            document.querySelectorAll('.travelEstimate').forEach(cell => {
                sum += parseFloat(cell.textContent) || 0;
            });
            document.getElementById('travelTotal').textContent = sum.toFixed(2);
        }

        // 6. 初次載入（若有預先填的列）也可呼叫一次
        updateTravelTotal();
    </script>
@endsection
