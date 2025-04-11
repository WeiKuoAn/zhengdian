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
                                                <a href="{{ route('project.sbir04', $project->id) }}"
                                                    class="nav-link active">
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
                                                <a href="{{ route('project.sbir07', $project->id) }}" class="nav-link">
                                                    附件
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="card-body">
                                            <div class="mb-5">
                                                <h5 class="text-uppercase bg-light p-2 mt-3 mb-3">董監事持股比例</h5>
                                                <div class="mb-3">
                                                    <table class="table table-bordered" id="shareholdersTable">
                                                        <thead>
                                                            <tr>
                                                                <th>董監事或其他負責人</th>
                                                                <th>持有股份</th>
                                                                <th>持股比例 (%)</th>
                                                                <th>資料來源</th>
                                                                <th>操作</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if (count($sbir04_shareholders) > 0)
                                                                @foreach ($sbir04_shareholders as $shareholder)
                                                                    <tr>
                                                                        <td><input type="text"
                                                                                name="shareholder_name[]"
                                                                                class="form-control"
                                                                                value="{{ $shareholder->shareholder_name }}">
                                                                        </td>
                                                                        <td><input type="number"
                                                                                name="shareholder_amount[]"
                                                                                class="form-control"
                                                                                value="{{ $shareholder->shareholder_amount }}">
                                                                        </td>
                                                                        <td><input type="number"
                                                                                name="shareholder_ratio[]"
                                                                                class="form-control"
                                                                                value="{{ $shareholder->shareholder_ratio }}">
                                                                        </td>
                                                                        <td><input type="text"
                                                                                name="shareholder_source[]"
                                                                                class="form-control"
                                                                                value="{{ $shareholder->shareholder_source }}">
                                                                        </td>
                                                                        <td><button class="btn btn-danger"
                                                                                onclick="this.closest('tr').remove()">刪除</button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                    <button class="btn btn-secondary" type="button"
                                                        onclick="addShareholderRow()">新增資料</button>
                                                </div>

                                                <hr>
                                                <h5 class="text-uppercase bg-light p-2 mt-3 mb-3">公司主營三年資料</h5>
                                                <div class="mb-3">
                                                    <table class="table table-bordered" id="threeYearTable">
                                                        <thead>
                                                            <tr>
                                                                <th>年度</th>
                                                                <th>營業額(千元)</th>
                                                                <th>研發費用(千元)</th>
                                                                <th>(B/A)%</th>
                                                                <th>說明</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if (count($sbir04_three_years) > 0)
                                                                @foreach ($sbir04_three_years as $three_year)
                                                                    <tr>
                                                                        <td><input type="number" name="year[]"
                                                                                class="form-control"
                                                                                value="{{ $three_year->year }}"></td>
                                                                        <td><input type="number" name="revenue[]"
                                                                                class="form-control"
                                                                                value="{{ $three_year->revenue }}"></td>
                                                                        <td><input type="number" name="rnd_cost[]"
                                                                                class="form-control"
                                                                                value="{{ $three_year->rnd_cost }}"></td>
                                                                        <td><input type="number" name="ratio[]"
                                                                                class="form-control"
                                                                                value="{{ $three_year->ratio }}" readonly>
                                                                        </td>
                                                                        <td>
                                                                            <textarea name="note[]" class="form-control">{{ $three_year->note }}</textarea>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                @for ($i = 0; $i < 3; $i++)
                                                                    <tr>
                                                                        <td><input type="number" name="year[]"
                                                                                class="form-control"></td>
                                                                        <td><input type="number" name="revenue[]"
                                                                                class="form-control"></td>
                                                                        <td><input type="number" name="rnd_cost[]"
                                                                                class="form-control"></td>
                                                                        <td><input type="number" name="ratio[]"
                                                                                class="form-control" readonly></td>
                                                                        <td>
                                                                            <textarea name="note[]" class="form-control"></textarea>
                                                                        </td>
                                                                    </tr>
                                                                @endfor
                                                            @endif

                                                        </tbody>
                                                    </table>
                                                </div>

                                                <hr>
                                                <h5 class="text-uppercase bg-light p-2 mt-3 mb-3">主要產品項目</h5>
                                                <div class="mb-3">
                                                    <table class="table table-bordered" id="mainProductTable"
                                                        align="center">
                                                        <thead>
                                                            <tr align="center">
                                                                <th rowspan="2">項目名稱</th>
                                                                <th colspan="3">前一年度</th>
                                                                <th colspan="3">前二年度 - 產量</th>
                                                                <th colspan="3">前三年度 - 產量</th>
                                                                <th rowspan="2">操作</th>
                                                            </tr>
                                                            <tr align="center">
                                                                <th>前一年度 - 產量</th>
                                                                <th>前一年度 - 銷售額(千元)</th>
                                                                <th>前一年度 - 市佔率(%)</th>
                                                                <th>前二年度 - 產量</th>
                                                                <th>前二年度 - 銷售額(千元)</th>
                                                                <th>前二年度 - 市佔率(%)</th>
                                                                <th>前三年度 - 產量</th>
                                                                <th>前三年度 - 銷售額(千元)</th>
                                                                <th>前三年度 - 市佔率(%)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if (count($sbir04_main_products) > 0)
                                                                @foreach ($sbir04_main_products as $main_product)
                                                                    <tr>
                                                                        <td><input type="text" name="product_name[]"
                                                                                class="form-control"
                                                                                value="{{ $main_product->product_name }}">
                                                                        </td>
                                                                        <td><input type="number" name="output_y1[]"
                                                                                class="form-control"
                                                                                value="{{ $main_product->output_y1 }}">
                                                                        </td>
                                                                        <td><input type="number" name="sales_y1[]"
                                                                                class="form-control"
                                                                                value="{{ $main_product->sales_y1 }}">
                                                                        </td>
                                                                        <td><input type="number" name="share_y1[]"
                                                                                class="form-control"
                                                                                value="{{ $main_product->share_y1 }}">
                                                                        </td>
                                                                        <td><input type="number" name="output_y2[]"
                                                                                class="form-control"
                                                                                value="{{ $main_product->output_y2 }}">
                                                                        </td>
                                                                        <td><input type="number" name="sales_y2[]"
                                                                                class="form-control"
                                                                                value="{{ $main_product->sales_y2 }}">
                                                                        </td>
                                                                        <td><input type="number" name="share_y2[]"
                                                                                class="form-control"
                                                                                value="{{ $main_product->share_y2 }}">
                                                                        </td>
                                                                        <td><input type="number" name="output_y3[]"
                                                                                class="form-control"
                                                                                value="{{ $main_product->output_y3 }}">
                                                                        </td>
                                                                        <td><input type="number" name="sales_y3[]"
                                                                                class="form-control"
                                                                                value="{{ $main_product->sales_y3 }}">
                                                                        </td>
                                                                        <td><input type="number" name="share_y3[]"
                                                                                class="form-control"
                                                                                value="{{ $main_product->share_y3 }}">
                                                                        </td>
                                                                        <td><button class="btn btn-sm btn-danger"
                                                                                onclick="this.closest('tr').remove()">刪除</button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                    <button class="btn btn-secondary" type="button"
                                                        onclick="addMainProductRow()">新增資料</button>
                                                </div>

                                                <hr>
                                                <h5 class="text-uppercase bg-light p-2 mt-3 mb-3">獎項</h5>
                                                <div class="mb-3">
                                                    <table class="table table-bordered" id="awardTable">
                                                        <thead>
                                                            <tr>
                                                                <th>年度</th>
                                                                <th>獎項名稱</th>
                                                                <th>操作</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if (count($sbir04_awards) > 0)
                                                                @foreach ($sbir04_awards as $award)
                                                                    <tr>
                                                                        <td><input type="number" name="award_year[]"
                                                                                class="form-control"
                                                                                value="{{ $award->award_year }}">
                                                                        </td>
                                                                        <td><input type="text" name="award_name[]"
                                                                                class="form-control"
                                                                                value="{{ $award->award_name }}">
                                                                        </td>
                                                                        <td><button class="btn btn-danger"
                                                                                onclick="this.closest('tr').remove()">刪除</button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                    <button class="btn btn-secondary" type="button"
                                                        onclick="addAwardRow()">新增獎項</button>
                                                </div>

                                                <hr>
                                                <h5 class="text-uppercase bg-light p-2 mt-3 mb-3">專利</h5>
                                                <div class="mb-3">
                                                    <table class="table table-bordered" id="patentTable">
                                                        <thead>
                                                            <tr>
                                                                <th>國別 / 年度 / 類型 / 專利編號</th>
                                                                <th>專利名稱或內容</th>
                                                                <th>操作</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if (count($sbir04_patents) > 0)
                                                                @foreach ($sbir04_patents as $patent)
                                                                    <tr>
                                                                        <td><input type="text" name="patent_info[]"
                                                                                class="form-control"
                                                                                value="{{ $patent->patent_info }}">
                                                                        </td>
                                                                        <td>
                                                                            <textarea name="patent_desc[]" class="form-control">{{ $patent->patent_desc }}</textarea>
                                                                        </td>
                                                                        <td><button class="btn btn-danger"
                                                                                onclick="this.closest('tr').remove()">刪除</button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                    <button class="btn btn-secondary" type="button"
                                                        onclick="addPatentRow()">新增專利</button>
                                                </div>

                                                <hr>
                                                <h5 class="text-uppercase bg-light p-2 mt-3 mb-3">政府計畫參與紀錄</h5>
                                                <div class="mb-3">
                                                    <div class="table-scroll-wrapper">
                                                        <table class="table table-bordered" id="govPlanTable1">
                                                            <thead>
                                                                <tr>
                                                                    <th>計畫類別</th>
                                                                    <th>計畫名稱</th>
                                                                    <th>執行期間(起)</th>
                                                                    <th>執行期間(迄)</th>
                                                                    <th>政府補助款(千元)</th>
                                                                    <th>廠商自籌款(千元)</th>
                                                                    <th>操作</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if (count($sbir04_goplans) > 0)
                                                                    @foreach ($sbir04_goplans as $goplan)
                                                                        <tr>
                                                                            <td><input type="text" name="plan_type[]"
                                                                                    class="form-control"
                                                                                    value="{{ $goplan->plan_type }}">
                                                                            </td>
                                                                            <td><input type="text" name="plan_name[]"
                                                                                    class="form-control"
                                                                                    value="{{ $goplan->plan_name }}">
                                                                            </td>
                                                                            <td><input type="date" name="start_date[]"
                                                                                    class="form-control"
                                                                                    value="{{ $goplan->start_date }}">
                                                                            </td>
                                                                            <td><input type="date" name="end_date[]"
                                                                                    class="form-control"
                                                                                    value="{{ $goplan->end_date }}">
                                                                            </td>
                                                                            <td><input type="number" name="gov_subsidy[]"
                                                                                    class="form-control"
                                                                                    value="{{ $goplan->gov_subsidy }}">
                                                                            </td>
                                                                            <td><input type="number"
                                                                                    name="self_funding[]"
                                                                                    class="form-control"
                                                                                    value="{{ $goplan->self_funding }}">
                                                                            </td>
                                                                            <td><button class="btn btn-sm btn-danger"
                                                                                    onclick="this.closest('tr').remove()">刪除</button>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <h5 class="mt-4">政府計畫參與紀錄（效益與研發重點）</h5>
                                                    <div class="table-scroll-wrapper">
                                                        <table class="table table-bordered" id="govPlanTable2">
                                                            <thead>
                                                                <tr>
                                                                    <th rowspan="2">研發重點</th>
                                                                    <th rowspan="2">投入人力(月)</th>
                                                                    <th colspan="4">預期</th>
                                                                    <th colspan="4">實際</th>
                                                                    <th rowspan="2">操作</th>
                                                                </tr>
                                                                <tr>
                                                                    <th>增加產值</th>
                                                                    <th>專利申請</th>
                                                                    <th>增加就業</th>
                                                                    <th>促進投資</th>
                                                                    <th>增加產值</th>
                                                                    <th>專利申請</th>
                                                                    <th>增加就業</th>
                                                                    <th>促進投資</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if (count($sbir04_goplans) > 0)
                                                                    @foreach ($sbir04_goplans as $sbir04_goplan)
                                                                        <td>
                                                                            <textarea name="plan_focus[]" class="form-control">{{ $sbir04_goplan->plan_focus }}</textarea>
                                                                        </td>
                                                                        <td><input type="number" name="man_month[]"
                                                                                class="form-control" value="{{ $sbir04_goplan->man_month }}"></td>
                                                                        <td><input type="number" name="expected_value[]"
                                                                                class="form-control" value="{{ $sbir04_goplan->expected_value }}"></td>
                                                                        <td><input type="number" name="expected_patent[]"
                                                                                class="form-control" value="{{ $sbir04_goplan->expected_patent }}"></td>
                                                                        <td><input type="number"
                                                                                name="expected_employment[]"
                                                                                class="form-control" value="{{ $sbir04_goplan->expected_employment }}"></td>
                                                                        <td><input type="number" name="expected_invest[]"
                                                                                class="form-control" value="{{ $sbir04_goplan->expected_invest }}"></td>
                                                                        <td><input type="number" name="actual_value[]"
                                                                                class="form-control" value="{{ $sbir04_goplan->actual_value }}"></td>
                                                                        <td><input type="number" name="actual_patent[]"
                                                                                class="form-control" value="{{ $sbir04_goplan->actual_patent }}"></td>
                                                                        <td><input type="number"
                                                                                name="actual_employment[]"
                                                                                class="form-control" value="{{ $sbir04_goplan->actual_employment }}"></td>
                                                                        <td><input type="number" name="actual_invest[]"
                                                                                class="form-control" value="{{ $sbir04_goplan->actual_invest }}"></td>
                                                                        <td><button class="btn btn-sm btn-danger"
                                                                                onclick="this.closest('tr').remove()">刪除</button>
                                                                        </td>
                                                                    @endforeach
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <button class="btn btn-secondary" type="button"
                                                        onclick="addGovPlanRow()">新增資料</button>

                                                </div>

                                                <hr>
                                                <h5 class="text-uppercase bg-light p-2 mt-3 mb-3">申請中政府研發計畫</h5>
                                                <div class="mb-3">
                                                    <table class="table table-bordered" id="applyingPlanTable">
                                                        <thead>
                                                            <tr>
                                                                <th>申請日期</th>
                                                                <th>申請機關</th>
                                                                <th>計畫名稱</th>
                                                                <th>執行期間(起)</th>
                                                                <th>執行期間(迄)</th>
                                                                <th>政府補助款(千元)</th>
                                                                <th>廠商自籌款(千元)</th>
                                                                <th>操作</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(count($sbir04_applys) > 0)
                                                                @foreach ($sbir04_applys as $apply)
                                                                    <tr>
                                                                        <td><input type="date" name="apply_date[]"
                                                                                class="form-control"
                                                                                value="{{ $apply->apply_date }}"></td>
                                                                        <td><input type="text" name="apply_org[]"
                                                                                class="form-control"
                                                                                value="{{ $apply->apply_org }}"></td>
                                                                        <td><input type="text" name="apply_name[]"
                                                                                class="form-control"
                                                                                value="{{ $apply->apply_name }}"></td>
                                                                        <td><input type="date" name="apply_start[]"
                                                                                class="form-control"
                                                                                value="{{ $apply->apply_start }}"></td>
                                                                        <td><input type="date" name="apply_end[]"
                                                                                class="form-control"
                                                                                value="{{ $apply->apply_end }}"></td>
                                                                        <td><input type="number" name="apply_grant[]"
                                                                                class="form-control"
                                                                                value="{{ $apply->apply_grant }}"></td>
                                                                        <td><input type="number" name="apply_self[]"
                                                                                class="form-control"
                                                                                value="{{ $apply->apply_self }}"></td>
                                                                        <td><button class="btn btn-danger"
                                                                                onclick="this.closest('tr').remove()">刪除</button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                    <button class="btn btn-secondary" type="button"
                                                        onclick="addApplyingPlanRow()">新增資料</button>
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
        function addShareholderRow() {
            document.querySelector('#shareholdersTable tbody').insertAdjacentHTML('beforeend', `
            <tr>
              <td><input type="text" name="shareholder_name[]" class="form-control"></td>
              <td><input type="number" name="shareholder_amount[]" class="form-control"></td>
              <td><input type="number" name="shareholder_ratio[]" class="form-control"></td>
              <td><input type="text" name="shareholder_source[]" class="form-control" value="自填"></td>
              <td><button class="btn btn-danger" onclick="this.closest('tr').remove()">刪除</button></td>
            </tr>`);
        }

        function addYearRow() {
            document.querySelector('#threeYearTable tbody').insertAdjacentHTML('beforeend', `
            <tr>
              <td><input type="number" name="year[]" class="form-control"></td>
              <td><input type="number" name="revenue[]" class="form-control"></td>
              <td><input type="number" name="rnd_cost[]" class="form-control"></td>
              <td><input type="number" name="ratio[]" class="form-control" readonly></td>
              <td><textarea name="note[]" class="form-control"></textarea></td>
              <td><button class="btn btn-danger" onclick="this.closest('tr').remove()">刪除</button></td>
            </tr>`);
        }

        function addMainProductRow() {
            document.querySelector('#mainProductTable tbody').insertAdjacentHTML('beforeend', `
    <tr>
      <td><input type="text" name="product_name[]" class="form-control"></td>
      <td><input type="number" name="output_y1[]" class="form-control"></td>
      <td><input type="number" name="sales_y1[]" class="form-control"></td>
      <td><input type="number" name="share_y1[]" class="form-control"></td>
      <td><input type="number" name="output_y2[]" class="form-control"></td>
      <td><input type="number" name="sales_y2[]" class="form-control"></td>
      <td><input type="number" name="share_y2[]" class="form-control"></td>
      <td><input type="number" name="output_y3[]" class="form-control"></td>
      <td><input type="number" name="sales_y3[]" class="form-control"></td>
      <td><input type="number" name="share_y3[]" class="form-control"></td>
      <td><button class="btn btn-sm btn-danger" onclick="this.closest('tr').remove()">刪除</button></td>
    </tr>`);
        }

        function addAwardRow() {
            document.querySelector('#awardTable tbody').insertAdjacentHTML('beforeend', `
            <tr>
              <td><input type="number" name="award_year[]" class="form-control"></td>
              <td><input type="text" name="award_name[]" class="form-control"></td>
              <td><button class="btn btn-danger" onclick="this.closest('tr').remove()">刪除</button></td>
            </tr>`);
        }

        function addPatentRow() {
            document.querySelector('#patentTable tbody').insertAdjacentHTML('beforeend', `
            <tr>
              <td><input type="text" name="patent_info[]" class="form-control"></td>
              <td><textarea name="patent_desc[]" class="form-control"></textarea></td>
              <td><button class="btn btn-danger" onclick="this.closest('tr').remove()">刪除</button></td>
            </tr>`);
        }

        function addGovPlanRow() {
            document.querySelector('#govPlanTable1 tbody').insertAdjacentHTML('beforeend', `
    <tr>
      <td><input type="text" name="plan_type[]" class="form-control"></td>
      <td><input type="text" name="plan_name[]" class="form-control"></td>
      <td><input type="date" name="start_date[]" class="form-control"></td>
      <td><input type="date" name="end_date[]" class="form-control"></td>
      <td><input type="number" name="gov_subsidy[]" class="form-control"></td>
      <td><input type="number" name="self_funding[]" class="form-control"></td>
      <td><button class="btn btn-sm btn-danger" onclick="this.closest('tr').remove()">刪除</button></td>
    </tr>`);

            document.querySelector('#govPlanTable2 tbody').insertAdjacentHTML('beforeend', `
    <tr>
      <td><textarea name="plan_focus[]" class="form-control"></textarea></td>
      <td><input type="number" name="man_month[]" class="form-control"></td>
      <td><input type="number" name="expected_value[]" class="form-control"></td>
      <td><input type="number" name="expected_patent[]" class="form-control"></td>
      <td><input type="number" name="expected_employment[]" class="form-control"></td>
      <td><input type="number" name="expected_invest[]" class="form-control"></td>
      <td><input type="number" name="actual_value[]" class="form-control"></td>
      <td><input type="number" name="actual_patent[]" class="form-control"></td>
      <td><input type="number" name="actual_employment[]" class="form-control"></td>
      <td><input type="number" name="actual_invest[]" class="form-control"></td>
      <td><button class="btn btn-sm btn-danger" onclick="this.closest('tr').remove()">刪除</button></td>
    </tr>`);
        }

        function addApplyingPlanRow() {
            document.querySelector('#applyingPlanTable tbody').insertAdjacentHTML('beforeend', `
            <tr>
              <td><input type="date" name="apply_date[]" class="form-control"></td>
              <td><input type="text" name="apply_org[]" class="form-control"></td>
              <td><input type="text" name="apply_name[]" class="form-control"></td>
              <td><input type="date" name="apply_start[]" class="form-control"></td>
              <td><input type="date" name="apply_end[]" class="form-control"></td>
              <td><input type="number" name="apply_grant[]" class="form-control"></td>
              <td><input type="number" name="apply_self[]" class="form-control"></td>
              <td><button class="btn btn-danger" onclick="this.closest('tr').remove()">刪除</button></td>
            </tr>`);
        }
    </script>
@endsection
