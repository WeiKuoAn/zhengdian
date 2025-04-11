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
                                            <h4 class="mt-3">儲存商業類資料成功！</h4>
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
            <form action="{{ route('project.sbir04.data', $project->id) }}" method="POST">
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
                                                <a href="{{ route('project.sbir07', $project->id) }}" class="nav-link ">
                                                    柒、實施方式
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir08', $project->id) }}" class="nav-link ">
                                                    捌、智財分析
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir09', $project->id) }}"
                                                    class="nav-link active">
                                                    玖、計畫執行查核點說明
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir10', $project->id) }}" class="nav-link">
                                                    拾、經費需求
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir07', $project->id) }}" class="nav-link">
                                                    附件
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="card-body">
                                            <div class="mb-5">
                                                <h5 class="text-uppercase bg-light p-2 mt-3 mb-3">預定查核點說明</h5>

                                                <div class="mb-3">
                                                    <table class="table table-bordered" id="checkpointsTable">
                                                        <thead>
                                                            <tr>
                                                                <th>查核點編號</th>
                                                                <th>預定完成時間</th>
                                                                <th>查核點內容</th>
                                                                <th>管理</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- 預設空 -->
                                                        </tbody>
                                                    </table>
                                                    <button class="btn btn-secondary" type="button"
                                                        onclick="addCheckpointRow()">新增資料</button>
                                                </div>


                                                <hr>
                                                <h5 class="text-uppercase bg-light p-2 mt-3 mb-3">計畫主持人資歷說明</h5>
                                                <div class="mb-3">
                                                    <table class="table table-bordered" id="basicInfoTable">
                                                        <thead>
                                                            <tr>
                                                                <th>姓名</th>
                                                                <th>性別</th>
                                                                <th>身份證字號</th>
                                                                <th>操作</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><input type="text" name="name[]"
                                                                        class="form-control"></td>
                                                                <td>
                                                                    <select name="gender[]" class="form-control">
                                                                        <option value="男">男</option>
                                                                        <option value="女">女</option>
                                                                    </select>
                                                                </td>
                                                                <td><input type="text" name="id_number[]"
                                                                        class="form-control"></td>
                                                                <td><button type="button" class="btn btn-danger"
                                                                        onclick="this.closest('tr').remove()">刪除</button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <button class="btn btn-secondary" type="button"
                                                        onclick="addBasicInfoRow()">新增資料</button>
                                                </div>

                                                <h5 class="text-uppercase bg-light p-2 mt-3 mb-3">學歷</h5>
                                                <div class="mb-3">
                                                    <table class="table table-bordered" id="educationTable">
                                                        <thead>
                                                            <tr>
                                                                <th>學校(大專以上)</th>
                                                                <th>時間(年月 ~ 年月)</th>
                                                                <th>學位</th>
                                                                <th>科系</th>
                                                                <th>管理</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><input type="text" name="school[]"
                                                                        class="form-control"></td>
                                                                <td><input type="text" name="period[]"
                                                                        class="form-control"></td>
                                                                <td><input type="text" name="degree[]"
                                                                        class="form-control"></td>
                                                                <td><input type="text" name="department[]"
                                                                        class="form-control"></td>
                                                                <td><button class="btn btn-danger"
                                                                        onclick="this.closest('tr').remove()">刪除</button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <button class="btn btn-secondary" type="button"
                                                        onclick="addEducationRow()">新增學歷</button>
                                                </div>

                                                <h5 class="text-uppercase bg-light p-2 mt-3 mb-3">經歷</h5>
                                                <div class="mb-3">
                                                    <table class="table table-bordered" id="experienceTable">
                                                        <thead>
                                                            <tr>
                                                                <th>公司名稱</th>
                                                                <th>時間(年月 ~ 年月)</th>
                                                                <th>部門</th>
                                                                <th>職稱</th>
                                                                <th>管理</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><input type="text" name="company[]"
                                                                        class="form-control"></td>
                                                                <td><input type="text" name="work_period[]"
                                                                        class="form-control"></td>
                                                                <td><input type="text" name="department[]"
                                                                        class="form-control"></td>
                                                                <td><input type="text" name="position[]"
                                                                        class="form-control"></td>
                                                                <td><button class="btn btn-danger"
                                                                        onclick="this.closest('tr').remove()">刪除</button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <button class="btn btn-secondary" type="button"
                                                        onclick="addExperienceRow()">新增經歷</button>
                                                </div>

                                                <h5 class="text-uppercase bg-light p-2 mt-3 mb-3">曾參與計畫</h5>
                                                <div class="mb-3">
                                                    <table class="table table-bordered" id="planTable">
                                                        <thead>
                                                            <tr>
                                                                <th>計畫名稱</th>
                                                                <th>時間(年月 ~ 年月)</th>
                                                                <th>公司名稱</th>
                                                                <th>主要任務</th>
                                                                <th>管理</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><input type="text" name="plan_name[]"
                                                                        class="form-control"></td>
                                                                <td><input type="text" name="plan_period[]"
                                                                        class="form-control"></td>
                                                                <td><input type="text" name="plan_company[]"
                                                                        class="form-control"></td>
                                                                <td><input type="text" name="plan_duty[]"
                                                                        class="form-control"></td>
                                                                <td><button class="btn btn-danger"
                                                                        onclick="this.closest('tr').remove()">刪除</button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <button class="btn btn-secondary" type="button"
                                                        onclick="addPlanRow()">新增曾參與計畫</button>
                                                </div>

                                                <hr>
                                                <h5 class="text-uppercase bg-light p-2 mt-3 mb-3">計畫人員簡歷表</h5>
                                                <div class="mb-3">
                                                    <table class="table table-bordered" id="staffTable">
                                                        <thead>
                                                            <tr>
                                                                <th>編號</th>
                                                                <th>姓名</th>
                                                                <th>職稱</th>
                                                                <th>會計科目分類</th>
                                                                <th>研發人員</th>
                                                                <th>最高學歷(學校系所)</th>
                                                                <th>主要經歷</th>
                                                                <th>主要重要成就</th>
                                                                <th>本業年資</th>
                                                                <th>參與分項計畫及工作項目</th>
                                                                <th>操作</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><input type="number" name="staff_no[]"
                                                                        class="form-control"></td>
                                                                <td><input type="text" name="staff_name[]"
                                                                        class="form-control"></td>
                                                                <td><input type="text" name="staff_title[]"
                                                                        class="form-control"></td>
                                                                <td><input type="text" name="account_category[]"
                                                                        class="form-control"></td>
                                                                <td>
                                                                    <select name="is_rnd[]" class="form-control">
                                                                        <option value="是">是</option>
                                                                        <option value="否">否</option>
                                                                    </select>
                                                                </td>
                                                                <td><input type="text" name="education[]"
                                                                        class="form-control"></td>
                                                                <td><input type="text" name="experience[]"
                                                                        class="form-control"></td>
                                                                <td><input type="text" name="achievement[]"
                                                                        class="form-control"></td>
                                                                <td><input type="text" name="seniority[]"
                                                                        class="form-control"></td>
                                                                <td><input type="text" name="task[]"
                                                                        class="form-control"></td>
                                                                <td><button type="button" class="btn btn-danger"
                                                                        onclick="this.closest('tr').remove()">刪除</button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <button class="btn btn-secondary" type="button"
                                                        onclick="addStaffRow()">新增資料</button>
                                                </div>
                                                <hr>


                                                <!-- 按鈕 -->
                                                <div class="d-flex justify-content-start gap-2">
                                                    <button type="submit" class="btn btn-teal btn-success">送出存檔</button>
                                                    <button type="button" class="btn btn-primary">回上一頁</button>
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
    <script>
        function addCheckpointRow() {
            const table = document.getElementById('checkpointsTable').querySelector('tbody');
            const row = document.createElement('tr');

            row.innerHTML = `
      <td><input type="text" name="checkpoint_code[]" class="form-control" placeholder="如 A1, B1"></td>
      <td><input type="month" name="checkpoint_due[]" class="form-control"></td>
      <td><input type="text" name="checkpoint_content[]" class="form-control"></td>
      <td><button class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()">刪除</button></td>
    `;

            table.appendChild(row);
        }

        function addBasicInfoRow() {
            const table = document.getElementById('basicInfoTable').getElementsByTagName('tbody')[0];
            const newRow = table.insertRow();
            newRow.innerHTML = `
      <td><input type="text" name="name[]" class="form-control"></td>
      <td>
        <select name="gender[]" class="form-control">
          <option value="男">男</option>
          <option value="女">女</option>
        </select>
      </td>
      <td><input type="text" name="id_number[]" class="form-control"></td>
      <td><button type="button" class="btn btn-danger" onclick="this.closest('tr').remove()">刪除</button></td>
    `;
        }

        function addEducationRow() {
            const table = document.getElementById('educationTable').getElementsByTagName('tbody')[0];
            const newRow = table.insertRow();
            newRow.innerHTML = `
      <td><input type="text" name="school[]" class="form-control"></td>
      <td><input type="text" name="period[]" class="form-control"></td>
      <td><input type="text" name="degree[]" class="form-control"></td>
      <td><input type="text" name="department[]" class="form-control"></td>
      <td><button type="button" class="btn btn-danger" onclick="this.closest('tr').remove()">刪除</button></td>
    `;
        }

        function addExperienceRow() {
            const table = document.getElementById('experienceTable').getElementsByTagName('tbody')[0];
            const newRow = table.insertRow();
            newRow.innerHTML = `
      <td><input type="text" name="company[]" class="form-control"></td>
      <td><input type="text" name="work_period[]" class="form-control"></td>
      <td><input type="text" name="department[]" class="form-control"></td>
      <td><input type="text" name="position[]" class="form-control"></td>
      <td><button type="button" class="btn btn-danger" onclick="this.closest('tr').remove()">刪除</button></td>
    `;
        }

        function addPlanRow() {
            const table = document.getElementById('planTable').getElementsByTagName('tbody')[0];
            const newRow = table.insertRow();
            newRow.innerHTML = `
      <td><input type="text" name="plan_name[]" class="form-control"></td>
      <td><input type="text" name="plan_period[]" class="form-control"></td>
      <td><input type="text" name="plan_company[]" class="form-control"></td>
      <td><input type="text" name="plan_duty[]" class="form-control"></td>
      <td><button type="button" class="btn btn-danger" onclick="this.closest('tr').remove()">刪除</button></td>
    `;
        }

        function addStaffRow() {
            const table = document.getElementById('staffTable').getElementsByTagName('tbody')[0];
            const newRow = table.insertRow();
            newRow.innerHTML = `
      <td><input type="number" name="staff_no[]" class="form-control"></td>
      <td><input type="text" name="staff_name[]" class="form-control"></td>
      <td><input type="text" name="staff_title[]" class="form-control"></td>
      <td><input type="text" name="account_category[]" class="form-control"></td>
      <td>
        <select name="is_rnd[]" class="form-control">
          <option value="是">是</option>
          <option value="否">否</option>
        </select>
      </td>
      <td><input type="text" name="education[]" class="form-control"></td>
      <td><input type="text" name="experience[]" class="form-control"></td>
      <td><input type="text" name="achievement[]" class="form-control"></td>
      <td><input type="text" name="seniority[]" class="form-control"></td>
      <td><input type="text" name="task[]" class="form-control"></td>
      <td><button type="button" class="btn btn-danger" onclick="this.closest('tr').remove()">刪除</button></td>
    `;
        }
    </script>
@endsection
