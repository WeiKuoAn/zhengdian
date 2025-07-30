@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('content')
    <style>
        textarea {
            white-space: pre;
        }
    </style>
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
                                <a href="{{ route('project.edit', $project->id) }}" aria-expanded="false" class="nav-link ">
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
                                <a href="{{ route('project.write', $project->id) }}" aria-expanded="false" class="nav-link">
                                    人事/帶動企業
                                </a>
                            </li>
                            @if ($project->type == '3')
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
                                <a href="{{ route('project.accounting', $project->id) }}" aria-expanded="true"
                                    class="nav-link ">
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
            <form action="{{ route('project.sbir03.data', $project->id) }}" method="POST">
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
                                                <a href="{{ route('project.sbir03', $project->id) }}"
                                                    class="nav-link active">
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
                                                    拾壹、附件
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.supplement', $project->id) }}" class="nav-link">
                                                    拾貳、補充資料
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="card-body">
                                            <div class="mb-5">
                                                <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">計畫摘要表</h5>

                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        一、計畫內容摘要（選填，填寫時需100~300字）
                                                    </label>
                                                    <textarea class="form-control" id="plan_summary" name="plan_summary" rows="5" maxlength="300">
@if (isset($sbir03_data))
{{ $sbir03_data->plan_summary }}
@endif
</textarea>
                                                    <div class="row">
                                                        <div class="form-text text-start col-md-6">
                                                            <span id="plan_summary_error"
                                                                class="d-block small text-danger" style="display:none;">
                                                                填寫內容需至少 100 字
                                                            </span>
                                                        </div>
                                                        <div class="form-text text-end col-md-6">
                                                            <span id="plan_summary_count">0</span> / 300 字
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        二、計畫創新重點（選填，填寫時需100~300字）
                                                    </label>
                                                    <textarea class="form-control" id="innovation_focus" name="innovation_focus" rows="5" maxlength="300">
@if (isset($sbir03_data))
{{ $sbir03_data->innovation_focus }}
@endif
</textarea>
                                                    <div class="row">
                                                        <div class="form-text text-start col-md-6">
                                                            <span id="innovation_focus_error"
                                                                class="d-block small text-danger" style="display:none;">
                                                                填寫內容需至少 100 字
                                                            </span>
                                                        </div>
                                                        <div class="form-text text-end col-md-6">
                                                            <span id="innovation_focus_count">0</span> / 300 字

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        三、執行優勢（選填，填寫時需100~300字）
                                                    </label>
                                                    <textarea class="form-control" id="execution_advantage" name="execution_advantage" rows="5" maxlength="300">
@if (isset($sbir03_data))
{{ $sbir03_data->execution_advantage }}
@endif
</textarea>
                                                    <div class="row">
                                                        <div class="form-text text-start col-md-6">
                                                            <span id="execution_advantage_error"
                                                                class="d-block small text-danger" style="display:none;">
                                                                填寫內容需至少 100 字
                                                            </span>
                                                        </div>
                                                        <div class="form-text text-end col-md-6">
                                                            <span id="execution_advantage_count">0</span> / 300 字
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="mb-3">
                                                <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">
                                                    四、預期效益（請於三年內量化效益）<span class="text-danger">*</span></h5>
                                            </div>

                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <label class="form-label">1. 增加產值 (千元)<span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" class="form-control"
                                                        name="benefit_output_value"
                                                        @if (isset($sbir03_data)) value="{{ $sbir03_data->benefit_output_value }}" @endif>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">2. 產出新產品或服務 (項)<span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" class="form-control"
                                                        name="benefit_new_products"
                                                        @if (isset($sbir03_data)) value="{{ $sbir03_data->benefit_new_products }}" @endif>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">3. 衍生商品或服務數 (項)<span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" class="form-control"
                                                        name="benefit_derived_products"
                                                        @if (isset($sbir03_data)) value="{{ $sbir03_data->benefit_derived_products }}" @endif>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">4. 投入研發費用 (千元)<span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" name="benefit_rnd_cost"
                                                        @if (isset($sbir03_data)) value="{{ $sbir03_data->benefit_rnd_cost }}" @endif>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">5. 促成投資額 (千元)<span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" name="benefit_investment"
                                                        @if (isset($sbir03_data)) value="{{ $sbir03_data->benefit_investment }}" @endif>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">6. 降低成本 (千元)<span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" class="form-control"
                                                        name="benefit_cost_reduction"
                                                        @if (isset($sbir03_data)) value="{{ $sbir03_data->benefit_cost_reduction }}" @endif>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">7. 增加就業人數 (人)<span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" class="form-control"
                                                        name="benefit_jobs_created"
                                                        @if (isset($sbir03_data)) value="{{ $sbir03_data->benefit_jobs_created }}" @endif>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">8. 成立新公司 (家)<span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" class="form-control"
                                                        name="benefit_new_companies"
                                                        @if (isset($sbir03_data)) value="{{ $sbir03_data->benefit_new_companies }}" @endif>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">9. 發明專利 (件)<span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" name="benefit_patents"
                                                        @if (isset($sbir03_data)) value="{{ $sbir03_data->benefit_patents }}" @endif>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">10. 新型／新式樣專利 (件)<span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" class="form-control" name="benefit_new_patents"
                                                        @if (isset($sbir03_data)) value="{{ $sbir03_data->benefit_new_patents }}" @endif>
                                                </div>
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
                                                <a href="{{ route('sbir.exportMerged', $project->id) }}"
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
        document.querySelectorAll('textarea[id]').forEach(textarea => {
            const minLen = 100;
            const maxLen = parseInt(textarea.getAttribute('maxlength'), 10);
            const countEl = document.getElementById(textarea.id + '_count');
            const errEl = document.getElementById(textarea.id + '_error');

            function update() {
                const len = textarea.value.trim().length;
                countEl.textContent = len;
                // 當有輸入且未達最低字數時顯示錯誤
                if (len > 0 && len < minLen) {
                    errEl.style.display = 'block';
                } else {
                    errEl.style.display = 'none';
                }
                // maxlength 會自動阻止超過 maxLen
            }

            // 綁定事件
            textarea.addEventListener('input', update);
            // 頁面載入時先初始化一次
            update();
        });
    </script>
@endsection
