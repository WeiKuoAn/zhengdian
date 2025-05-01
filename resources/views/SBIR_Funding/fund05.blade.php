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
                                        <table class="table table-bordered" id="equipmentTable">
                                            <thead>
                                                <tr>
                                                    <th>設備名稱</th>
                                                    <th>財產編號</th>
                                                    <th>單套購置金額</th>
                                                    <th>購入日期(年/月)</th>
                                                    <th>單套帳面價值 A (千元)</th>
                                                    <th>套數 B</th>
                                                    <th>剩餘使用年限</th>
                                                    <th>月使用費 (A×B/(剩餘使用年限×12))</th>
                                                    <th>投入月數</th>
                                                    <th>使用費用概算</th>
                                                    <th>操作</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($datas as $key => $equipment)
                                                <tr>
                                                    <td><input type="text" name="equipment_name[]" class="form-control" value="{{ $equipment->equipment_name }}"></td>
                                                    <td><input type="text" name="asset_number[]" class="form-control" value="{{ $equipment->asset_number }}"></td>
                                                    <td><input type="number" name="purchase_amount[]" class="form-control" value="{{ $equipment->purchase_amount }}"></td>
                                                    <td><input type="text" name="purchase_date[]" class="form-control" value="{{ $equipment->purchase_date }}"></td>
                                                    <td><input type="number" name="book_value[]" class="form-control" value="{{ $equipment->book_value }}"></td>
                                                    <td><input type="number" name="set_count[]" class="form-control" value="{{ $equipment->set_count }}"></td>
                                                    <td><input type="number" name="remaining_years[]" class="form-control" value="{{ $equipment->remaining_years }}"></td>
                                                    <td class="monthly_fee">0</td>
                                                    <td><input type="number" name="investment_months[]" class="form-control" value="{{ $equipment->investment_months }}"></td>
                                                    <td class="usage_estimate">0</td>
                                                    <td><button type="button" class="btn btn-danger" onclick="removeEquipmentRow(this)">刪除</button></td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        
                                        <div class="mb-3">
                                            <button type="button" class="btn btn-primary" onclick="addEquipmentRow()">新增一列</button>
                                        </div>
                                        <!-- 按鈕 -->
                                        <div class="d-flex justify-content-start gap-2 mt-4">
                                            <button type="submit" class="btn btn-teal btn-success">送出存檔</button>
                                            <a href="{{ route('project.sbir10',$project->id) }}"><button type="button" class="btn btn-primary">回上一頁</button></a>
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
        // 新增一列
        function addEquipmentRow() {
            const tableBody = document.querySelector('#equipmentTable tbody');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td><input type="text" name="equipment_name[]" class="form-control"></td>
                <td><input type="text" name="asset_number[]" class="form-control"></td>
                <td><input type="number" name="purchase_amount[]" class="form-control"></td>
                <td><input type="text" name="purchase_date[]" class="form-control"></td>
                <td><input type="number" name="book_value[]" class="form-control" oninput="calculateMonthlyFee(this)"></td>
                <td><input type="number" name="set_count[]" class="form-control" oninput="calculateMonthlyFee(this)"></td>
                <td><input type="number" name="remaining_years[]" class="form-control" oninput="calculateMonthlyFee(this)"></td>
                <td class="monthly_fee">0</td>
                <td><input type="number" name="investment_months[]" class="form-control" oninput="calculateUsageEstimate(this)"></td>
                <td class="usage_estimate">0</td>
                <td><button type="button" class="btn btn-danger" onclick="removeEquipmentRow(this)">刪除</button></td>
            `;
            tableBody.appendChild(newRow);
        }
        
        // 刪除一列
        function removeEquipmentRow(button) {
            button.closest('tr').remove();
        }
        
        // 計算月使用費
        function calculateMonthlyFee(input) {
            const row = input.closest('tr');
            const bookValue = parseFloat(row.querySelector('input[name="book_value[]"]').value) || 0;
            const setCount = parseFloat(row.querySelector('input[name="set_count[]"]').value) || 0;
            const remainingYears = parseFloat(row.querySelector('input[name="remaining_years[]"]').value) || 0;
        
            let monthlyFee = 0;
            if (remainingYears > 0) {
                monthlyFee = (bookValue * setCount) / (remainingYears * 12);
            }
        
            row.querySelector('.monthly_fee').textContent = monthlyFee.toFixed(3);
        
            // 重新計算使用費用概算
            calculateUsageEstimate(row.querySelector('input[name="investment_months[]"]'));
        }
        
        // 計算使用費用概算
        function calculateUsageEstimate(input) {
            const row = input.closest('tr');
            const monthlyFee = parseFloat(row.querySelector('.monthly_fee').textContent) || 0;
            const investmentMonths = parseFloat(row.querySelector('input[name="investment_months[]"]').value) || 0;
        
            const usageEstimate = monthlyFee * investmentMonths;
            row.querySelector('.usage_estimate').textContent = usageEstimate.toFixed(0);
        }
        </script>
@endsection
