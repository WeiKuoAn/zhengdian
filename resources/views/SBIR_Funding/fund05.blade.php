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
            <form action="{{ route('project.fund01.data', $project->id) }}" method="POST">
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
                                                    <th>投入月數</th>
                                                    <th>操作</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input type="text" name="equipment_name[]" class="form-control"></td>
                                                    <td><input type="text" name="property_code[]" class="form-control"></td>
                                                    <td><input type="text" name="purchase_amount[]" class="form-control"></td>
                                                    <td><input type="text" name="purchase_date[]" class="form-control"></td>
                                                    <td><input type="text" name="book_value[]" class="form-control"></td>
                                                    <td><input type="text" name="quantity[]" class="form-control"></td>
                                                    <td><input type="text" name="useful_life[]" class="form-control"></td>
                                                    <td><input type="text" name="input_months[]" class="form-control"></td>
                                                    <td><button type="button" class="btn btn-danger" onclick="removeRow(this)">刪除</button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <button class="btn btn-secondary" type="button" onclick="addEquipmentRow()">新增資料</button>
                                        <!-- 按鈕 -->
                                        <div class="d-flex justify-content-start gap-2 mt-4">
                                            <button type="submit" class="btn btn-teal btn-success">送出存檔</button>
                                            <button type="button" class="btn btn-primary">回上一頁</button>
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
        function updateStaffNumbers() {
            document.querySelectorAll('#staffTable .staff-number').forEach((cell, index) => {
                cell.textContent = index + 1;
            });
        }

        function updateBudget() {
            document.querySelectorAll('#staffTable tbody tr').forEach(row => {
                const salary = parseFloat(row.querySelector('[name="salary[]"]').value) || 0;
                const month = parseFloat(row.querySelector('[name="man_month[]"]').value) || 0;
                row.querySelector('.budget').textContent = salary * month;
            });
        }

        function addStaffRow() {
            const tbody = document.querySelector('#staffTable tbody');
            const row = document.createElement('tr');
            row.innerHTML = `
            <td class="staff-number"></td>
            <td><input type="text" name="staff_name[]" class="form-control"></td>
            <td>
              <select name="staff_title[]" class="form-control">
                <option value="計畫主持人">計畫主持人</option>
                <option value="計畫聯絡人">計畫聯絡人</option>
                <option value="計畫參與人員">計畫參與人員</option>
              </select>
            </td>
            <td><input type="number" name="salary[]" class="form-control" onchange="updateBudget()"></td>
            <td><input type="number" name="man_month[]" class="form-control" onchange="updateBudget()"></td>
            <td class="budget">0</td>
            <td><button type="button" class="btn btn-danger" onclick="removeStaffRow(this)">刪除</button></td>
          `;
            tbody.appendChild(row);
            updateStaffNumbers();
        }

        function removeStaffRow(button) {
            button.closest('tr').remove();
            updateStaffNumbers();
            updateBudget();
        }

        document.addEventListener('DOMContentLoaded', () => {
            updateStaffNumbers();
            document.querySelectorAll('[name="salary[]"], [name="man_month[]"]').forEach(el => {
                el.addEventListener('change', updateBudget);
            });
        });
    </script>
@endsection
