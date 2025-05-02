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
            <form action="{{ route('project.fund04.data', $project->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-12 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-bordered" id="staffTable">
                                            <thead>
                                                <tr>
                                                    <th>項目</th>
                                                    <th>單位</th>
                                                    <th>預估需求數量</th>
                                                    <th>預估單價(千元)</th>
                                                    <th>全程費用概算(A×B)</th>
                                                    <th>操作</th>
                                                </tr>
                                            </thead>
                                            <tbody id="staffTableBody">
                                                @if (isset($datas) && count($datas) > 0)
                                                    @foreach ($datas as $key => $data)
                                                        <tr>
                                                            <td><input type="text" name="name[]" class="form-control"
                                                                    value="{{ $data->name }}"></td>
                                                            <td><input type="text" name="unit[]" class="form-control"
                                                                    value="{{ $data->unit }}"></td>
                                                            <td><input type="number" name="quantity[]" class="form-control"
                                                                    step="1" value="{{ $data->quantity }}"></td>
                                                            <td><input type="number" name="price[]" class="form-control"
                                                                    step="1" value="{{ $data->price }}"></td>
                                                            <td class="budget">0</td>
                                                            <td><button type="button" class="btn btn-danger"
                                                                    onclick="removeStaffRow(this)">刪除</button></td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="4" class="text-end text-danger">總計</td>
                                                    <td id="totalBudget" class="text-danger">0</td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <div class="mb-3">
                                            <button type="button" class="btn btn-secondary"
                                                onclick="addStaffRow()">新增一列</button>
                                        </div>
                                        <!-- 按鈕 -->
                                        <div class="d-flex justify-content-start gap-2">
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
        function addStaffRow(name = '', unit = '', quantity = '', price = '') {
            const tbody = document.getElementById('staffTableBody');
            const row = document.createElement('tr');
            row.innerHTML = `
            <td><input type="text" name="name[]" class="form-control" value="${name}"></td>
            <td><input type="text" name="unit[]" class="form-control" value="${unit}"></td>
            <td><input type="number" name="quantity[]" class="form-control" value="${quantity}" step="1"></td>
            <td><input type="number" name="price[]" class="form-control" value="${price}" step="1"></td>
            <td class="budget">0</td>
            <td><button type="button" class="btn btn-danger" onclick="removeStaffRow(this)">刪除</button></td>
          `;
            tbody.appendChild(row);
            attachBudgetCalc(row);
            calculateTotalBudget();
        }

        function removeStaffRow(btn) {
            const row = btn.closest('tr');
            row.remove();
            calculateTotalBudget();
        }

        function attachBudgetCalc(row) {
            const quantityInput = row.querySelector('[name="quantity[]"]');
            const priceInput = row.querySelector('[name="price[]"]');
            const budgetCell = row.querySelector('.budget');
            const calc = () => {
                const quantity = parseFloat(quantityInput.value) || 0;
                const price = parseFloat(priceInput.value) || 0;
                const budget = quantity * price;
                budgetCell.textContent = budget.toFixed(0);
                calculateTotalBudget();
            };
            quantityInput.addEventListener('input', calc);
            priceInput.addEventListener('input', calc);
            calc();
        }

        function calculateTotalBudget() {
            let total = 0;
            document.querySelectorAll('#staffTableBody .budget').forEach(cell => {
                total += parseFloat(cell.textContent) || 0;
            });
            document.getElementById('totalBudget').textContent = total.toFixed(0);
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('#staffTableBody tr').forEach(row => {
                attachBudgetCalc(row);
            });
            calculateTotalBudget();
        });
    </script>
@endsection
