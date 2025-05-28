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
            <form action="{{ route('project.sbir09.data', $project->id) }}" method="POST">
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
                                                <h5 class="text-uppercase bg-light p-2 mt-3 mb-3">預定進度及查核點</h5>
                                                <div class="mb-3">
                                                    <table class="table table-bordered" id="pointsTable">
                                                        <thead>
                                                            <tr>
                                                                <th>工作項目</th>
                                                                <th>計畫權重</th>
                                                                <th>預定投入人月</th>
                                                                <th>管理</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if (count($points) > 0)
                                                                @foreach ($points as $point)
                                                                    <tr>
                                                                        <td>
                                                                            <input type="text"
                                                                                name="point_items[]"
                                                                                class="form-control"
                                                                                value="{{ $point->item }}">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="point_weights[]"
                                                                                class="date form-control change_cal_date"
                                                                                value="{{ $point->weight }}">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text"
                                                                                name="point_months[]"
                                                                                class="form-control"
                                                                                value="{{ $point->month }}">
                                                                        </td>
                                                                        <td>
                                                                            <button class="btn btn-danger btn-sm"
                                                                                onclick="this.closest('tr').remove()">刪除</button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>

                                                    <div class="mt-4">
                                                        <button class="btn btn-secondary" type="button"
                                                            onclick="addpointRow()">新增資料</button>
                                                        <a href="{{ route('sbir09.export', $project->id) }}"
                                                            class="btn btn-success">
                                                            匯出計畫書預定進度及查核點 Word 檔
                                                        </a>
                                                    </div>
                                                </div>
                                                <hr>
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
                                                            @if (count($checkpoints) > 0)
                                                                @foreach ($checkpoints as $checkpoint)
                                                                    <tr>
                                                                        <td>
                                                                            <input type="text"
                                                                                name="checkpoint_codes[]"
                                                                                class="form-control"
                                                                                value="{{ $checkpoint->checkpoint_code }}">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="checkpoint_dues[]"
                                                                                class="date form-control change_cal_date"
                                                                                value="{{ $checkpoint->checkpoint_due }}">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text"
                                                                                name="checkpoint_contents[]"
                                                                                class="form-control"
                                                                                value="{{ $checkpoint->checkpoint_content }}">
                                                                        </td>
                                                                        <td>
                                                                            <button class="btn btn-danger btn-sm"
                                                                                onclick="this.closest('tr').remove()">刪除</button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
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
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <input type="text" name="name"
                                                                        class="form-control"
                                                                        @if (isset($project_host_data)) value="{{ $project_host_data->name }}" @endif>
                                                                </td>
                                                                <td>
                                                                    <select name="gender" class="form-control">
                                                                        <option value="男"
                                                                            @if (isset($project_host_data) && $project_host_data->gender == '男') selected @endif>
                                                                            男</option>
                                                                        <option value="女"
                                                                            @if (isset($project_host_data) && $project_host_data->gender == '女') selected @endif>
                                                                            女</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="id_card"
                                                                        class="form-control"
                                                                        @if (isset($project_host_data)) value="{{ $project_host_data->id_card }}" @endif>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
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
                                                            @if (count($host_educations) > 0)
                                                                @foreach ($host_educations as $education)
                                                                    <tr>
                                                                        <td><input type="text" name="school[]"
                                                                                class="form-control"
                                                                                value="{{ $education->school }}"></td>
                                                                        <td><input type="text" name="period[]"
                                                                                class="form-control"
                                                                                value="{{ $education->period }}"></td>
                                                                        <td><input type="text" name="degree[]"
                                                                                class="form-control"
                                                                                value="{{ $education->degree }}"></td>
                                                                        <td><input type="text" name="department[]"
                                                                                class="form-control"
                                                                                value="{{ $education->department }}"></td>
                                                                        <td><button class="btn btn-danger"
                                                                                onclick="this.closest('tr').remove()">刪除</button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @else
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
                                                            @endif

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
                                                            @if (count($host_Experiences) > 0)
                                                                @foreach ($host_Experiences as $experience)
                                                                    <tr>
                                                                        <td><input type="text" name="company[]"
                                                                                class="form-control"
                                                                                value="{{ $experience->company }}"></td>
                                                                        <td><input type="text" name="work_period[]"
                                                                                class="form-control"
                                                                                value="{{ $experience->work_period }}">
                                                                        </td>
                                                                        <td><input type="text" name="department[]"
                                                                                class="form-control"
                                                                                value="{{ $experience->department }}">
                                                                        </td>
                                                                        <td><input type="text" name="position[]"
                                                                                class="form-control"
                                                                                value="{{ $experience->position }}"></td>
                                                                        <td><button class="btn btn-danger"
                                                                                onclick="this.closest('tr').remove()">刪除</button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @else
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
                                                            @endif
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
                                                            @if (count($host_plans) > 0)
                                                                @foreach ($host_plans as $plan)
                                                                    <tr>
                                                                        <td><input type="text" name="plan_name[]"
                                                                                class="form-control"
                                                                                value="{{ $plan->plan_name }}"></td>
                                                                        <td><input type="text" name="plan_period[]"
                                                                                class="form-control"
                                                                                value="{{ $plan->plan_period }}"></td>
                                                                        <td><input type="text" name="plan_company[]"
                                                                                class="form-control"
                                                                                value="{{ $plan->plan_company }}"></td>
                                                                        <td><input type="text" name="plan_duty[]"
                                                                                class="form-control"
                                                                                value="{{ $plan->plan_duty }}"></td>
                                                                        <td><button class="btn btn-danger"
                                                                                onclick="this.closest('tr').remove()">刪除</button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @else
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
                                                            @endif
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
                                                            @if (count($project_staffs) > 0)
                                                                @foreach ($project_staffs as $index => $staff)
                                                                    <tr>
                                                                        <td class="staff-number">{{ $index + 1 }}</td>
                                                                        <td><input type="text" name="staff_name[]"
                                                                                value="{{ $staff->staff_name }}"
                                                                                class="form-control"></td>
                                                                        <td><input type="text" name="staff_title[]"
                                                                                value="{{ $staff->staff_title }}"
                                                                                class="form-control"></td>
                                                                        <td>
                                                                            <select name="account_category[]"
                                                                                class="form-control">
                                                                                <option value="研發人員"
                                                                                    @if ($staff->account_category == '研發人員') selected @endif>
                                                                                    研發人員</option>
                                                                                <option value="國際研發人員"
                                                                                    @if ($staff->account_category == '國際研發人員') selected @endif>
                                                                                    國際研發人員</option>
                                                                                <option value="顧問"
                                                                                    @if ($staff->account_category == '顧問') selected @endif>
                                                                                    顧問</option>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <select name="is_rnd[]" class="form-control">
                                                                                <option value="是"
                                                                                    @if ($staff->is_rnd == '是') selected @endif>
                                                                                    是</option>
                                                                                <option value="否"
                                                                                    @if ($staff->is_rnd == '是') selected @endif>
                                                                                    否</option>
                                                                            </select>
                                                                        </td>
                                                                        <td><input type="text" name="education[]"
                                                                                value="{{ $staff->education }}"
                                                                                class="form-control"></td>
                                                                        <td><input type="text" name="experience[]"
                                                                                value="{{ $staff->experience }}"
                                                                                class="form-control"></td>
                                                                        <td><input type="text" name="achievement[]"
                                                                                value="{{ $staff->achievement }}"
                                                                                class="form-control"></td>
                                                                        <td><input type="text" name="seniority[]"
                                                                                value="{{ $staff->seniority }}"
                                                                                class="form-control"></td>
                                                                        <td><input type="text" name="task[]"
                                                                                value="{{ $staff->task }}"
                                                                                class="form-control"></td>
                                                                        <td><button type="button" class="btn btn-danger"
                                                                                onclick="removeStaffRow(this)">刪除</button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                @if ($project_host_data)
                                                                    <tr>
                                                                        <td class="staff-number">1</td>
                                                                        <td><input type="text" name="staff_name[]"
                                                                                value="{{ $project_host_data->name }}"
                                                                                class="form-control"></td>
                                                                        <td><input type="text" name="staff_title[]"
                                                                                value="" class="form-control"></td>
                                                                        <td>
                                                                            <select name="account_category[]"
                                                                                class="form-control">
                                                                                <option value="研發人員">
                                                                                    研發人員</option>
                                                                                <option value="國際研發人員">
                                                                                    國際研發人員</option>
                                                                                <option value="顧問">
                                                                                    顧問</option>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <select name="is_rnd[]" class="form-control">
                                                                                <option value="是">
                                                                                    是</option>
                                                                                <option value="否">
                                                                                    否</option>
                                                                            </select>
                                                                        </td>
                                                                        <td><input type="text" name="education[]"
                                                                                value="{{ $project_host_data->education }}"
                                                                                class="form-control"></td>
                                                                        <td><input type="text" name="experience[]"
                                                                                value="{{ $project_host_data->experience }}"
                                                                                class="form-control"></td>
                                                                        <td><input type="text" name="achievement[]"
                                                                                value="{{ $project_host_data->achievement }}"
                                                                                class="form-control"></td>
                                                                        <td><input type="text" name="seniority[]"
                                                                                value="{{ $project_host_data->seniority }}"
                                                                                class="form-control"></td>
                                                                        <td><input type="text" name="task[]"
                                                                                value="{{ $project_host_data->task }}"
                                                                                class="form-control"></td>
                                                                        <td></td>
                                                                    </tr>
                                                                @endif

                                                                @if ($project_contact_data)
                                                                    <tr>
                                                                        <td class="staff-number">2</td>
                                                                        <td><input type="text" name="staff_name[]"
                                                                                value="{{ $project_contact_data->name }}"
                                                                                class="form-control"></td>
                                                                        <td><input type="text" name="staff_title[]"
                                                                                value="" class="form-control"></td>
                                                                        <td>
                                                                            <select name="account_category[]"
                                                                                class="form-control">
                                                                                <option value="研發人員">
                                                                                    研發人員</option>
                                                                                <option value="國際研發人員">
                                                                                    國際研發人員</option>
                                                                                <option value="顧問">
                                                                                    顧問</option>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <select name="is_rnd[]" class="form-control">
                                                                                <option value="是">
                                                                                    是</option>
                                                                                <option value="否">
                                                                                    否</option>
                                                                            </select>
                                                                        </td>
                                                                        <td><input type="text" name="education[]"
                                                                                value="{{ $project_contact_data->education }}"
                                                                                class="form-control"></td>
                                                                        <td><input type="text" name="experience[]"
                                                                                value="{{ $project_contact_data->experience }}"
                                                                                class="form-control"></td>
                                                                        <td><input type="text" name="achievement[]"
                                                                                value="{{ $project_contact_data->achievement }}"
                                                                                class="form-control"></td>
                                                                        <td><input type="text" name="seniority[]"
                                                                                value="{{ $project_contact_data->seniority }}"
                                                                                class="form-control"></td>
                                                                        <td><input type="text" name="task[]"
                                                                                value="{{ $project_contact_data->task }}"
                                                                                class="form-control"></td>
                                                                        <td></td>
                                                                    </tr>
                                                                @endif
                                                                @if (count($project_personnels) > 0)
                                                                    @foreach ($project_personnels as $index => $person)
                                                                        <tr>
                                                                            <td class="staff-number">{{ $index + 3 }}
                                                                            </td>
                                                                            <td><input type="text" name="staff_name[]"
                                                                                    value="{{ $person->name }}"
                                                                                    class="form-control"></td>
                                                                            <td><input type="text" name="staff_title[]"
                                                                                    value="{{ $person->title }}"
                                                                                    class="form-control"></td>
                                                                            <td>
                                                                                <select name="account_category[]"
                                                                                    class="form-control">
                                                                                    <option value="研發人員">
                                                                                        研發人員</option>
                                                                                    <option value="國際研發人員">
                                                                                        國際研發人員</option>
                                                                                    <option value="顧問">
                                                                                        顧問</option>
                                                                                </select>
                                                                            </td>
                                                                            <td>
                                                                                <select name="is_rnd[]"
                                                                                    class="form-control">
                                                                                    <option value="是">
                                                                                        是</option>
                                                                                    <option value="否">
                                                                                        否</option>
                                                                                </select>
                                                                            </td>
                                                                            <td><input type="text" name="education[]"
                                                                                    value="{{ $person->education }}"
                                                                                    class="form-control"></td>
                                                                            <td><input type="text" name="experience[]"
                                                                                    value="{{ $person->experience }}"
                                                                                    class="form-control"></td>
                                                                            <td><input type="text" name="achievement[]"
                                                                                    value="{{ $person->achievement }}"
                                                                                    class="form-control"></td>
                                                                            <td><input type="text" name="seniority[]"
                                                                                    value="{{ $person->seniority }}"
                                                                                    class="form-control"></td>
                                                                            <td><input type="text" name="task[]"
                                                                                    value="{{ $person->task }}"
                                                                                    class="form-control"></td>
                                                                            <td><button type="button"
                                                                                    class="btn btn-danger"
                                                                                    onclick="removeStaffRow(this)">刪除</button>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                    <button class="btn btn-secondary" type="button"
                                                        onclick="addStaffRow()">新增資料</button>
                                                </div>
                                                <hr>
                                                <h5 class="text-uppercase bg-light p-2 mt-3 mb-3">計畫人員簡歷表(待聘)(無則免填)</h5>
                                                <div class="mb-3">
                                                    <table class="table table-bordered" id="waitStaffTable">
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
                                                                <td>1</td>
                                                                <td><input type="text" name="wait_staff_name[]"
                                                                        class="form-control"></td>
                                                                <td><input type="text" name="wait_staff_title[]"
                                                                        class="form-control"></td>
                                                                <td>
                                                                    <select name="wait_account_category[]"
                                                                        class="form-control">
                                                                        <option value="研發人員">研發人員</option>
                                                                        <option value="國際研發人員">國際研發人員</option>
                                                                        <option value="顧問">顧問</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select name="wait_is_rnd[]" class="form-control">
                                                                        <option value="是">是</option>
                                                                        <option value="否">否</option>
                                                                    </select>
                                                                </td>
                                                                <td><input type="text" name="wait_education[]"
                                                                        class="form-control"></td>
                                                                <td><input type="text" name="wait_experience[]"
                                                                        class="form-control"></td>
                                                                <td><input type="text" name="wait_achievement[]"
                                                                        class="form-control"></td>
                                                                <td><input type="text" name="wait_seniority[]"
                                                                        class="form-control"></td>
                                                                <td><input type="text" name="wait_task[]"
                                                                        class="form-control"></td>
                                                                <td><button type="button" class="btn btn-danger"
                                                                        onclick="this.closest('tr').remove()">刪除</button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <button class="btn btn-secondary" type="button"
                                                        onclick="addWaitStaffRow()">新增資料</button>
                                                </div>

                                                <h5 class="text-uppercase bg-light p-2 mt-5 mb-3">計畫研究發展人力統計 (不含兼職顧問)</h5>
                                                <div class="row g-3">
                                                    <div class="col-md-4">
                                                        <label class="form-label">* 學歷博士</label>
                                                        <input type="number" name="count_phd" class="form-control"
                                                            @if (isset($personCount)) value="{{ $personCount->count_phd }}" @else  value="0" @endif>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">* 學歷碩士</label>
                                                        <input type="number" name="count_master" class="form-control"
                                                            @if (isset($personCount)) value="{{ $personCount->count_master }}"  @else value="0" @endif>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">* 學歷學士</label>
                                                        <input type="number" name="count_bachelor" class="form-control"
                                                            @if (isset($personCount)) value="{{ $personCount->count_bachelor }}"  @else value="0" @endif>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">* 專科以下</label>
                                                        <input type="number" name="count_others" class="form-control"
                                                            @if (isset($personCount)) value="{{ $personCount->count_others }}"  @else value="0" @endif>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">* 男性</label>
                                                        <input type="number" name="count_male" class="form-control"
                                                            @if (isset($personCount)) value="{{ $personCount->count_male }}"  @else value="0" @endif>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">* 女性</label>
                                                        <input type="number" name="count_female" class="form-control"
                                                            @if (isset($personCount)) value="{{ $personCount->count_female }}"  @else value="0" @endif>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">* 待聘人數</label>
                                                        <input type="number" name="count_pending" class="form-control" 
                                                            @if (isset($personCount)) value="{{ $personCount->count_pending }}" @else value="0" @endif>
                                                    </div>
                                                </div>

                                                <!-- 按鈕 -->
                                                <div class="d-flex justify-content-start gap-2">
                                                    <div class="col-md-8">
                                                        <button type="submit" class="btn btn-teal btn-success">送出存檔</button>
                                                        <button type="button" class="btn btn-primary">回上一頁</button>
                                                    </div>
                                                    <!-- 匯出 Word 按鈕 -->
                                                    <div class="col-md-4 text-end">
                                                        <a href="{{ route('sbir.exportWord', $project->id) }}"
                                                            class="btn btn-danger ">
                                                            匯出計畫書 Word 檔
                                                        </a>
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
    @if (session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var successModal = new bootstrap.Modal(document.getElementById('success-btn'));
                successModal.show();
            });
        </script>
    @endif

    <!-- jQuery 先引入 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- 再引入 jQuery UI -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script>
       // 原本的「點工作項目」函式
  function addpointRow() {
    const tbody = document.getElementById('pointsTable').querySelector('tbody');
    const row = document.createElement('tr');
    row.innerHTML = `
      <td><input type="text" name="point_items[]" class="form-control" placeholder="如 A1.xxx"></td>
      <td><input type="text" name="point_weights[]" class="date form-control change_cal_date"></td>
      <td><input type="text" name="point_months[]" class="form-control"></td>
      <td><button class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()">刪除</button></td>
    `;
    tbody.appendChild(row);
  }

  // Helper：往 checkpointsTable 插入一列並填入 code
  function addCheckpointRowWithCode(code) {
    const tbody = document.getElementById('checkpointsTable').querySelector('tbody');
    const row = document.createElement('tr');
    row.innerHTML = `
      <td><input type="text" name="checkpoint_codes[]" class="form-control" value="${code}" ></td>
      <td><input type="text" name="checkpoint_dues[]" class="date form-control change_cal_date"></td>
      <td><input type="text" name="checkpoint_contents[]" class="form-control"></td>
      <td><button class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()">刪除</button></td>
    `;
    tbody.appendChild(row);
  }

  // 新增這個函式，讓「手動新增」按鈕可以運作
  function addCheckpointRow() {
    // 如果你希望每次手動新增時不帶 code，可以傳空字串
    addCheckpointRowWithCode('');
  }

  // 事件代理：監聽 pointsTable tbody 裡，point_items[] 欄位的 change
  document
    .getElementById('pointsTable')
    .querySelector('tbody')
    .addEventListener('change', function(e) {
      if (e.target.name === 'point_items[]') {
        const val = e.target.value.trim();
        // 只接受「字母＋數字＋.」開頭
        const m = val.match(/^([A-Za-z]\d+)\./);
        if (m) {
          addCheckpointRowWithCode(m[1]);
        }
      }
    });


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

        function updateStaffNumbers() {
            document.querySelectorAll('#staffTable .staff-number').forEach((cell, index) => {
                cell.textContent = index + 1;
            });
        }

        function addStaffRow() {
            const tbody = document.querySelector('#staffTable tbody');
            const row = document.createElement('tr');
            row.innerHTML = `
    <td class="staff-number"></td>
    <td><input type="text" name="staff_name[]" class="form-control"></td>
    <td><input type="text" name="staff_title[]" class="form-control"></td>
    <td>
      <select name="account_category[]" class="form-control">
        <option value="研發人員">研發人員</option>
        <option value="國際研發人員">國際研發人員</option>
        <option value="顧問">顧問</option>
      </select>
    </td>
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
    <td><button type="button" class="btn btn-danger" onclick="removeStaffRow(this)">刪除</button></td>
  `;
            tbody.appendChild(row);
            updateStaffNumbers();
        }

        function removeStaffRow(button) {
            button.closest('tr').remove();
            updateStaffNumbers();
        }

        document.addEventListener('DOMContentLoaded', updateStaffNumbers);

        function updateWaitStaffNumbers() {
            document.querySelectorAll('#waitStaffTable tbody tr').forEach((row, index) => {
                const numberCell = row.querySelector('td');
                if (numberCell) numberCell.textContent = index + 1;
            });
        }

        function addWaitStaffRow() {
            const table = document.getElementById('waitStaffTable').getElementsByTagName('tbody')[0];
            const newRow = table.insertRow();
            newRow.innerHTML = `
    <td></td>
    <td><input type="text" name="wait_staff_name[]" class="form-control"></td>
    <td><input type="text" name="wait_staff_title[]" class="form-control"></td>
    <td>
      <select name="wait_account_category[]" class="form-control">
        <option value="研發人員">研發人員</option>
        <option value="國際研發人員">國際研發人員</option>
        <option value="顧問">顧問</option>
      </select>
    </td>
    <td>
      <select name="wait_is_rnd[]" class="form-control">
        <option value="是">是</option>
        <option value="否">否</option>
      </select>
    </td>
    <td><input type="text" name="wait_education[]" class="form-control"></td>
    <td><input type="text" name="wait_experience[]" class="form-control"></td>
    <td><input type="text" name="wait_achievement[]" class="form-control"></td>
    <td><input type="text" name="wait_seniority[]" class="form-control"></td>
    <td><input type="text" name="wait_task[]" class="form-control"></td>
    <td><button type="button" class="btn btn-danger" onclick="this.closest('tr').remove(); updateWaitStaffNumbers()">刪除</button></td>
  `;
            updateWaitStaffNumbers();
        }

        document.addEventListener('DOMContentLoaded', updateWaitStaffNumbers);

        $('input.date').datepicker({
            dateFormat: 'yy/mm/dd' // Set the date format
        });

        $('#start_date').change(function() {
            var startDate = new Date($(this).val());
            startDate.setFullYear(startDate.getFullYear() + 1);
            startDate.setDate(startDate.getDate() - 1);

            var endYear = startDate.getFullYear();
            var endMonth = ("0" + (startDate.getMonth() + 1)).slice(-2); // JavaScript months are 0-indexed
            var endDate = ("0" + startDate.getDate()).slice(-2);

            var endDateString = `${endYear}-${endMonth}-${endDate}`;
            let endDateStringformattedDate = convertToROC(endDateString);
            $('#end_date').val(endDateStringformattedDate);
        });

        $(".change_cal_date").on("change keyup", function() {
            let inputValue = $(this).val(); // Get the input date value
            let formattedDate = convertToROC(inputValue); // Convert the date format
            $(this).val(formattedDate); // Update the input field value
        });

        function convertToROC(dateString) {
            dateString = dateString.replace(/[^0-9]/g, ''); // Remove non-numeric characters
            if (dateString.length === 8) {
                // Format is YYYYMMDD
                let year = parseInt(dateString.substr(0, 4)) - 1911;
                let month = dateString.substr(4, 2);
                let day = dateString.substr(6, 2);
                return `${year}/${month}/${day}`;
            } else if (dateString.length === 7) {
                // Format is YYYMMDD assuming it's already ROC year
                let year = parseInt(dateString.substr(0, 3));
                let month = dateString.substr(3, 2);
                let day = dateString.substr(5, 2);
                return `${year}/${month}/${day}`;
            }
            return dateString; // Return original string if it does not match expected lengths
        }
    </script>
@endsection
