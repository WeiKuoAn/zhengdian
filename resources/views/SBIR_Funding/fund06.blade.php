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
            <form action="{{ route('project.fund06.data', $project->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-12 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-bordered" id="equipmentTable">
                                            <thead>
                                                <tr>
                                                    <th>設備名稱</th>
                                                    <th>財產編號</th>
                                                    <th>單套購置金額 A</th>
                                                    <th>套數 B</th>
                                                    <th>耐用年限</th>
                                                    <th>月使用費 A×B/(耐用年數×12)</th>
                                                    <th>投入月數</th>
                                                    <th>使用費用概算</th>
                                                    <th>操作</th>
                                                </tr>
                                            </thead>
                                            <tbody id="equipmentTableBody">
                                                <!-- 動態列插入於此 -->
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="7" class="text-end text-danger">合計</td>
                                                    <td id="totalUsageEstimate" class="text-danger">0</td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <button class="btn btn-secondary" type="button" onclick="addEquipmentRow()">新增一列</button>

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
        function calculateRow(row) {
            const price = parseFloat(row.querySelector('[name="price[]"]').value) || 0;
            const count = parseFloat(row.querySelector('[name="count[]"]').value) || 0;
            const years = parseFloat(row.querySelector('[name="life[]"]').value) || 0;
            const months = parseFloat(row.querySelector('[name="investment_months[]"]').value) || 0;

            let monthly = 0;
            if (years > 0) {
                monthly = (price * count) / (years * 12);
            }
            const estimate = monthly * months;

            row.querySelector('.monthlyFee').innerText = monthly.toFixed(3);
            row.querySelector('.usageEstimate').innerText = estimate.toFixed(0);

            return estimate;
        }

        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('#equipmentTableBody tr').forEach(row => {
                total += calculateRow(row);
            });
            document.getElementById('totalUsageEstimate').innerText = total.toFixed(2);
        }

        function addEquipmentRow() {
            const tbody = document.getElementById('equipmentTableBody');
            const row = document.createElement('tr');
            row.innerHTML = `
                <td><input type="text" name="name[]" class="form-control"></td>
                <td><input type="text" name="code[]" class="form-control"></td>
                <td><input type="number" name="price[]" class="form-control" step="1"></td>
                <td><input type="number" name="count[]" class="form-control" step="1"></td>
                <td><input type="number" name="life[]" class="form-control" step="1"></td>
                <td class="monthlyFee">0.00</td>
                <td><input type="number" name="investment_months[]" class="form-control" step="1"></td>
                <td class="usageEstimate">0.00</td>
                                <td>
                    <button class="btn btn-sm btn-danger" onclick="removeRow(this)">刪除</button>
                </td>
            `;
            tbody.appendChild(row);

            row.querySelectorAll('input').forEach(input => {
                input.addEventListener('input', () => calculateTotal());
            });
        }

        function removeRow(btn) {
            btn.closest('tr').remove();
            calculateTotal();
        }
    </script>
@endsection
