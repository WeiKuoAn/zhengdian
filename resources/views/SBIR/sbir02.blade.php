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
            <form action="{{ route('project.sbir02.data', $project->id) }}" method="POST">
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
                                                <a href="{{ route('project.sbir02', $project->id) }}"
                                                    class="nav-link active">
                                                    貳、計畫申請表
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir03', $project->id) }}" class="nav-link">
                                                    參、計畫摘要表
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir04', $project->id) }}" class="nav-link">
                                                    肆、公司概況
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir05', $project->id) }}" class="nav-link">
                                                    伍、研發動機
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir06', $project->id) }}" class="nav-link">
                                                    陸、計畫目標
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir07', $project->id) }}" class="nav-link">
                                                    柒、實施方式
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir08', $project->id) }}" class="nav-link">
                                                    捌、智財分析
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir09', $project->id) }}" class="nav-link">
                                                    玖、計畫執行查核點說明
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir10', $project->id) }}" class="nav-link">
                                                    拾、經費需求
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.appendix', $project->id) }}" class="nav-link">
                                                    附件
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.supplement', $project->id) }}" class="nav-link">
                                                    補充資料
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="card-body">
                                            <div class="mb-5">
                                                <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">1. 公司基本資料</h5>
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label">公司統一編號<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="registration_no"
                                                            value="{{ old('registration_no', $cust_data->registration_no ?? '') }}"
                                                            readonly>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">公司名稱<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="company_name"
                                                            name="name"
                                                            value="{{ old('name', $user_data->name ?? '') }}" readonly>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">核准設立日期<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control date change_cal_date"
                                                            name="create_date"
                                                            @if (isset($cust_data->create_date)) value="{{ $cust_data->create_date }}" @endif>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">最後核准變更日期</label>
                                                        <input type="text" class="date form-control change_cal_date"
                                                            @if (isset($cust_data->update_date)) value="{{ $cust_data->update_date }}" @endif
                                                            name="update_date">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">公司聯絡電話<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="mobile"
                                                            @if (isset($cust_data)) value="{{ $cust_data->mobile }}" @endif>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">公司傳真號碼<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="fax"
                                                            @if (isset($cust_data)) value="{{ $cust_data->fax }}" @endif>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">負責人<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="principal_name"
                                                            @if (isset($cust_data)) value="{{ $cust_data->principal_name }}" @endif>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">身分證字號<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            @if (isset($cust_data)) value="{{ $cust_data->id_card }}" @endif
                                                            name="id_card">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">出生年月日<span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="date form-control change_cal_date"
                                                            name="birthday"
                                                            @if (isset($cust_data)) value="{{ $cust_data->birthday }}" @endif>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">實收資本額(千元)<span
                                                                class="text-danger">*</span></label>
                                                        <input type="number" class="form-control" name="capital"
                                                            @if (isset($cust_data)) value="{{ $cust_data->capital }}" @endif>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">前一年度營業額(千元)<span
                                                                class="text-danger">*</span></label>
                                                        <input type="number" class="form-control"
                                                            name="last_year_revenue"
                                                            @if (isset($cust_data)) value="{{ $cust_data->last_year_revenue }}" @endif>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">純益率(%)</label>
                                                        <input type="number" class="form-control" name="profit_margin"
                                                            @if (isset($cust_data)) value="{{ $cust_data->profit_margin }}" @endif>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">員工人數<span
                                                                class="text-danger">*</span></label>
                                                        <input type="number" class="form-control"
                                                            name="insured_employees"
                                                            @if (isset($cust_data)) value="{{ $cust_data->insured_employees }}" @endif>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label">
                                                            主要產品或服務<span class="text-danger">*</span>（50個字以下）
                                                        </label>
                                                        <textarea class="form-control" id="serve" name="serve" rows="2" maxlength="50">
@if (isset($sbir02_data))
{{ $sbir02_data->serve }}
@endif
</textarea>
                                                        <div class="form-text text-end">
                                                            <span id="serve_count">0</span> / 50 字
                                                        </div>
                                                    </div>
                                                    <!-- 公司登記地址 -->
                                                    <div class="col-md-12">
                                                        <label class="form-label">登記地址<span
                                                                class="text-danger">*</span></label>
                                                        <div>
                                                            <div class="col-2 d-inline-block">
                                                                <input type="text" class="form-control" name="zipcode"
                                                                    placeholder="郵遞區號（3+3）"
                                                                    @if (isset($cust_data)) value="{{ $cust_data->zipcode }}" @endif>
                                                            </div>
                                                            <div class="col-2 d-inline-block">
                                                                <select id="company_county" name="county"
                                                                    class="form-select col-4">
                                                                    <option value="">請選擇縣市</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-3 d-inline-block">
                                                                <select id="company_district" name="district"
                                                                    class="form-select col-4">
                                                                    <option value="">請選擇區域</option>
                                                                </select>
                                                            </div>
                                                            <input type="hidden" name="company_zipcode"
                                                                id="company_zipcode">
                                                            <div class="col-4 d-inline-block">
                                                                <input type="text" class="form-control" name="address"
                                                                    placeholder="輸入地址" value="{{ $cust_data->address }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- 工廠登記地址 -->
                                                    <div class="col-md-12">
                                                        <label class="form-label">通訊地址<span
                                                                class="text-danger">*</span></label>
                                                        <div>
                                                            <div class="col-2 d-inline-block">
                                                                <input type="text" class="form-control"
                                                                    name="contact_zipcode" placeholder="郵遞區號（3+3）"
                                                                    @if (isset($sbir02_data)) value="{{ $sbir02_data->contact_zipcode }}" @endif>
                                                            </div>
                                                            <div class="col-2 d-inline-block">
                                                                <select id="contact_county" name="contact_county"
                                                                    class="form-select col-4">
                                                                    <option value="">請選擇縣市</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-3 d-inline-block">
                                                                <select id="contact_district" name="contact_district"
                                                                    class="form-select col-4">
                                                                    <option value="">請選擇區域</option>
                                                                </select>
                                                            </div>
                                                            <input type="hidden"id="contact_zipcode">
                                                            <div class="col-4 d-inline-block">
                                                                <input type="text" class="form-control"
                                                                    name="contact_address" placeholder="輸入地址"
                                                                    @if (isset($sbir02_data)) value="{{ $sbir02_data->contact_address }}" @endif>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label">研發單位地址</label>
                                                        <input type="text" class="form-control" name="rd_zipcode"
                                                            @if (isset($sbir02_data)) value="{{ $sbir02_data->rd_zipcode }}" @endif
                                                            placeholder="郵遞區號">
                                                    </div>
                                                    <div class="col-md-9">
                                                        <label class="form-label">&nbsp;</label>
                                                        <input type="text" class="form-control" name="rd_address"
                                                            @if (isset($sbir02_data)) value="{{ $sbir02_data->rd_address }}" @endif
                                                            placeholder="請輸入完整地址">
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <!-- 工廠資料表格（保留原本） -->
                                            <div class="mt-3 mb-4">
                                                <h5 class="text-uppercase bg-light p-2 mt-0 mb-3"><b>工廠資料</b></h5>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="factoryTable">
                                                        <thead>
                                                            <tr>
                                                                <th>選取設定</th>
                                                                <th>郵遞區號</th>
                                                                <th>工廠名稱</th>
                                                                <th>地址</th>
                                                                <th>登記編號</th>
                                                                <th>操作</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="factoryBody">
                                                            <!-- 動態新增列 -->
                                                            @if (count($cust_factorys) > 0)
                                                                @foreach ($cust_factorys as $index => $cust_factory)
                                                                    <tr>
                                                                        <td><select name="setting[]" class="form-control">
                                                                                <option value="是"
                                                                                    @if ($cust_factory->setting == '是') selected @endif>
                                                                                    是</option>
                                                                                <option value="否"
                                                                                    @if ($cust_factory->setting == '否') selected @endif>
                                                                                    否</option>
                                                                            </select></td>
                                                                        <td><input type="text" class="form-control"
                                                                                name="factory_zipcodes[]"
                                                                                value="{{ $cust_factory->zipcode }}">
                                                                        </td>
                                                                        <td><input type="text" class="form-control"
                                                                                name="factory_names[]"
                                                                                value="{{ $cust_factory->name }}"></td>
                                                                        <td><input type="text" class="form-control"
                                                                                name="factory_address[]"
                                                                                value="{{ $cust_factory->address }}">
                                                                        </td>
                                                                        <td><input type="text" class="form-control"
                                                                                name="factory_numbers[]"
                                                                                value="{{ $cust_factory->number }}">
                                                                        </td>
                                                                        <td><button type="button"
                                                                                class="btn btn-danger btn-sm"
                                                                                onclick="this.closest('tr').remove()">刪除</button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <button type="button" class="btn btn-primary"
                                                    onclick="addFactoryRow()">新增工廠資料</button>
                                            </div>

                                            <hr>

                                            <!-- 3. 青創與技術內容 -->
                                            <div class="mb-4">
                                                <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">3. 青創與技術內容</h5>
                                                <div class="row g-3">
                                                    <div class="col-md-12">
                                                        <label class="form-label">是否屬於青創企業</label>
                                                        <select class="form-select" name="youth_startup">
                                                            <option value="">請選擇</option>
                                                            <option value="yes"
                                                                @if (optional($sbir02_data)->youth_startup == 'yes') selected @endif>是
                                                            </option>
                                                            <option value="no"
                                                                @if (optional($sbir02_data)->youth_startup == 'no') selected @endif>否
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="form-label">是否參與過其他政府機關輔導計畫</label>
                                                        <select class="form-select" name="government_support">
                                                            <option value="">請選擇</option>
                                                            <option value="yes"
                                                                @if (optional($sbir02_data)->government_support == 'yes') selected @endif>是
                                                            </option>
                                                            <option value="no"
                                                                @if (optional($sbir02_data)->government_support == 'no') selected @endif>否
                                                            </option>

                                                        </select>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="form-label">
                                                            計畫創新技術或服務內容（500字以內）
                                                        </label>
                                                        <textarea class="form-control" id="context" name="context" rows="5" maxlength="500">{{ optional($sbir02_data)->context }}</textarea>
                                                        <div class="form-text text-end">
                                                            <span id="context_count">0</span> / 500 字
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="form-label">是否具有技術研發能力</label>
                                                        <select class="form-select" name="has_rnd">
                                                            <option value="">請選擇</option>
                                                            <option value="yes"
                                                                @if (optional($sbir02_data)->has_rnd == 'yes') selected @endif>是
                                                            </option>
                                                            <option value="no">
                                                                @if (optional($sbir02_data)->has_rnd == 'no')
                                                                    selected
                                                                @endif否
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <!-- 4. 計畫參與人員聯絡資訊 -->
                                            <div class="mb-5">
                                                <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">4. 計畫參與人員聯絡資訊</h5>

                                                <div class="mb-4">
                                                    <h6>計畫主持人</h6>
                                                    <div class="row g-2">
                                                        <div class="col-md-2">
                                                            <label class="form-label">姓名</label>
                                                            <input type="text" class="form-control required-input"
                                                                name="host_name"
                                                                @if (isset($project_host_data)) value="{{ $project_host_data->name }}" @endif>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="form-label">聯絡電話</label>
                                                            <input type="text" class="form-control required-input"
                                                                name="host_mobile"
                                                                @if (isset($project_host_data)) value="{{ $project_host_data->mobile }}" @endif>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="form-label">行動電話</label>
                                                            <input type="text" class="form-control required-input"
                                                                name="host_phone"
                                                                @if (isset($project_host_data)) value="{{ $project_host_data->phone }}" @endif>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="form-label">傳真號碼</label>
                                                            <input type="text" class="form-control required-input"
                                                                name="host_fax"
                                                                @if (isset($project_host_data)) value="{{ $project_host_data->fax }}" @endif>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label">電子信箱</label>
                                                            <input type="text" class="form-control required-input"
                                                                name="host_email"
                                                                @if (isset($project_host_data)) value="{{ $project_host_data->email }}" @endif>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-4">
                                                    <h6>計畫聯絡人</h6>
                                                    <div class="row g-2">
                                                        <div class="col-md-2">
                                                            <label class="form-label">姓名</label>
                                                            <input type="text" class="form-control required-input"
                                                                name="contact_name"
                                                                @if (isset($project_contact_data)) value="{{ $project_contact_data->name }}" @endif>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="form-label">聯絡電話</label>
                                                            <input type="text" class="form-control required-input"
                                                                name="contact_mobile"
                                                                @if (isset($project_contact_data)) value="{{ $project_contact_data->mobile }}" @endif>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="form-label">行動電話</label>
                                                            <input type="text" class="form-control required-input"
                                                                name="contact_phone"
                                                                @if (isset($project_contact_data)) value="{{ $project_contact_data->phone }}" @endif>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="form-label">傳真號碼</label>
                                                            <input type="text" class="form-control required-input"
                                                                name="contact_fax"
                                                                @if (isset($project_contact_data)) value="{{ $project_contact_data->fax }}" @endif>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label">電子信箱</label>
                                                            <input type="text" class="form-control required-input"
                                                                name="contact_email"
                                                                @if (isset($project_contact_data)) value="{{ $project_contact_data->email }}" @endif>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-4">
                                                    <h6>計畫專責財務會計</h6>
                                                    <div class="row g-2">
                                                        <div class="col-md-2">
                                                            <label class="form-label">姓名</label>
                                                            <input type="text" class="form-control required-input"
                                                                name="accounting_name"
                                                                @if (isset($project_accounting_data)) value="{{ $project_accounting_data->name }}" @endif>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="form-label">聯絡電話( )#分機</label>
                                                            <input type="text" class="form-control required-input"
                                                                name="accounting_mobile"
                                                                @if (isset($project_accounting_data)) value="{{ $project_accounting_data->mobile }}" @endif>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="form-label">行動電話</label>
                                                            <input type="text" class="form-control required-input"
                                                                name="accounting_phone"
                                                                @if (isset($project_accounting_data)) value="{{ $project_accounting_data->phone }}" @endif>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="form-label">傳真號碼</label>
                                                            <input type="text" class="form-control required-input"
                                                                name="accounting_fax"
                                                                @if (isset($project_accounting_data)) value="{{ $project_accounting_data->fax }}" @endif>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label">電子信箱</label>
                                                            <input type="text" class="form-control required-input"
                                                                name="accounting_email"
                                                                @if (isset($project_accounting_data)) value="{{ $project_accounting_data->email }}" @endif>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


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
        function addFactoryRow() {
            const tbody = document.getElementById('factoryBody');
            const row = document.createElement('tr');

            row.innerHTML = `
            <td><select name="setting[]" class="form-control">
                <option value="是" selected>是</option>
                <option value="否">否</option>
            </select></td>
      <td><input type="text" class="form-control" name="factory_zipcodes[]" placeholder="請輸入郵遞區號" required></td>
      <td><input type="text" class="form-control" name="factory_names[]" placeholder="請輸入工廠名稱" required></td>
      <td><input type="text" class="form-control" name="factory_address[]" placeholder="請輸入地址" required></td>
      <td><input type="text" class="form-control" name="factory_numbers[]" placeholder="請輸入登記編號" required></td>
      <td><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()">刪除</button></td>
    `;

            tbody.appendChild(row);
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // 讀取 JSON 檔案
            fetch("/json/city.json") // 👈 確保路徑正確，符合你的 public 資料夾位置
                .then(response => response.json())
                .then(jsonData => {
                    function populateCounties(selectElement, selectedCounty) {
                        selectElement.innerHTML = '<option value="">請選擇縣市</option>';
                        jsonData.forEach(city => {
                            let option = document.createElement("option");
                            option.value = city.CityName;
                            option.textContent = city.CityName;
                            if (selectedCounty && city.CityName === selectedCounty) {
                                option.selected = true;
                            }
                            selectElement.appendChild(option);
                        });
                    }

                    function populateDistricts(countySelect, districtSelect, zipcodeInput, selectedDistrict) {
                        let selectedCounty = countySelect.value;
                        districtSelect.innerHTML = '<option value="">請選擇區域</option>';

                        let cityData = jsonData.find(city => city.CityName === selectedCounty);
                        if (cityData) {
                            cityData.AreaList.forEach(area => {
                                let option = document.createElement("option");
                                option.value = area.AreaName;
                                option.textContent = area.AreaName;
                                if (selectedDistrict && area.AreaName === selectedDistrict) {
                                    option.selected = true;
                                    zipcodeInput.value = area.ZipCode;
                                }
                                districtSelect.appendChild(option);
                            });
                        }

                        // 當區域變更時，自動填充郵遞區號
                        districtSelect.addEventListener("change", function() {
                            let selectedDistrict = districtSelect.value;
                            let areaData = cityData.AreaList.find(area => area.AreaName ===
                                selectedDistrict);
                            zipcodeInput.value = areaData ? areaData.ZipCode : "";
                        });
                    }

                    function setupCountyDistrict(countyId, districtId, zipcodeId, selectedCounty,
                        selectedDistrict) {
                        let countySelect = document.getElementById(countyId);
                        let districtSelect = document.getElementById(districtId);
                        let zipcodeInput = document.getElementById(zipcodeId);

                        // 填充縣市選單
                        populateCounties(countySelect, selectedCounty);

                        // 如果已經有選定的縣市，則加載區域
                        if (selectedCounty) {
                            populateDistricts(countySelect, districtSelect, zipcodeInput, selectedDistrict);
                        }

                        // 當縣市變更時，載入對應區域
                        countySelect.addEventListener("change", function() {
                            populateDistricts(countySelect, districtSelect, zipcodeInput, "");
                        });
                    }

                    // ✅ 設定「公司登記地址」
                    setupCountyDistrict(
                        "company_county",
                        "company_district",
                        "company_zipcode",
                        "{{ $cust_data->county }}",
                        "{{ $cust_data->district }}"
                    );

                    // ✅ 設定「工廠登記地址」
                    setupCountyDistrict(
                        "contact_county",
                        "contact_district",
                        "contact_zipcode",
                        "{{ $sbir02_data->contact_county ?? '' }}",
                        "{{ $sbir02_data->contact_district ?? '' }}"
                    );

                    console.log("✅ 縣市區域選單載入完成！");
                })
                .catch(error => console.error("❌ 無法載入 JSON:", error));
        });

        $('input.date').datepicker({
            dateFormat: 'yy/mm/dd' // Set the date format
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
    <script>
        document.querySelectorAll('textarea[id]').forEach(textarea => {
            const maxLen = parseInt(textarea.getAttribute('maxlength'), 10);
            const countEl = document.getElementById(textarea.id + '_count');

            function updateCount() {
                const len = textarea.value.trim().length;
                countEl.textContent = len;
                // maxlength 會自動阻止超過 maxLen
            }

            textarea.addEventListener('input', updateCount);
            updateCount();
        });
    </script>
@endsection
