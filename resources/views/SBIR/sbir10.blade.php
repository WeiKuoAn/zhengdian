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
            <form action="{{ route('project.sbir10.data', $project->id) }}" method="POST">
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
                                                <a href="{{ route('project.sbir09', $project->id) }}" class="nav-link ">
                                                    玖、計畫執行查核點說明
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir10', $project->id) }}"
                                                    class="nav-link active">
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
                                                <h5 class="text-uppercase bg-light p-2 mt-3 mb-3">計畫總經費預算表</h5>
                                                <div class="mb-3">
                                                    <table class="table table-bordered" id="budgetTable">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>費用項目</th>
                                                                <th>補助款(千元)</th>
                                                                <th>自籌款(千元)</th>
                                                                <th>合計(千元)</th>
                                                                <th>比例%</th>
                                                                <th>備註</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="table-primary">
                                                                <td colspan="6">
                                                                    1.人事費
                                                                </td>
                                                            </tr>
                                                            <tr data-category="1">
                                                                <td>(1) 研發人員 <a
                                                                        href="{{ route('project.fund01', $project->id) }}"
                                                                        class="ms-2"><i class="bi bi-pencil"></i></a>
                                                                </td>
                                                                <td><input type="number" class="form-control text-center"
                                                                        name="subsidy_1_1"
                                                                        @if (isset($data->subsidy_1_1)) value="{{ $data->subsidy_1_1 }}" @endif>
                                                                </td>
                                                                <td><input type="number" class="form-control text-center"
                                                                        name="self_1_1"
                                                                        @if (isset($data->self_1_1)) value="{{ $data->self_1_1 }}" @endif>
                                                                </td>
                                                                <td class="text-center text-danger">
                                                                    <div class="calc-sum">0</div>
                                                                    @if (isset($data->total_1_1))
                                                                        （{{ number_format($data->total_1_1) }}）
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="text" readonly style="border: none"
                                                                        class="text-center form-control-plaintext"
                                                                        name="percentage_1"
                                                                        @if (isset($data->percentage_1)) value="{{ $data->percentage_1 }}" @endif>
                                                                </td>

                                                                <td></td>
                                                            </tr>
                                                            <tr data-category="1">
                                                                <td>(2) 國際研發人員 <a
                                                                        href="{{ route('project.fund02', $project->id) }}"
                                                                        class="ms-2"><i class="bi bi-pencil"></i></a>
                                                                </td>
                                                                <td><input type="number" class="form-control text-center"
                                                                        name="subsidy_1_2"
                                                                        @if (isset($data->subsidy_1_2)) value="{{ $data->subsidy_1_2 }}" @endif>
                                                                </td>
                                                                <td><input type="number" class="form-control text-center"
                                                                        name="self_1_2"
                                                                        @if (isset($data->self_1_2)) value="{{ $data->self_1_2 }}" @endif>
                                                                </td>
                                                                <td class="text-center text-danger" data-category="1">
                                                                    <div class="calc-sum">0</div>
                                                                    @if (isset($data->total_1_2))
                                                                        （{{ number_format($data->total_1_2) }}）
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="text" readonly style="border: none"
                                                                        class="text-center form-control-plaintext"
                                                                        name="percentage_2"
                                                                        @if (isset($data->percentage_2)) value="{{ $data->percentage_2 }}" @endif>
                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                            <tr data-category="1">
                                                                <td>(3) 顧問 <a
                                                                        href="{{ route('project.fund03', $project->id) }}"
                                                                        class="ms-2"><i class="bi bi-pencil"></i></a>
                                                                </td>
                                                                <td><input type="number" class="form-control text-center"
                                                                        name="subsidy_1_3"
                                                                        @if (isset($data->subsidy_1_3)) value="{{ $data->subsidy_1_3 }}" @endif>
                                                                </td>
                                                                <td><input type="number" class="form-control text-center"
                                                                        name="self_1_3"
                                                                        @if (isset($data->self_1_3)) value="{{ $data->self_1_3 }}" @endif>
                                                                </td>
                                                                <td class="text-center text-danger" data-category="1">
                                                                    <div class="calc-sum">0</div>
                                                                    @if (isset($data->total_1_3))
                                                                        （{{ number_format($data->total_1_3) }}）
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="text" readonly style="border: none"
                                                                        class="text-center form-control-plaintext"
                                                                        name="percentage_3"
                                                                        @if (isset($data->percentage_3)) value="{{ $data->percentage_3 }}" @endif>
                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>人事費 小計</strong></td>
                                                                <td><input type="number" readonly style="border: none"
                                                                        name="subtotal_1_1"
                                                                        class="form-control-plaintext text-danger text-center"
                                                                        @if (isset($data->subtotal_1_1)) value="{{ $data->subtotal_1_1 }}" @endif>
                                                                </td>
                                                                <td><input type="number" readonly style="border: none"
                                                                        name="subtotal_1_2"
                                                                        class="form-control-plaintext text-danger text-center"
                                                                        @if (isset($data->subtotal_1_2)) value="{{ $data->subtotal_1_2 }}" @endif>
                                                                </td>
                                                                <td><input type="number" readonly style="border: none"
                                                                        name="subtotal_1_3"
                                                                        class="form-control-plaintext text-danger text-center"
                                                                        @if (isset($data->subtotal_1_3)) value="{{ $data->subtotal_1_3 }}" @endif>
                                                                </td>
                                                                <td colspan="2"></td>
                                                            </tr>

                                                            <tr class="table-primary">
                                                                <td colspan="6">
                                                                    2.消耗性器材及原材料費
                                                                </td>
                                                            </tr>
                                                            <tr data-category="2">
                                                                <td>(1) 消耗性器材及原材料費 <a
                                                                        href="{{ route('project.fund04', $project->id) }}"
                                                                        class="ms-2"><i class="bi bi-pencil"></i></a>
                                                                </td>
                                                                <td><input type="number" class="form-control text-center"
                                                                        name="subsidy_2_1"
                                                                        @if (isset($data->subsidy_2_1)) value="{{ $data->subsidy_2_1 }}" @endif>
                                                                </td>
                                                                <td><input type="number" class="form-control text-center"
                                                                        name="self_2_1"
                                                                        @if (isset($data->self_2_1)) value="{{ $data->self_2_1 }}" @endif>
                                                                </td>
                                                                <td class="text-center text-danger" data-category="2">
                                                                    <div class="calc-sum">0</div>
                                                                    @if (isset($data->total_2_1))
                                                                        （{{ number_format($data->total_2_1) }}）
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="text" readonly style="border: none"
                                                                        class="text-center form-control-plaintext"
                                                                        name="percentage_4"
                                                                        @if (isset($data->percentage_4)) value="{{ $data->percentage_4 }}" @endif>
                                                                </td>
                                                                <td>
                                                                    <textarea class="form-control"></textarea>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>消耗性器材及原材料費 小計</strong></td>
                                                                <td><input type="number" readonly style="border: none"
                                                                        name="subtotal_2_1"
                                                                        class="form-control-plaintext text-danger text-center"
                                                                        @if (isset($data->subtotal_2_1)) value="{{ $data->subtotal_2_1 }}" @endif>
                                                                </td>
                                                                <td><input type="number" readonly style="border: none"
                                                                        name="subtotal_2_2"
                                                                        class="form-control-plaintext text-danger text-center"
                                                                        @if (isset($data->subtotal_2_2)) value="{{ $data->subtotal_2_2 }}" @endif>
                                                                </td>
                                                                <td><input type="number" readonly style="border: none"
                                                                        name="subtotal_2_3"
                                                                        class="form-control-plaintext text-danger text-center"
                                                                        @if (isset($data->subtotal_2_3)) value="{{ $data->subtotal_2_3 }}" @endif>
                                                                </td>
                                                                <td colspan="2"></td>
                                                            </tr>

                                                            <tr class="table-primary">
                                                                <td colspan="6">
                                                                    3.研發設備使用費
                                                                </td>
                                                            </tr>
                                                            <tr data-category="3">
                                                                <td>(1) 已有設備 <a
                                                                        href="{{ route('project.fund05', $project->id) }}"
                                                                        class="ms-2"><i class="bi bi-pencil"></i></a>
                                                                </td>
                                                                <td><input type="number" class="form-control text-center"
                                                                        name="subsidy_3_1"
                                                                        @if (isset($data->subsidy_3_1)) value="{{ $data->subsidy_3_1 }}" @endif>
                                                                </td>
                                                                <td><input type="number" class="form-control text-center"
                                                                        name="self_3_1"
                                                                        @if (isset($data->self_3_1)) value="{{ $data->self_3_1 }}" @endif>
                                                                </td>
                                                                <td class="text-center text-danger" data-category="3">
                                                                    <div class="calc-sum">0</div>
                                                                    @if (isset($data->total_3_1))
                                                                        （{{ number_format($data->total_3_1) }}）
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="text" readonly style="border: none"
                                                                        class="text-center form-control-plaintext"
                                                                        name="percentage_5"
                                                                        @if (isset($data->percentage_5)) value="{{ $data->percentage_5 }}" @endif>
                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                            <tr data-category="3">
                                                                <td>(2) 計畫新增設備 <a
                                                                        href="{{ route('project.fund06', $project->id) }}"
                                                                        class="ms-2"><i class="bi bi-pencil"></i></a>
                                                                </td>
                                                                <td><input type="number"
                                                                        class="form-control text-center text-center"
                                                                        name="subsidy_3_2"
                                                                        @if (isset($data->subsidy_3_2)) value="{{ $data->subsidy_3_2 }}" @endif>
                                                                </td>
                                                                <td><input type="number" class="form-control text-center"
                                                                        name="self_3_2" @if (isset($data->self_3_2)) value="{{ $data->self_3_2 }}" @endif>
                                                                </td>
                                                                <td class="text-center text-danger" data-category="3">
                                                                    <div class="calc-sum">0</div>
                                                                    @if (isset($data->total_3_2))
                                                                        （{{ number_format($data->total_3_2) }}）
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="text" readonly style="border: none"
                                                                        class="text-center form-control-plaintext"
                                                                        name="percentage_6"
                                                                        @if (isset($data->percentage_6)) value="{{ $data->percentage_6 }}" @endif>
                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>研發設備使用費 小計</strong></td>
                                                                <td><input type="number" readonly style="border: none"
                                                                        name="subtotal_3_1"
                                                                        class="form-control-plaintext text-danger text-center"
                                                                        @if (isset($data->subtotal_3_1)) value="{{ $data->subtotal_3_1 }}" @endif>
                                                                </td>
                                                                <td><input type="number" readonly style="border: none"
                                                                        name="subtotal_3_2"
                                                                        class="form-control-plaintext text-danger text-center"
                                                                        @if (isset($data->subtotal_3_2)) value="{{ $data->subtotal_3_2 }}" @endif>
                                                                </td>
                                                                <td><input type="number" readonly style="border: none"
                                                                        name="subtotal_3_3"
                                                                        class="form-control-plaintext text-danger text-center"
                                                                        @if (isset($data->subtotal_3_3)) value="{{ $data->subtotal_3_3 }}" @endif>
                                                                </td>
                                                                <td colspan="2"></td>
                                                            </tr>

                                                            <tr class="table-primary">
                                                                <td colspan="6">
                                                                    4.研發設備維護費
                                                                </td>
                                                            </tr>
                                                            <tr data-category="4">
                                                                <td>(1) 研發設備維護費 <a
                                                                        href="{{ route('project.fund07', $project->id) }}"
                                                                        class="ms-2"><i class="bi bi-pencil"></i></a>
                                                                </td>
                                                                <td><input type="number" class="form-control text-center"
                                                                        name="subsidy_4_1"
                                                                        @if (isset($data->subsidy_4_1)) value="{{ $data->subsidy_4_1 }}" @endif>
                                                                </td>
                                                                <td><input type="number" class="form-control text-center"
                                                                        name="self_4_1"
                                                                        @if (isset($data->self_4_1)) value="{{ $data->self_4_1 }}" @endif>
                                                                </td>
                                                                <td class="text-center text-danger" data-category="4">
                                                                    <div class="calc-sum">0</div>
                                                                    @if (isset($data->total_4_1))
                                                                        （{{ number_format($data->total_4_1) }}）
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="text" readonly style="border: none"
                                                                        class="text-center form-control-plaintext"
                                                                        name="percentage_7"
                                                                        @if (isset($data->percentage_7)) value="{{ $data->percentage_7 }}" @endif>
                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>研發設備維護費 小計</strong></td>
                                                                <td><input type="number" readonly style="border: none"
                                                                        name="subtotal_4_1"
                                                                        class="form-control-plaintext text-danger text-center"
                                                                        @if (isset($data->subtotal_4_1)) value="{{ $data->subtotal_4_1 }}" @endif>
                                                                </td>
                                                                <td><input type="number" readonly style="border: none"
                                                                        name="subtotal_4_2"
                                                                        class="form-control-plaintext text-danger text-center"
                                                                        @if (isset($data->subtotal_4_2)) value="{{ $data->subtotal_4_2 }}" @endif>
                                                                </td>
                                                                <td><input type="number" readonly style="border: none"
                                                                        name="subtotal_4_3"
                                                                        class="form-control-plaintext text-danger text-center"
                                                                        @if (isset($data->subtotal_4_3)) value="{{ $data->subtotal_4_3 }}" @endif>
                                                                </td>
                                                                <td colspan="2"></td>
                                                            </tr>

                                                            <tr class="table-primary">
                                                                <td colspan="6">
                                                                    5.技術移轉費
                                                                </td>
                                                            </tr>
                                                            <tr data-category="5">
                                                                <td>(1) 技術或智慧財產權購買費 <a
                                                                        href="{{ route('project.fund08', $project->id) }}"
                                                                        class="ms-2"><i
                                                                            class="bi bi-pencil"></i></a><br><span
                                                                        class="text-danger small">(自籌款+補助款)需等於合計，自籌款不得小於補助款，且金額不得為0。</span>
                                                                </td>
                                                                <td><input type="number" class="form-control text-center"
                                                                        name="subsidy_5_1"
                                                                        @if (isset($data->subsidy_5_1)) value="{{ $data->subsidy_5_1 }}" @endif>
                                                                </td>
                                                                <td><input type="number" class="form-control text-center"
                                                                        name="self_5_1"
                                                                        @if (isset($data->self_5_1)) value="{{ $data->self_5_1 }}" @endif>
                                                                </td>
                                                                <td class="text-center text-danger" data-category="5">
                                                                    <div class="calc-sum">0</div>
                                                                    @if (isset($data->total_5_1))
                                                                        （{{ number_format($data->total_5_1) }}）
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="text" readonly style="border: none"
                                                                        class="text-center form-control-plaintext"
                                                                        name="percentage_8"
                                                                        @if (isset($data->percentage_8)) value="{{ $data->percentage_8 }}" @endif>
                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                            <tr data-category="5">
                                                                <td>(2) 委託研究費 <a
                                                                        href="{{ route('project.fund09', $project->id) }}"
                                                                        class="ms-2"><i class="bi bi-pencil"></i></a>
                                                                </td>
                                                                <td><input type="number" class="form-control text-center"
                                                                        name="subsidy_5_2"
                                                                        @if (isset($data->subsidy_5_2)) value="{{ $data->subsidy_5_2 }}" @endif>
                                                                </td>
                                                                <td><input type="number" class="form-control text-center"
                                                                        name="self_5_2"
                                                                        @if (isset($data->self_5_2)) value="{{ $data->self_5_2 }}" @endif>
                                                                </td>
                                                                <td class="text-center text-danger" data-category="5">
                                                                    <div class="calc-sum">0</div>
                                                                    @if (isset($data->total_5_2))
                                                                        （{{ number_format($data->total_5_2) }}）
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="text" readonly style="border: none"
                                                                        class="text-center form-control-plaintext"
                                                                        name="percentage_9"
                                                                        @if (isset($data->percentage_9)) value="{{ $data->percentage_9 }}" @endif>
                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                            <tr data-category="5">
                                                                <td>(3) 委託勞務費 <a
                                                                        href="{{ route('project.fund10', $project->id) }}"
                                                                        class="ms-2"><i class="bi bi-pencil"></i></a>
                                                                </td>
                                                                <td><input type="number" class="form-control text-center"
                                                                        name="subsidy_5_3"
                                                                        @if (isset($data->subsidy_5_3)) value="{{ $data->subsidy_5_3 }}" @endif>
                                                                </td>
                                                                <td><input type="number" class="form-control text-center"
                                                                        name="self_5_3"
                                                                        @if (isset($data->self_5_3)) value="{{ $data->self_5_3 }}" @endif>
                                                                </td>
                                                                <td class="text-center text-danger" data-category="5">
                                                                    <div class="calc-sum">0</div>
                                                                    @if (isset($data->total_5_3))
                                                                        （{{ number_format($data->total_5_3) }}）
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="text" readonly style="border: none"
                                                                        class="text-center form-control-plaintext"
                                                                        name="percentage_10"
                                                                        @if (isset($data->percentage_10)) value="{{ $data->percentage_10 }}" @endif>
                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                            <tr data-category="5">
                                                                <td>(4) 委託設計費 <a
                                                                        href="{{ route('project.fund11', $project->id) }}"
                                                                        class="ms-2"><i class="bi bi-pencil"></i></a>
                                                                </td>
                                                                <td><input type="number" class="form-control text-center"
                                                                        name="subsidy_5_4"
                                                                        @if (isset($data->subsidy_5_4)) value="{{ $data->subsidy_5_4 }}" @endif>
                                                                </td>
                                                                <td><input type="number" class="form-control text-center"
                                                                        name="self_5_4"
                                                                        @if (isset($data->self_5_4)) value="{{ $data->self_5_4 }}" @endif>
                                                                </td>
                                                                <td class="text-center text-danger" data-category="5">
                                                                    <div class="calc-sum">0</div>
                                                                    @if (isset($data->total_5_4))
                                                                        （{{ number_format($data->total_5_4) }}）
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="text" readonly style="border: none"
                                                                        class="text-center form-control-plaintext"
                                                                        name="percentage_11"
                                                                        @if (isset($data->percentage_11)) value="{{ $data->percentage_11 }}" @endif>
                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                            <tr data-category="5">
                                                                <td>(5) 委託諮詢費 <a
                                                                        href="{{ route('project.fund12', $project->id) }}"
                                                                        class="ms-2"><i
                                                                            class="bi bi-pencil"></i></a><br><span
                                                                        class="small">以占計畫總經費之5%為上限，且以首次申請SBIR計畫，每家企業以申請1次為限</span>
                                                                </td>
                                                                <td><input type="number" class="form-control text-center"
                                                                        name="subsidy_5_5"
                                                                        @if (isset($data->subsidy_5_5)) value="{{ $data->subsidy_5_5 }}" @endif>
                                                                </td>
                                                                <td><input type="number" class="form-control text-center"
                                                                        name="self_5_5"
                                                                        @if (isset($data->self_5_5)) value="{{ $data->self_5_5 }}" @endif>
                                                                </td>
                                                                <td class="text-center text-danger" data-category="5">
                                                                    <div class="calc-sum">0</div>
                                                                    @if (isset($data->total_5_5))
                                                                        （{{ number_format($data->total_5_5) }}）
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="text" readonly style="border: none"
                                                                        class="text-center form-control-plaintext"
                                                                        name="percentage_12"
                                                                        @if (isset($data->percentage_12)) value="{{ $data->percentage_12 }}" @endif>
                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>技術移轉費 小計</strong></td>
                                                                <td><input type="number" readonly style="border: none"
                                                                        name="subtotal_5_1"
                                                                        class="form-control-plaintext text-danger text-center"
                                                                        @if (isset($data->subtotal_5_1)) value="{{ $data->subtotal_5_1 }}" @endif>
                                                                </td>
                                                                <td><input type="number" readonly style="border: none"
                                                                        name="subtotal_5_2"
                                                                        class="form-control-plaintext text-danger text-center"
                                                                        @if (isset($data->subtotal_5_2)) value="{{ $data->subtotal_5_2 }}" @endif>
                                                                </td>
                                                                <td><input type="number" readonly style="border: none"
                                                                        name="subtotal_5_3"
                                                                        class="form-control-plaintext text-danger text-center"
                                                                        @if (isset($data->subtotal_5_3)) value="{{ $data->subtotal_5_3 }}" @endif>
                                                                </td>
                                                                <td colspan="2"></td>
                                                            </tr>

                                                            <tr class="table-primary">
                                                                <td colspan="6">
                                                                    6.國內差旅費
                                                                </td>
                                                            </tr>
                                                            <tr data-category="6">
                                                                <td>(1) 國內差旅費 <a
                                                                        href="{{ route('project.fund13', $project->id) }}"
                                                                        class="ms-2"><i class="bi bi-pencil"></i></a>
                                                                </td>
                                                                <td><input type="number" class="form-control text-center"
                                                                        name="subsidy_6_1"
                                                                        @if (isset($data->subsidy_6_1)) value="{{ $data->subsidy_6_1 }}" @endif>
                                                                </td>
                                                                <td><input type="number" class="form-control text-center"
                                                                        name="self_6_1"
                                                                        @if (isset($data->self_6_1)) value="{{ $data->self_6_1 }}" @endif>
                                                                </td>
                                                                <td class="text-center text-danger" data-category="6">
                                                                    <div class="calc-sum">0</div>
                                                                    @if (isset($data->total_6_1))
                                                                        （{{ number_format($data->total_6_1) }}）
                                                                    @endif
                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="text" readonly style="border: none"
                                                                        class="text-center form-control-plaintext"
                                                                        name="percentage_13"
                                                                        @if (isset($data->percentage_13)) value="{{ $data->percentage_13 }}" @endif>
                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>國內差旅費 小計</strong></td>
                                                                <td><input type="number" readonly style="border: none"
                                                                        name="subtotal_6_1"
                                                                        class="form-control-plaintext text-danger text-center">
                                                                </td>
                                                                <td><input type="number" readonly style="border: none"
                                                                        name="subtotal_6_2"
                                                                        class="form-control-plaintext text-danger text-center">
                                                                </td>
                                                                <td><input type="number" readonly style="border: none"
                                                                        name="subtotal_6_3"
                                                                        class="form-control-plaintext text-danger text-center">
                                                                </td>
                                                                <td colspan="2"></td>
                                                            </tr>

                                                        </tbody>
                                                        <tfoot class="table-secondary">
                                                            <tr>
                                                                <td class="text-end"><strong>合計</strong></td>
                                                                <td><input type="number" readonly style="border: none"
                                                                        id="total-subsidy"
                                                                        class="form-control-plaintext text-danger text-center"
                                                                        name="total_subsidy"></td>
                                                                <td><input type="number" readonly style="border: none"
                                                                        id="total-self"
                                                                        class="form-control-plaintext text-danger text-center"
                                                                        name="total_self"></td>
                                                                <td><input type="number" readonly style="border: none"
                                                                        id="total-all"
                                                                        class="form-control-plaintext text-danger text-center"
                                                                        name="total_all"></td>
                                                                <td colspan="2"></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-end"><strong>百分比</strong></td>
                                                                <td><input type="text" readonly style="border: none"
                                                                        id="rate-subsidy"
                                                                        class="form-control-plaintext text-danger text-center"
                                                                        name="rate_subsidy" @if (isset($data->rate_subsidy)) value="{{ $data->rate_subsidy }}" @endif></td>
                                                                <td><input type="text" readonly style="border: none"
                                                                        id="rate-self"
                                                                        class="form-control-plaintext text-danger text-center"
                                                                        name="rate_self" @if (isset($data->rate_self)) value="{{ $data->rate_self }}" @endif></td>
                                                                <td><input type="text" readonly style="border: none"
                                                                        id="rate-all"
                                                                        class="form-control-plaintext text-danger text-center"
                                                                        name="rate_all" @if (isset($data->subtotal_5_3)) value="{{ $data->subtotal_5_3 }}" @endif></td>
                                                                <td colspan="2"></td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>

                                                <hr>

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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function updateBudgetTable() {
            const rows = document.querySelectorAll("#budgetTable tbody tr[data-category]");
            const categoryTotals = {};
            let grandSubsidy = 0,
                grandSelf = 0,
                grandTotal = 0;

            rows.forEach((row, index) => {
                const category = row.dataset.category;
                const subInput = row.querySelector("input[name^='subsidy']");
                const selfInput = row.querySelector("input[name^='self']");
                const sumField = row.querySelector(".calc-sum");
                const percentInput = row.querySelector("input[name^='percentage']");

                const sub = parseFloat(subInput?.value) || 0;
                const self = parseFloat(selfInput?.value) || 0;
                const total = sub + self;

                sumField.textContent = total.toLocaleString();

                if (!categoryTotals[category]) {
                    categoryTotals[category] = {
                        subsidy: 0,
                        self: 0,
                        total: 0
                    };
                }
                categoryTotals[category].subsidy += sub;
                categoryTotals[category].self += self;
                categoryTotals[category].total += total;

                grandSubsidy += sub;
                grandSelf += self;
                grandTotal += total;
            });

            Object.entries(categoryTotals).forEach(([cat, values]) => {
                const subtotal1 = document.querySelector(`input[name="subtotal_${cat}_1"]`);
                const subtotal2 = document.querySelector(`input[name="subtotal_${cat}_2"]`);
                const subtotal3 = document.querySelector(`input[name="subtotal_${cat}_3"]`);
                if (subtotal1) subtotal1.value = values.subsidy;
                if (subtotal2) subtotal2.value = values.self;
                if (subtotal3) subtotal3.value = values.total;
            });

            const totalSubsidyField = document.getElementById("total-subsidy");
            const totalSelfField = document.getElementById("total-self");
            const totalAllField = document.getElementById("total-all");
            if (totalSubsidyField) totalSubsidyField.value = grandSubsidy;
            if (totalSelfField) totalSelfField.value = grandSelf;
            if (totalAllField) totalAllField.value = grandTotal;

            rows.forEach((row, i) => {
                const sumCell = row.querySelector(".calc-sum");
                const percentInput = row.querySelector("input[name^='percentage']");
                const sum = parseInt(sumCell.textContent.replace(/,/g, '')) || 0;
                const percent = grandTotal > 0 ? (sum / grandTotal * 100).toFixed(2) : '0.00';
                if (percentInput) percentInput.value = percent + "%";

            });
            // 額外新增百分比列計算
            const rateSubsidy = document.getElementById("rate-subsidy");
            const rateSelf = document.getElementById("rate-self");
            const rateAll = document.getElementById("rate-all");
            const all = grandTotal;
            if (rateSubsidy) rateSubsidy.value = all ? ((grandSubsidy / all) * 100).toFixed(2) + '%' : '0%';
            if (rateSelf) rateSelf.value = all ? ((grandSelf / all) * 100).toFixed(2) + '%' : '0%';
            if (rateAll) rateAll.value = '100%';
        }

        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll("#budgetTable input[type='number']").forEach(input => {
                input.addEventListener('input', updateBudgetTable);
            });
            updateBudgetTable();
        });
    </script>
@endsection
