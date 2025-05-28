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
                                <a href="{{ route('project.edit', $data->id) }}" aria-expanded="true"
                                    class="nav-link active">
                                    專案基本設定
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.task', $data->id) }}" aria-expanded="false" class="nav-link">
                                    派工作業
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.plan', $data->id) }}" aria-expanded="false"
                                    class="nav-link">
                                    排程作業
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.background', $data->id) }}" aria-expanded="false" class="nav-link ">
                                    專案背景調查
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.write', $data->id) }}" aria-expanded="false"
                                    class="nav-link">
                                    人事/帶動企業
                                </a>
                            </li>
                            @if($data->type == '3')
                            <li class="nav-item">
                                <a href="{{ route('project.sbir01', $data->id) }}" aria-expanded="false"
                                    class="nav-link">
                                    SBIR內容撰寫
                                </a>
                            </li>
                            @endif
                            <li class="nav-item">
                                <a href="{{ route('project.send', $data->id) }}" aria-expanded="false" class="nav-link">
                                    送件作業
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.midterm', $data->id) }}" aria-expanded="false" class="nav-link">
                                    期中報告/檢核
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.final', $data->id) }}" aria-expanded="false" class="nav-link">
                                    期末報告/結案
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.accounting', $data->id) }}" aria-expanded="false" class="nav-link">
                                    經費報表
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.meet', $data->id) }}" aria-expanded="false" class="nav-link">
                                    會議瀏覽
                                </a>
                            </li>
                        </ul>
                        <div id="success-btn" class="modal fade" tabindex="-1" aria-labelledby="success-btnLabel" aria-hidden="true"
            data-bs-scroll="true">
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
        <form action="{{ route('project.write.data',$project->id) }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        <h2>人事資料</h2>
                                        <p class="font-size-20 text-danger">所有人員皆須在勞保投保明細中</p>
                                    </div>
                                    <div class="row">
                                        <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">計畫主持人資料（計畫主持人需在公司為有營運決策權的專任人員）
                                        </h5>
                                        <div class="col-md-4">
                                            <label class="form-label" for="AddNew-Phone"><b>姓名</b></label>
                                            <input type="text" class="form-control required-input" name="host_name"
                                                @if (isset($project_host_data)) value="{{ $project_host_data->name }}" @endif>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" for="AddNew-Username"><b>部門</b></label>
                                            <input type="text" class="form-control required-input" name="host_department"
                                                @if (isset($project_host_data)) value="{{ $project_host_data->department }}" @endif>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" for="AddNew-Username"><b>職稱</b></label>
                                            <input type="text" class="form-control required-input" name="host_job"
                                                @if (isset($project_host_data)) value="{{ $project_host_data->job }}" @endif>
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label class="form-label" for="AddNew-Username"><b>工作內容</b></label>
                                            <input type="text" class="form-control required-input" name="host_context"
                                                @if (isset($project_host_data)) value="{{ $project_host_data->context }}" @endif>
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label class="form-label" for="AddNew-Username"><b>電話(含分機)</b></label>
                                            <input type="text" class="form-control required-input" name="host_mobile"
                                                @if (isset($project_host_data)) value="{{ $project_host_data->mobile }}" @endif>
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label class="form-label" for="AddNew-Username"><b>手機</b></label>
                                            <input type="text" class="form-control required-input" name="host_phone"
                                                @if (isset($project_host_data)) value="{{ $project_host_data->phone }}" @endif>
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label class="form-label" for="AddNew-Username"><b>信箱</b></label>
                                            <input type="text" class="form-control required-input" name="host_email"
                                                @if (isset($project_host_data)) value="{{ $project_host_data->email }}" @endif>
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label class="form-label" for="AddNew-Username"><b>實際薪資</b></label>
                                            <input type="text" class="form-control required-input" name="host_salary"
                                                @if (isset($project_host_data)) value="{{ $project_host_data->salary }}" @endif>
                                        </div>

                                        <hr class="mt-4 mb-4">

                                        <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">計畫聯絡人資料</h5>
                                        <div class="col-md-4">
                                            <label class="form-label" for="AddNew-Phone"><b>姓名</b></label>
                                            <input type="text" class="form-control required-input" name="contact_name"
                                                @if (isset($project_contact_data)) value="{{ $project_contact_data->name }}" @endif>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" for="AddNew-Username"><b>部門</b></label>
                                            <input type="text" class="form-control required-input"
                                                name="contact_department"
                                                @if (isset($project_contact_data)) value="{{ $project_contact_data->department }}" @endif>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" for="AddNew-Username"><b>職稱</b></label>
                                            <input type="text" class="form-control required-input" name="contact_job"
                                                @if (isset($project_contact_data)) value="{{ $project_contact_data->job }}" @endif>
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label class="form-label" for="AddNew-Username"><b>工作內容</b></label>
                                            <input type="text" class="form-control required-input" name="contact_context"
                                                @if (isset($project_contact_data)) value="{{ $project_contact_data->context }}" @endif>
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label class="form-label" for="AddNew-Username"><b>電話(含分機)</b></label>
                                            <input type="text" class="form-control required-input"
                                                name="contact_mobile"
                                                @if (isset($project_contact_data)) value="{{ $project_contact_data->mobile }}" @endif>
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label class="form-label" for="AddNew-Username"><b>手機</b></label>
                                            <input type="text" class="form-control required-input"
                                                name="contact_phone"
                                                @if (isset($project_contact_data)) value="{{ $project_contact_data->phone }}" @endif>
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label class="form-label" for="AddNew-Username"><b>信箱</b></label>
                                            <input type="text" class="form-control required-input"
                                                name="contact_email"
                                                @if (isset($project_contact_data)) value="{{ $project_contact_data->email }}" @endif>
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label class="form-label" for="AddNew-Username"><b>實際薪資</b></label>
                                            <input type="text" class="form-control required-input"
                                                name="contact_salary"
                                                @if (isset($project_contact_data)) value="{{ $project_contact_data->salary }}" @endif>
                                        </div>

                                        <hr class="mt-4 mb-4">

                                        <div class="col-md-12 mt-3">
                                            <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">
                                                人事名單（不含主持人及聯絡人，需再提供5-7位。因配合計畫申請，故薪資部分不一定會按填寫的實際薪資做編列））</h5>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <table id="preson" class="table preson-list">
                                                            <thead>
                                                                <tr align="center">
                                                                    <th>編號</th>
                                                                    <th>姓名<span class="text-danger">*</span></th>
                                                                    <th>部門<span class="text-danger">*</span></th>
                                                                    <th>職稱<span class="text-danger">*</span></th>
                                                                    <th>工作內容<span class="text-danger">*</span></th>
                                                                    <th>實際薪資<span class="text-danger">*</span></th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody valign="center" align="center">
                                                                @if (count($project->personnel_datas) > 0)
                                                                    @foreach ($project->personnel_datas as $key => $personnel_data)
                                                                        <tr id="row-{{ $key }}">
                                                                            <td>{{ $key + 1 }}</td>
                                                                            <td>
                                                                                <input id="pay_date-{{ $key }}"
                                                                                    class="mobile form-control required-input"
                                                                                    type="text"
                                                                                    name="personnel_names[]"
                                                                                    value="{{ $personnel_data->name }}">
                                                                            </td>
                                                                            <td>
                                                                                <input id="pay_date-{{ $key }}"
                                                                                    class="mobile form-control required-input"
                                                                                    type="text"
                                                                                    name="personnel_departments[]"
                                                                                    value="{{ $personnel_data->department }}">
                                                                            </td>
                                                                            <td>
                                                                                <input id="pay_price-{{ $key }}"
                                                                                    class="mobile form-control required-input"
                                                                                    type="text" name="personnel_jobs[]"
                                                                                    value="{{ $personnel_data->job }}">
                                                                            </td>
                                                                            <td>
                                                                                <input id="pay_price-{{ $key }}"
                                                                                    class="mobile form-control required-input"
                                                                                    type="text"
                                                                                    name="personnel_contexts[]"
                                                                                    value="{{ $personnel_data->context }}">
                                                                            </td>
                                                                            <td>
                                                                                <input id="pay_price-{{ $key }}"
                                                                                    class="mobile form-control required-input"
                                                                                    type="text"
                                                                                    name="personnel_salarys[]"
                                                                                    value="{{ $personnel_data->salary }}">
                                                                            </td>
                                                                            <td>
                                                                                <button
                                                                                    class="mobile btn btn-danger del-row"
                                                                                    alt="{{ $key }}"
                                                                                    type="button" name="button"
                                                                                    onclick="del_row(this)">刪除</button>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    @for ($i = 0; $i < 1; $i++)
                                                                        <tr id="row-{{ $i }}">
                                                                            <td>{{ $i + 1 }}</td>
                                                                            <td>
                                                                                <input id="pay_date-{{ $i }}"
                                                                                    class="mobile form-control required-input"
                                                                                    type="text"
                                                                                    name="personnel_names[]"
                                                                                    value="">
                                                                            </td>
                                                                            <td>
                                                                                <input id="pay_date-{{ $i }}"
                                                                                    class="mobile form-control required-input"
                                                                                    type="text"
                                                                                    name="personnel_departments[]"
                                                                                    value="">
                                                                            </td>
                                                                            <td>
                                                                                <input id="pay_price-{{ $i }}"
                                                                                    class="mobile form-control required-input"
                                                                                    type="text" name="personnel_jobs[]"
                                                                                    value="">
                                                                            </td>
                                                                            <td>
                                                                                <input id="pay_price-{{ $i }}"
                                                                                    class="mobile form-control required-input"
                                                                                    type="text"
                                                                                    name="personnel_contexts[]"
                                                                                    value="">
                                                                            </td>
                                                                            <td>
                                                                                <input id="pay_price-{{ $i }}"
                                                                                    class="mobile form-control required-input"
                                                                                    type="text"
                                                                                    name="personnel_salarys[]"
                                                                                    value="">
                                                                            </td>
                                                                            <td>
                                                                                <button
                                                                                    class="mobile btn btn-danger del-row"
                                                                                    alt="{{ $i }}"
                                                                                    type="button" name="button"
                                                                                    onclick="del_row(this)">刪除</button>
                                                                            </td>
                                                                        </tr>
                                                                    @endfor
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div> <!-- end .table-responsive -->
                                                    <div class="form-group row">
                                                        <div class="col-12">
                                                            <input id="add_preson" class="btn btn-primary" type="button"
                                                                name="" value="新增筆數">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        <h2>五家被帶動的企業</h2>
                                        <p class="font-size-18">申請計畫使用</p>
                                    </div>
                                    <div class="alert alert-danger" role="alert">
                                        1.被帶動企業主要是配合主提案商（貴公司）申請計畫。因計畫內要導入的方案，會需要主提案商跟被帶動企業都有使用到，減碳的成效在主提案商跟被帶動企業也都需要有呈現。<br>
                                        2.被帶動企業建議提供公司的「上游客戶」、「下游客戶」、「長期合作夥伴」，請提供同一種類型的被帶動企業。根據以往經驗，以這種方式提供資訊能夠減少提案簡報時被評審提問的情況，也有助於順利核銷。ex:全部都是「上游客戶」、全部都是「下游客戶」<br>
                                        3.被帶動企業請提供以下資料：(1)公司名稱（全名）、(2)統一編號、(3)負責人姓名（送件時需簽署合作意向書、(4)員工數<br>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mt-3">
                                            <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">
                                                企業名單(需至少提供5家被帶動企業，且被帶動企業越多越好，不一定只提供5家)</h5>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <table id="branch" class="table branch-list">
                                                            <thead>
                                                                <tr align="center">
                                                                    <th>編號</th>
                                                                    <th>上游/下游企業<span class="text-danger">*</span></th>
                                                                    <th>名稱<span class="text-danger">*</span></th>
                                                                    <th>統一編號<span class="text-danger">*</span></th>
                                                                    <th>負責人<span class="text-danger">*</span></th>
                                                                    <th>員工數<span class="text-danger">*</span></th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody valign="center" align="center">
                                                                @if (count($project->drive_datas) > 0)
                                                                    @foreach ($project->drive_datas as $key => $drive_data)
                                                                        <tr id="row-{{ $key }}">
                                                                            <td>{{ $key + 1 }}</td>
                                                                            <td>
                                                                                <select id="pay_date-{{ $key }}"
                                                                                    class="mobile form-select"
                                                                                    name="drive_types[]">
                                                                                    <option value="NULL"
                                                                                        @if ($drive_data->type == 'NULL') selected @endif>
                                                                                        請選擇...</option>
                                                                                    <option value="0"
                                                                                        @if ($drive_data->type == 0) selected @endif>
                                                                                        上游</option>
                                                                                    <option value="1"
                                                                                        @if ($drive_data->type == 1) selected @endif>
                                                                                        下游</option>
                                                                                    <option value="2"
                                                                                        @if ($drive_data->type == 2) selected @endif>
                                                                                        合作夥伴</option>
                                                                                    <option value="3"
                                                                                        @if ($drive_data->type == 3) selected @endif>
                                                                                        分店</option>
                                                                                </select>
                                                                            </td>
                                                                            <td>
                                                                                <input id="pay_date-{{ $key }}"
                                                                                    class="mobile form-control required-input"
                                                                                    type="text" name="drive_names[]"
                                                                                    value="{{ $drive_data->name }}">
                                                                            </td>
                                                                            <td>
                                                                                <input id="pay_date-{{ $key }}"
                                                                                    class="mobile form-control required-input"
                                                                                    type="text" name="drive_numbers[]"
                                                                                    value="{{ $drive_data->numbers }}">
                                                                            </td>
                                                                            <td>
                                                                                <input id="pay_price-{{ $key }}"
                                                                                    class="mobile form-control required-input"
                                                                                    type="text"
                                                                                    name="drive_principals[]"
                                                                                    value="{{ $drive_data->principal }}">
                                                                            </td>
                                                                            <td>
                                                                                <input id="pay_price-{{ $key }}"
                                                                                    class="mobile form-control required-input"
                                                                                    type="text"
                                                                                    name="drive_employeecounts[]"
                                                                                    value="{{ $drive_data->employeecount }}">
                                                                            </td>
                                                                            <td>
                                                                                <button
                                                                                    class="mobile btn btn-danger del-row"
                                                                                    alt="{{ $key }}"
                                                                                    type="button" name="button"
                                                                                    onclick="del_row(this)">刪除</button>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    @for ($i = 0; $i < 5; $i++)
                                                                        <tr id="row-{{ $i }}">
                                                                            <td>{{ $i + 1 }}</td>
                                                                            <td>
                                                                                <select id="pay_date-{{ $i }}"
                                                                                    class="mobile form-select"
                                                                                    name="drive_types[]">
                                                                                    <option value="" selected>請選擇...
                                                                                    </option>
                                                                                    <option value="0">上游</option>
                                                                                    <option value="1">下游</option>
                                                                                    <option value="2">合作夥伴</option>
                                                                                    <option value="3">分店</option>
                                                                                </select>
                                                                            </td>
                                                                            <td>
                                                                                <input id="pay_date-{{ $i }}"
                                                                                    class="mobile form-control required-input"
                                                                                    type="text" name="drive_names[]"
                                                                                    value="">
                                                                            </td>
                                                                            <td>
                                                                                <input id="pay_date-{{ $i }}"
                                                                                    class="mobile form-control required-input"
                                                                                    type="text" name="drive_numbers[]"
                                                                                    value="">
                                                                            </td>
                                                                            <td>
                                                                                <input id="pay_price-{{ $i }}"
                                                                                    class="mobile form-control required-input"
                                                                                    type="text"
                                                                                    name="drive_principals[]"
                                                                                    value="">
                                                                            </td>
                                                                            <td>
                                                                                <input id="pay_price-{{ $i }}"
                                                                                    class="mobile form-control required-input"
                                                                                    type="text"
                                                                                    name="drive_employeecounts[]"
                                                                                    value="">
                                                                            </td>
                                                                            <td>
                                                                                <button
                                                                                    class="mobile btn btn-danger del-row"
                                                                                    alt="{{ $i }}"
                                                                                    type="button" name="button"
                                                                                    onclick="del_row(this)">刪除</button>
                                                                            </td>
                                                                        </tr>
                                                                    @endfor
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div> <!-- end .table-responsive -->
                                                    <div class="form-group row">
                                                        <div class="col-12">
                                                            <input id="add_branch" class="btn btn-primary" type="button"
                                                                name="" value="新增筆數">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        <h2>現況</h2>
                                        <p class="font-size-18">申請計畫使用</p>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mt-1">
                                            <div class="alert alert-danger" role="alert">
                                                公司現在原有的系統有哪些？請簡述系統及購入客戶（ex：採購系統、電商平台等）
                                            </div>
                                            <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">現況列表</h5>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <table id="situation" class="table situation-list">
                                                            <thead>
                                                                <tr align="center">
                                                                    <th>簡述內容<span class="text-danger">*</span></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody valign="center" align="center">
                                                                @if (count($project->situation_datas) > 0)
                                                                    @foreach ($project->situation_datas as $key => $situation_data)
                                                                        <tr id="row-{{ $key }}" valign="middle">
                                                                            <td width="90%">
                                                                                <textarea class="form-control required-input" name="situation_contexts[]" rows="5">{{ $situation_data->context }}</textarea>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    @for ($i = 0; $i < 1; $i++)
                                                                        <tr id="row-{{ $i }}" valign="middle">
                                                                            <td width="90%">
                                                                                <textarea class="form-control required-input" name="situation_contexts[]" rows="5"></textarea>
                                                                            </td>
                                                                        </tr>
                                                                    @endfor
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div> <!-- end .table-responsive -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        <h2>需求</h2>
                                        <p class="font-size-18">申請計畫使用</p>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mt-1">
                                            <div class="alert alert-danger" role="alert">
                                                此次預計導入的系統有哪些？請簡述系統及預計購入客戶
                                                （ex：採購系統、電商平台等）
                                                並請針對想更新或汰換的系統或設備進行排序
                                            </div>
                                            <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">需求列表</h5>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <table id="need" class="table need-list">
                                                            <thead>
                                                                <tr align="center">
                                                                    <th>編號</th>
                                                                    <th>系統名稱<span class="text-danger">*</span></th>
                                                                    <th>內容簡述</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody valign="center" align="center">
                                                                @if (count($project->need_datas) > 0)
                                                                    @foreach ($project->need_datas as $key => $need_data)
                                                                        <tr id="row-{{ $key }}">
                                                                            <td>{{ $key + 1 }}</td>
                                                                            <td>
                                                                                <input id="pay_date-{{ $key }}"
                                                                                    class="mobile form-control required-input"
                                                                                    type="text" name="need_names[]"
                                                                                    value="{{ $need_data->name }}">
                                                                            </td>
                                                                            <td>
                                                                                <input id="pay_date-{{ $key }}"
                                                                                    class="mobile form-control required-input"
                                                                                    type="text" name="need_contexts[]"
                                                                                    value="{{ $need_data->context }}">
                                                                            </td>
                                                                            <td>
                                                                                <button
                                                                                    class="mobile btn btn-danger del-row"
                                                                                    alt="{{ $key }}"
                                                                                    type="button" name="button"
                                                                                    onclick="del_row(this)">刪除</button>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    @for ($i = 0; $i < 1; $i++)
                                                                        <tr id="row-{{ $i }}">
                                                                            <td>{{ $i + 1 }}</td>
                                                                            <td>
                                                                                <input id="pay_date-{{ $i }}"
                                                                                    class="mobile form-control required-input"
                                                                                    type="text" name="need_names[]"
                                                                                    value="">
                                                                            </td>
                                                                            <td>
                                                                                <input id="pay_date-{{ $i }}"
                                                                                    class="mobile form-control required-input"
                                                                                    type="text" name="need_contexts[]"
                                                                                    value="">
                                                                            </td>
                                                                            <td>
                                                                                <button
                                                                                    class="mobile btn btn-danger del-row"
                                                                                    alt="{{ $i }}"
                                                                                    type="button" name="button"
                                                                                    onclick="del_row(this)">刪除</button>
                                                                            </td>
                                                                        </tr>
                                                                    @endfor
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div> <!-- end .table-responsive -->
                                                    <div class="form-group row">
                                                        <div class="col-12">
                                                            <input id="add_need" class="btn btn-primary" type="button"
                                                                name="" value="新增筆數">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4 mb-2">
                                <div class="col text-center">
                                    <button class="btn btn-success" type="submit" id="btn_storage"><i
                                            class="bx bx-file me-1"></i> 確認儲存 </button>

                                    <a href="{{ route('business.appendix',$project->id) }}">
                                        <button class="btn btn-primary" type="button" id="btn_submit"><i
                                                class=" bx bx-check me-1"></i> 查看附件 </button>
                                    </a>
                                </div> <!-- end col -->
                            </div>

        </form>


    </div> <!-- end row-->

    </div>
                <!-- end row -->

                </form>
            </div> <!-- end card-body -->
        </div> <!-- end card-->
        <!-- end row -->

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
        $(document).ready(function() {
            $(".twzipcode").twzipcode({
                css: ["twzipcode-select", "twzipcode-select", "twzipcode-hidden"], // 自訂 "城市"、"地區" class 名稱 
                countyName: "county", // 自訂城市 select 標籤的 name 值
                districtName: "district", // 自訂地區 select 標籤的 name 值
            });

            @if (session('success'))
                $('#success-btn').modal('show');
            @endif
        });



        $(document).ready(function() {
            var socailRowCount = $('#socail tbody tr').length;

            $('#add_socail').click(function() {
                socailRowCount++;
                var newRow = `<tr id="row-${socailRowCount}">
                                    <td>
                                        ${socailRowCount}
                                    </td>
                                    <td>
                                        <select id="gdpaper_id_${socailRowCount}" alt="${socailRowCount}" class="mobile form-select" name="socail_types[]">
                                            <option value="" selected>請選擇...</option>
                                            <option value="0">網站</option>
                                            <option value="1">社群</option>
                                            <option value="2">其他</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input id="department-${socailRowCount}" class="mobile form-control required-input" type="text" name="socail_contexts[]" value="" required>
                                    </td>
                                    <td>
                                        <button class="mobile btn btn-danger del-row" alt="${socailRowCount}" type="button" name="button">刪除</button>
                                    </td>
                                </tr>`;
                $('#socail tbody').append(newRow);
            });

            // Event delegation for dynamically added elements
            $('#socail').on('click', '.del-row', function() {
                $(this).closest('tr').remove();
                socailRowCount--;
            });


            var presonRowCount = $('#preson tbody tr').length;

            $('#add_preson').click(function() {
                presonRowCount++;
                var newRow = `<tr id="row-${presonRowCount}" >
                                <td>${presonRowCount}</td>
                                <td>
                                    <input id="pay_date-${presonRowCount}" class="mobile form-control required-input" type="text" name="personnel_names[]" value="">
                                </td>
                                <td>
                                    <input id="pay_date-${presonRowCount}" class="mobile form-control required-input" type="text" name="personnel_departments[]" value="">
                                </td>
                                <td>
                                    <input id="pay_price-${presonRowCount}" class="mobile form-control required-input" type="text" name="personnel_jobs[]" value="">
                                </td>
                                <td>
                                    <input id="pay_price-${presonRowCount}" class="mobile form-control required-input" type="text" name="personnel_contexts[]" value="">
                                </td>
                                <td>
                                    <input id="pay_price-${presonRowCount}" class="mobile form-control required-input" type="text" name="personnel_salarys[]" value="">
                                </td>
                                <td>
                                    <button class="mobile btn btn-danger del-row" alt="${presonRowCount}" type="button" name="button" onclick="del_row(this)">刪除</button>
                                </td>
                            </tr>`;
                $('#preson tbody').append(newRow);
            });

            // Event delegation for dynamically added elements
            $('#preson').on('click', '.del-row', function() {
                $(this).closest('tr').remove();
                presonRowCount--;
            });
        });

        var branchRowCount = $('#branch tbody tr').length;


        $('#add_branch').click(function() {
            branchRowCount++;
            var newRow = `<tr id="row-${branchRowCount}">
                            <td>
                                ${branchRowCount}
                            </td>
                            <td>
                                <select id="pay_date-${branchRowCount}" class="mobile form-select" name="drive_types[]">
                                    <option value="" selected>請選擇...</option>
                                    <option value="0">上游</option>
                                    <option value="1">下游</option>
                                    <option value="2">合作夥伴</option>
                                    <option value="3">分店</option>
                                </select>
                            </td>
                            <td>
                                <input id="pay_date-${branchRowCount}" class="mobile form-control required-input" type="text" name="drive_names[]" value="" >
                            </td>
                            <td>
                                <input id="department-${branchRowCount}" class="mobile form-control required-input" type="text" name="drive_numbers[]" value="" >
                            </td>
                            <td>
                                <input id="title-${branchRowCount}" class="mobile form-control required-input" type="text" name="drive_principals[]" value="" >
                            </td>
                            <td>
                                <input id="work_content-${branchRowCount}" class="mobile form-control required-input" type="text" name="drive_employeecounts[]" value="" >
                            </td>
                            <td>
                                <button class="mobile btn btn-danger del-row" alt="${branchRowCount}" type="button" name="button">刪除</button>
                            </td>
                         </tr>`;
            $('#branch tbody').append(newRow);
        });

        // Event delegation for dynamically added elements
        $('#branch').on('click', '.del-row', function() {
            if (branchRowCount > 5) {
                $(this).closest('tr').remove();
                branchRowCount--;
            } else {
                alert('需至少提供5家被帶動企業');
            }

        });

        var needRowCount = $('#need tbody tr').length;

        $('#add_need').click(function() {
            needRowCount++;
            var newRow = `<tr id="row-${needRowCount}">
                                <td>
                                    ${needRowCount}
                                </td>
                                <td>
                                    <input id="pay_date-${needRowCount}" class="mobile form-control required-input" type="text" name="need_names[]" value="">
                                </td>
                                <td>
                                    <input id="department-${needRowCount}" class="mobile form-control required-input" type="text" name="need_contexts[]" value="">
                                </td>
                                <td>
                                    <button class="mobile btn btn-danger del-row" alt="${needRowCount}" type="button" name="button">刪除</button>
                                </td>
                            </tr>`;
            $('#need tbody').append(newRow);
        });

        // Event delegation for dynamically added elements
        $('#need').on('click', '.del-row', function() {
            $(this).closest('tr').remove();
            needRowCount--;
        });

        var situationRowCount = $('#situation tbody tr').length;

        $('#add_situation').click(function() {
            situationRowCount++;
            var newRow = `<tr id="row-${situationRowCount}" valign="middle">
                                <td width="90%">
                                    <textarea  class="form-control required-input" name="situation_contexts[]" rows="2"></textarea>
                                </td>
                                <td>
                                    <button class="mobile btn btn-danger del-row" alt="${situationRowCount}" type="button" name="button">刪除</button>
                                </td>
                            </tr>`;
            $('#situation tbody').append(newRow);
            checkRequiredFields();
        });

        // Event delegation for dynamically added elements
        $('#situation').on('click', '.del-row', function() {
            $(this).closest('tr').remove();
            situationRowCount--;
        });

        function updateTotal() {
            var maleCount = parseInt($('#insurance_male').val()) || 0;
            var femaleCount = parseInt($('#insurance_female').val()) || 0;
            $('#insurance_total').val(maleCount + femaleCount);
        }

        // 為 insurance_male 和 insurance_female 欄位添加 change 事件監聽器
        $('#insurance_male, #insurance_female').on('change', function() {
            updateTotal();
        });
    </script>
@endsection
