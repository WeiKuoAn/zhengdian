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
                                                    計畫書基本資料
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir02', $project->id) }}" class="nav-link">
                                                    計畫申請表
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir03', $project->id) }}"
                                                    class="nav-link active">
                                                    計畫摘要表
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir04', $project->id) }}" class="nav-link">
                                                    公司概況
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#messages" class="nav-link">
                                                    計畫內容與實施方式
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#messages" class="nav-link">
                                                    智財分析
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#messages" class="nav-link">
                                                    計畫執行查核點說明與經費需求
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#messages" class="nav-link">
                                                    附件
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="card-body">
                                            <div class="mb-5">
                                                <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">計畫摘要表</h5>

                                                <div class="mb-3">
                                                    <label class="form-label">一、計畫內容摘要（需100~300字）<span
                                                            class="text-danger">*</span></label>
                                                    <textarea class="form-control" name="plan_summary" rows="5">
@if (isset($sbir03_data))
{{ $sbir03_data->plan_summary }}
@endif
</textarea>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">二、計畫創新重點（需100~300字）<span
                                                            class="text-danger">*</span></label>
                                                    <textarea class="form-control" name="innovation_focus" rows="5">
@if (isset($sbir03_data))
{{ $sbir03_data->innovation_focus }}
@endif
</textarea>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">三、執行優勢（公司執行本計畫優勢為何? 需100~300字）<span
                                                            class="text-danger">*</span></label>
                                                    <textarea class="form-control" name="execution_advantage" rows="5">
@if (isset($sbir03_data))
{{ $sbir03_data->execution_advantage }}
@endif
</textarea>
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
                                                        <input type="number" class="form-control"
                                                            name="benefit_rnd_cost"
                                                            @if (isset($sbir03_data)) value="{{ $sbir03_data->benefit_rnd_cost }}" @endif>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label">5. 促成投資額 (千元)<span
                                                                class="text-danger">*</span></label>
                                                        <input type="number" class="form-control"
                                                            name="benefit_investment"
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
                                                        <input type="number" class="form-control"
                                                            name="benefit_new_patents"
                                                            @if (isset($sbir03_data)) value="{{ $sbir03_data->benefit_new_patents }}" @endif>
                                                    </div>
                                                </div>
                                            </div>



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
@endsection
