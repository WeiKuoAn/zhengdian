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
            <form action="{{ route('project.sbir01.data', $project->id) }}" method="POST">
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
                                                <a href="{{ route('project.sbir01', $project->id) }}"
                                                    class="nav-link active">
                                                    壹、計畫書基本資料
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir02', $project->id) }}" class="nav-link">
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
                                                <a href="{{ route('project.sbir07', $project->id) }}" class="nav-link">
                                                    附件
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="planName" class="form-label"><b>計畫名稱</b><span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="planName"
                                                    name="planName" placeholder="請輸入計畫名稱"
                                                    value="{{ old('planName', $data->plan_name ?? '') }}" required>
                                            </div>

                                            <!-- 屬性 -->
                                            <div class="mb-3">
                                                <label for="attribute" class="form-label"><b>屬性</b><span
                                                        class="text-danger">*</span></label>
                                                <select id="attribute" class="form-select" name="attribute" required>
                                                    <option disabled
                                                        {{ old('attribute', $data->attribute ?? '') == '' ? 'selected' : '' }}>
                                                        請選擇</option>
                                                    <option value="tech"
                                                        {{ old('attribute', $data->attribute ?? '') == 'tech' ? 'selected' : '' }}>
                                                        創新技術</option>
                                                    <option value="service"
                                                        {{ old('attribute', $data->attribute ?? '') == 'service' ? 'selected' : '' }}>
                                                        創新服務</option>
                                                </select>
                                            </div>

                                            <!-- 階段 -->
                                            <div class="mb-3">
                                                <label for="stage" class="form-label"><b>階段</b><span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select" id="stage" name="stage" required>
                                                    <option selected disabled>請選擇</option>
                                                </select>
                                            </div>

                                            <!-- 領域 -->
                                            <div class="mb-3">
                                                <label for="domain" class="form-label"><b>領域</b><span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select" id="domain" name="domain" required>
                                                    <option selected disabled>請選擇</option>
                                                </select>
                                            </div>

                                            <!-- 計畫特色 -->
                                            <div class="mb-3">
                                                <label for="feature" class="form-label"><b>計畫特色</b><span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select" id="feature" name="feature" required>
                                                    <option value="一般"
                                                        {{ old('feature', $data->feature ?? '') == '一般' ? 'selected' : '' }}>
                                                        一般(免填計畫特色表)</option>
                                                    <option value="數位轉型"
                                                        {{ old('feature', $data->feature ?? '') == '數位轉型' ? 'selected' : '' }}>
                                                        數位轉型(需填計畫特色表)</option>
                                                    <option value="淨零排放"
                                                        {{ old('feature', $data->feature ?? '') == '淨零排放' ? 'selected' : '' }}>
                                                        淨零排放(需填計畫特色表)</option>
                                                </select>
                                            </div>

                                            <!-- 申請對象 -->
                                            <div class="mb-3">
                                                <label for="target" class="form-label"><b>申請對象</b><span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select" id="target" name="target" required>
                                                    <option value="" disabled
                                                        {{ old('target', $data->target ?? '') == '' ? 'selected' : '' }}>
                                                        請選擇</option>
                                                    <option value="個別申請"
                                                        {{ old('target', $data->target ?? '') == '個別申請' ? 'selected' : '' }}>
                                                        個別申請</option>
                                                    <option value="自提式聯盟"
                                                        {{ old('target', $data->target ?? '') == '自提式聯盟' ? 'selected' : '' }}>
                                                        自提式聯盟</option>
                                                </select>
                                            </div>

                                            <!-- 計畫起日 -->
                                            <div class="mb-3">
                                                <label class="form-label"><b>計畫起日<br><small
                                                            class="text-muted">開始月份之1日</small></b><span
                                                        class="text-danger">*</span></label>
                                                <div class="row g-2">
                                                    <div class="col-md-12">
                                                        <input type="text" name="start_date" class="date form-control change_cal_date" value="{{ $data->start_date }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- 計畫迄日 -->
                                            <div class="mb-3">
                                                <label class="form-label"><b>計畫迄日<br><small
                                                            class="text-muted">結束月份之最後一天</small></b><span
                                                        class="text-danger">*</span></label>
                                                <div class="row g-2">
                                                    <div class="col-md-12">
                                                        <input type="text" name="end_date" class="date form-control change_cal_date" value="{{ $data->end_date }}">
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- 按鈕 -->
                                            <div class="d-flex justify-content-start gap-2">
                                                <button type="submit" class="btn btn-teal btn-success">送出存檔</button>
                                                <button type="button" class="btn btn-primary">回上一頁</button>
                                                <!-- 匯出 Word 按鈕 -->
                                                <a href="{{ route('sbir.exportWord', $project->id) }}"
                                                    class="btn btn-success">
                                                    匯出計畫書 Word 檔
                                                </a>
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
        const attributeSelect = document.getElementById('attribute');
        const stageSelect = document.getElementById('stage');
        const domainSelect = document.getElementById('domain');

        const stageOptions = {
            tech: [{
                    value: 'r&d',
                    text: '研究開發(Phase 2)'
                },
                {
                    value: 'value_add',
                    text: '加值應用(Phase 2+)'
                }
            ],
            service: [{
                    value: 'detail',
                    text: '細部計畫(Phase 2)'
                },
                {
                    value: 'value_add',
                    text: '加值應用(Phase 2+)'
                }
            ]
        };

        const domainOptions = {
            'r&d': ['民生化工', '生技製藥', '資通', '電子', '機械'],
            'value_add': {
                tech: ['民生化工', '生技製藥', '資通', '電子', '機械'],
                service: ['服務']
            },
            'detail': ['服務']
        };

        const oldAttribute = @json(old('attribute', $data->attribute ?? ''));
        const oldStage = @json(old('stage', $data->stage ?? ''));
        const oldDomain = @json(old('domain', $data->domain ?? ''));

        function initStageOptions(attribute, selectedStage) {
            stageSelect.innerHTML = '<option selected disabled>請選擇</option>';
            if (attribute && stageOptions[attribute]) {
                stageOptions[attribute].forEach(option => {
                    const opt = document.createElement('option');
                    opt.value = option.value;
                    opt.textContent = option.text;
                    if (option.value === selectedStage) opt.selected = true;
                    stageSelect.appendChild(opt);
                });
            }
        }

        function initDomainOptions(stage, attribute, selectedDomain) {
            domainSelect.innerHTML = '<option selected disabled>請選擇</option>';
            let domains = [];

            if (stage === 'r&d' || stage === 'detail') {
                domains = domainOptions[stage] || [];
            } else if (stage === 'value_add') {
                domains = domainOptions[stage]?.[attribute] || [];
            }

            domains.forEach(domain => {
                const opt = document.createElement('option');
                opt.value = domain;
                opt.textContent = domain;
                if (domain === selectedDomain) opt.selected = true;
                domainSelect.appendChild(opt);
            });
        }

        attributeSelect.addEventListener('change', function() {
            initStageOptions(this.value, '');
            domainSelect.innerHTML = '<option selected disabled>請先選擇階段</option>';
        });

        stageSelect.addEventListener('change', function() {
            initDomainOptions(this.value, attributeSelect.value, '');
        });

        if (oldAttribute) {
            attributeSelect.value = oldAttribute;
            initStageOptions(oldAttribute, oldStage);
            initDomainOptions(oldStage, oldAttribute, oldDomain);
        }

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
@endsection
