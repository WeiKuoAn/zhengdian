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
                                                                <td>(1) 研發人員 <a href="{{ route('project.fund01',$project->id) }}" class="ms-2"><i
                                                                            class="bi bi-pencil"></i></a></td>
                                                                <td><input type="number" class="form-control"
                                                                        name="subsidy_1_1"></td>
                                                                <td><input type="number" class="form-control"
                                                                        name="self_1_1"></td>
                                                                <td class="text-center text-danger calc-sum"
                                                                    data-category="1">0</td>
                                                                <td class="text-center calc-rate">0%</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr data-category="1">
                                                                <td>(2) 國際研發人員 <a href="#" class="ms-2"><i
                                                                            class="bi bi-pencil"></i></a></td>
                                                                <td><input type="number" class="form-control"
                                                                        name="subsidy_1_2"></td>
                                                                <td><input type="number" class="form-control"
                                                                        name="self_1_2"></td>
                                                                <td class="text-center text-danger calc-sum"
                                                                    data-category="1">0</td>
                                                                <td class="text-center calc-rate">0%</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr data-category="1">
                                                                <td>(3) 顧問 <a href="#" class="ms-2"><i
                                                                            class="bi bi-pencil"></i></a></td>
                                                                <td><input type="number" class="form-control"
                                                                        name="subsidy_1_3"></td>
                                                                <td><input type="number" class="form-control"
                                                                        name="self_1_3"></td>
                                                                <td class="text-center text-danger calc-sum"
                                                                    data-category="1">0</td>
                                                                <td class="text-center calc-rate">0%</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>人事費 小計</strong></td>
                                                                <td class="text-center text-danger calc-subtotal"
                                                                    data-category="1">0</td>
                                                                <td class="text-center text-danger calc-subtotal"
                                                                    data-category="1">0</td>
                                                                <td class="text-center text-danger calc-subtotal"
                                                                    data-category="1">0</td>
                                                                <td colspan="2"></td>
                                                            </tr>

                                                            <tr class="table-primary">
                                                                <td colspan="6">
                                                                    2.消耗性器材及原材料費
                                                                </td>
                                                            </tr>
                                                            <tr data-category="2">
                                                                <td>(1) 消耗性器材及原材料費 <a href="#" class="ms-2"><i
                                                                            class="bi bi-pencil"></i></a></td>
                                                                <td><input type="number" class="form-control"
                                                                        name="subsidy_2_1"></td>
                                                                <td><input type="number" class="form-control"
                                                                        name="self_2_1"></td>
                                                                <td class="text-center text-danger calc-sum"
                                                                    data-category="2">0</td>
                                                                <td class="text-center calc-rate">0%</td>
                                                                <td>
                                                                    <textarea class="form-control"></textarea>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>消耗性器材及原材料費 小計</strong></td>
                                                                <td class="text-center text-danger calc-subtotal"
                                                                    data-category="2">0</td>
                                                                <td class="text-center text-danger calc-subtotal"
                                                                    data-category="2">0</td>
                                                                <td class="text-center text-danger calc-subtotal"
                                                                    data-category="2">0</td>
                                                                <td colspan="2"></td>
                                                            </tr>

                                                            <tr class="table-primary">
                                                                <td colspan="6">
                                                                    3.研發設備使用費
                                                                </td>
                                                            </tr>
                                                            <tr data-category="3">
                                                                <td>(1) 已有設備 <a href="#" class="ms-2"><i
                                                                            class="bi bi-pencil"></i></a></td>
                                                                <td><input type="number" class="form-control"
                                                                        name="subsidy_3_1"></td>
                                                                <td><input type="number" class="form-control"
                                                                        name="self_3_1"></td>
                                                                <td class="text-center text-danger calc-sum"
                                                                    data-category="3">0</td>
                                                                <td class="text-center calc-rate">0%</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr data-category="3">
                                                                <td>(2) 計畫新增設備 <a href="#" class="ms-2"><i
                                                                            class="bi bi-pencil"></i></a></td>
                                                                <td><input type="number" class="form-control"
                                                                        name="subsidy_3_2"></td>
                                                                <td><input type="number" class="form-control"
                                                                        name="self_3_2"></td>
                                                                <td class="text-center text-danger calc-sum"
                                                                    data-category="3">0</td>
                                                                <td class="text-center calc-rate">0%</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>研發設備使用費 小計</strong></td>
                                                                <td class="text-center text-danger calc-subtotal"
                                                                    data-category="3">0</td>
                                                                <td class="text-center text-danger calc-subtotal"
                                                                    data-category="3">0</td>
                                                                <td class="text-center text-danger calc-subtotal"
                                                                    data-category="3">0</td>
                                                                <td colspan="2"></td>
                                                            </tr>

                                                            <tr class="table-primary">
                                                                <td colspan="6">
                                                                    4.研發設備維護費
                                                                </td>
                                                            </tr>
                                                            <tr data-category="4">
                                                                <td>(1) 研發設備維護費 <a href="#" class="ms-2"><i
                                                                            class="bi bi-pencil"></i></a></td>
                                                                <td><input type="number" class="form-control"
                                                                        name="subsidy_4_1"></td>
                                                                <td><input type="number" class="form-control"
                                                                        name="self_4_1"></td>
                                                                <td class="text-center text-danger calc-sum"
                                                                    data-category="4">0</td>
                                                                <td class="text-center calc-rate">0%</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>研發設備維護費 小計</strong></td>
                                                                <td class="text-center text-danger calc-subtotal"
                                                                    data-category="4">0</td>
                                                                <td class="text-center text-danger calc-subtotal"
                                                                    data-category="4">0</td>
                                                                <td class="text-center text-danger calc-subtotal"
                                                                    data-category="4">0</td>
                                                                <td colspan="2"></td>
                                                            </tr>

                                                            <tr class="table-primary">
                                                                <td colspan="6">
                                                                    5.技術移轉費 
                                                                </td>
                                                            </tr>
                                                            <tr data-category="5">
                                                                <td>(1) 技術或智慧財產權購買費 <a href="#" class="ms-2"><i
                                                                            class="bi bi-pencil"></i></a><br><span
                                                                        class="text-danger small">(自籌款+補助款)需等於合計，自籌款不得小於補助款，且金額不得為0。</span>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="subsidy_5_1" value="0"></td>
                                                                <td><input type="number" class="form-control"
                                                                        name="self_5_1" value="0"></td>
                                                                <td class="text-center text-danger calc-sum"
                                                                    data-category="5">0</td>
                                                                <td class="text-center calc-rate">0%</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr data-category="5">
                                                                <td>(2) 委託研究費 <a href="#" class="ms-2"><i
                                                                            class="bi bi-pencil"></i></a></td>
                                                                <td><input type="number" class="form-control"
                                                                        name="subsidy_5_2" value="0"></td>
                                                                <td><input type="number" class="form-control"
                                                                        name="self_5_2" value="0"></td>
                                                                <td class="text-center text-danger calc-sum"
                                                                    data-category="5">0</td>
                                                                <td class="text-center calc-rate">0%</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr data-category="5">
                                                                <td>(3) 委託勞務費 <a href="#" class="ms-2"><i
                                                                            class="bi bi-pencil"></i></a></td>
                                                                <td><input type="number" class="form-control"
                                                                        name="subsidy_5_3" value="0"></td>
                                                                <td><input type="number" class="form-control"
                                                                        name="self_5_3" value="0"></td>
                                                                <td class="text-center text-danger calc-sum"
                                                                    data-category="5">0</td>
                                                                <td class="text-center calc-rate">0%</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr data-category="5">
                                                                <td>(4) 委託設計費 <a href="#" class="ms-2"><i
                                                                            class="bi bi-pencil"></i></a></td>
                                                                <td><input type="number" class="form-control"
                                                                        name="subsidy_5_4" value="0"></td>
                                                                <td><input type="number" class="form-control"
                                                                        name="self_5_4" value="0"></td>
                                                                <td class="text-center text-danger calc-sum"
                                                                    data-category="5">0</td>
                                                                <td class="text-center calc-rate">0%</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr data-category="5">
                                                                <td>(5) 委託諮詢費 <a href="#" class="ms-2"><i
                                                                            class="bi bi-pencil"></i></a><br><span
                                                                        class="small">以占計畫總經費之5%為上限，且以首次申請SBIR計畫，每家企業以申請1次為限</span>
                                                                </td>
                                                                <td><input type="number" class="form-control"
                                                                        name="subsidy_5_5" value="0"></td>
                                                                <td><input type="number" class="form-control"
                                                                        name="self_5_5" value="0"></td>
                                                                <td class="text-center text-danger calc-sum"
                                                                    data-category="5">0</td>
                                                                <td class="text-center calc-rate">0%</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>技術移轉費 小計</strong></td>
                                                                <td class="text-center text-danger calc-subtotal"
                                                                    data-category="5">0</td>
                                                                <td class="text-center text-danger calc-subtotal"
                                                                    data-category="5">0</td>
                                                                <td class="text-center text-danger calc-subtotal"
                                                                    data-category="5">0</td>
                                                                <td colspan="2"></td>
                                                            </tr>

                                                            <tr class="table-primary">
                                                                <td colspan="6">
                                                                    6.國內差旅費
                                                                </td>
                                                            </tr>
                                                            <tr data-category="6">
                                                                <td>(1) 國內差旅費 <a href="#" class="ms-2"><i
                                                                            class="bi bi-pencil"></i></a></td>
                                                                <td><input type="number" class="form-control"
                                                                        name="subsidy_6_1" value="0"></td>
                                                                <td><input type="number" class="form-control"
                                                                        name="self_6_1" value="0"></td>
                                                                <td class="text-center text-danger calc-sum"
                                                                    data-category="6">0</td>
                                                                <td class="text-center calc-rate">0%</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>國內差旅費 小計</strong></td>
                                                                <td class="text-center text-danger calc-subtotal"
                                                                    data-category="6">0</td>
                                                                <td class="text-center text-danger calc-subtotal"
                                                                    data-category="6">0</td>
                                                                <td class="text-center text-danger calc-subtotal"
                                                                    data-category="6">0</td>
                                                                <td colspan="2"></td>
                                                            </tr>

                                                        </tbody>
                                                        <tfoot class="table-secondary">
                                                            <tr>
                                                                <td class="text-end"><strong>合計</strong></td>
                                                                <td id="total-subsidy" class="text-center text-danger">0
                                                                </td>
                                                                <td id="total-self" class="text-center text-danger">0</td>
                                                                <td id="total-all" class="text-center text-danger">0</td>
                                                                <td colspan="2"></td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
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
        function updateSums() {
            let totalSubsidy = 0;
            let totalSelf = 0;
            const subtotals = {};

            document.querySelectorAll('tbody tr[data-category]').forEach(row => {
                const category = row.dataset.category;
                const inputs = row.querySelectorAll('input[type="number"]');
                if (inputs.length >= 2) {
                    const sub = parseInt(inputs[0].value) || 0;
                    const self = parseInt(inputs[1].value) || 0;
                    const sum = sub + self;

                    if (!subtotals[category]) subtotals[category] = {
                        sub: 0,
                        self: 0
                    };
                    subtotals[category].sub += sub;
                    subtotals[category].self += self;

                    row.querySelector('.calc-sum').innerText = sum.toLocaleString();

                    totalSubsidy += sub;
                    totalSelf += self;
                }
            });

            const totalAll = totalSubsidy + totalSelf;
            document.getElementById('total-subsidy').innerText = totalSubsidy.toLocaleString();
            document.getElementById('total-self').innerText = totalSelf.toLocaleString();
            document.getElementById('total-all').innerText = totalAll.toLocaleString();

            document.querySelectorAll('tbody tr[data-category]').forEach(row => {
                const sumCell = row.querySelector('.calc-sum');
                const rateCell = row.querySelector('.calc-rate');
                if (sumCell && rateCell) {
                    const rowSum = parseInt(sumCell.innerText.replace(/,/g, '')) || 0;
                    const percent = totalAll ? (rowSum / totalAll * 100).toFixed(1) : 0;
                    rateCell.innerText = percent + '%';
                }
            });

            Object.keys(subtotals).forEach(cat => {
                const sub = document.querySelector(`.calc-subtotal[data-category="${cat}"]`);
                if (sub) sub.innerText = subtotals[cat].sub.toLocaleString();
                const self = sub?.nextElementSibling;
                if (self) self.innerText = subtotals[cat].self.toLocaleString();
                const total = self?.nextElementSibling;
                if (total) total.innerText = (subtotals[cat].sub + subtotals[cat].self).toLocaleString();
            });
        }

        setTimeout(() => {
            document.querySelectorAll('input[type="number"]').forEach(input => {
                input.addEventListener('input', updateSums);
            });
        }, 100);
    </script>
@endsection
