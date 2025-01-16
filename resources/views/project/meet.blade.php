@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', ['title' => '設定管理', 'subtitle' => '簽約類別新增'])

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start mb-3">
                            <div class="w-100 ">
                                <h3 class="mt-1 mb-0">{{ $data->user_data->name }}【{{ $data->cust_data->name }}】</h5>
                                    <p class="mb-1 mt-1 text-muted">計畫登入帳號：ＸＸＸ　計畫登入密碼：ＸＸＸ</p>
                            </div>
                        </div>
                        <ul class="nav nav-tabs nav-bordered nav-justified">
                            <li class="nav-item">
                                <a href="{{ route('project.edit', $data->user_id) }}" aria-expanded="true"
                                    class="nav-link">
                                    專案基本設定
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.background', $data->user_id) }}" aria-expanded="false" class="nav-link ">
                                    專案背景調查
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.write', $data->user_id) }}" aria-expanded="false"
                                    class="nav-link">
                                    內容撰寫
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.send', $data->user_id) }}" aria-expanded="false" class="nav-link">
                                    送件作業
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.plan', $data->user_id) }}" aria-expanded="false"
                                    class="nav-link">
                                    排程作業
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.task', $data->user_id) }}" aria-expanded="false" class="nav-link">
                                    派工作業
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.midterm', $data->user_id) }}" aria-expanded="false" class="nav-link">
                                    期中報告/檢核
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.final', $data->user_id) }}" aria-expanded="false" class="nav-link">
                                    期末報告/結案
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.meet', $data->user_id) }}" aria-expanded="false" class="nav-link active">
                                    會議瀏覽
                                </a>
                            </li>
                        </ul>
                        <form action="{{ route('customer.create.data') }}" method="POST">
                            @csrf
                            <div class="row mt-3">
                                <ul class="nav nav-pills nav-justified" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#overview" role="tab">
                                            <span>企業資料</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#tabpane2" role="tab">
                                            <span>計畫綱要</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#tabpane3" role="tab">
                                            <span>計畫構想</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#messages" role="tab">
                                            <span>人事與被帶動企業</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#post" role="tab">
                                            <span>執行時程</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#tabpane6" role="tab">
                                            <span>預期效益</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#tabpane7" role="tab">
                                            <span>經費需求</span>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-pane active" id="overview" role="tabpanel">
                                    <div class="col-12 mb-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="text-center mb-3">
                                                    <h2>客戶基本資料</h2>
                                                </div>
                                                <div class="row">'
                                                    <div class="col-md-12">
                                                        <div class="mb-4">
                                                            <label class="form-label" for="AddNew-Username"><b>客戶名稱</b><span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control required-input" value="{{ $data->cust_data->user_data->name }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-4">
                                                            <label class="form-label" for="AddNew-Username"><b>公司統編</b><span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control required-input" name="registration_no" value="{{ $data->cust_data->registration_no }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-4">
                                                            <label class="form-label" for="AddNew-Username"><b>成立日期</b><span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control required-input" name="create_date"  @if(isset($word_data)) value="{{ $word_data->create_date }}" @endif>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-4">
                                                            <label class="form-label" for="AddNew-Username"><b>是否為新創</b><span class="text-danger">*</span></label>
                                                            <select class="mobile form-select" name="startup">
                                                                <option value="">請選擇...</option>
                                                                <option value="是" @if(isset($word_data)) @if($word_data->startup == "是") selected @endif @endif>是</option>
                                                                <option value="否 "@if(isset($word_data)) @if($word_data->startup == "否") selected @endif @endif>否</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="mb-4">
                                                            <label class="form-label" for="AddNew-Username"><b>企業網址</b><span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control required-input" name="website" @if(isset($word_data)) value="{{ $word_data->website }}" @endif>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-4">
                                                            <label class="form-label" for="AddNew-Username"><b>企業負責人</b><span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control required-input" name="principal_name" value="{{ $data->cust_data->principal_name }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-4">
                                                            <label class="form-label" for="AddNew-Username"><b>負責人職稱</b><span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control required-input" name="principal_job" @if(isset($word_data)) value="{{ $word_data->principal_job }}" @endif>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-4">
                                                            <label class="form-label" for="AddNew-Username"><b>負責人性別</b><span class="text-danger">*</span></label>
                                                            <select class="mobile form-select" name="principal_sex">
                                                                <option value="" >請選擇...</option>
                                                                <option value="男"  @if(isset($word_data)) @if($word_data->principal_sex == "男") selected @endif @endif>男</option>
                                                                <option value="女"  @if(isset($word_data)) @if($word_data->principal_sex == "女") selected @endif @endif>女</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-4">
                                                            <label class="form-label" for="AddNew-Username"><b>企業電話</b><span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control required-input" name="mobile"  @if(isset($word_data)) value="{{ $word_data->mobile }}" @endif>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-4">
                                                            <label class="form-label" for="AddNew-Username"><b>企業傳真</b><span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control required-input" name="fax" @if(isset($word_data)) value="{{ $word_data->fax }}" @endif>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label" for="AddNew-Phone">員工人數<span class="text-danger">*</span></label>
                                                        <div class="mb-4">
                                                            <input type="number" class="form-control required-input" placeholder="總投保人數" name="insurance_total"  id="insurance_total"  value="{{ $data->cust_data->insurance_total }}" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-4">
                                                            <label class="form-label" for="AddNew-Phone"><b>資本額</b><span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control required-input" name="capital_amount" @if(isset($word_data))  value="{{ $word_data->capital_amount }}" @else value="0" @endif>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-4">
                                                            <label class="form-label" for="AddNew-Phone"><b>主要營業項目</b><span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control required-input" name="business_activities" @if(isset($word_data))  value="{{ $word_data->business_activities }}" @else value="0" @endif>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-4">
                                                            <label class="form-label" for="AddNew-Phone"><b>產業領域別</b><span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control required-input" name="industry_category" @if(isset($word_data))  value="{{ $word_data->industry_category }}" @else value="0" @endif>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="mb-4">
                                                            <label class="form-label" for="AddNew-Phone"><b>去年整年度營業額（單位：元/新台幣）</b><span class="text-danger">*</span></label>
                                                            <input type="number" class="form-control required-input" name="last_year_revenue" @if(isset($project)) value="{{ $data->cust_data->last_year_revenue }}" @else value="0" @endif>
                                                        </div>
                                                    </div>
                                                    
                                                    <hr>
            
                                                    <div class="col-md-12">
                                                        <div class="mb-4">
                                                            <label class="form-label" for="AddNew-Username"><b>企業簡介</b><span class="text-danger">*</span></label>
                                                            <textarea class="form-control"  rows="5" name="introduction">@if(isset($word_data)){{ $word_data->introduction }}@endif</textarea>
                                                        </div>
                                                        {{-- <textarea id="ckeditor-classic" name="editorContent">@if(isset($word)){{ $word->text }}@endif</textarea> --}}
                                                    </div>
            
                                                    <div class="col-md-12">
                                                        <div class="mb-4">
                                                            <label class="form-label">企業代表色</label>
                                                            <input class="jscolor form-control" value="@if(isset($word_data)){{ $word_data->color }}@endif" id="colorpicker-default" name="color">
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                    
            
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col-->
                            <div class="row mt-3">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                            class="fe-check-circle me-1"></i>儲存</button>
                                    <button type="reset" class="btn btn-secondary waves-effect waves-light m-1"
                                        onclick="history.go(-1)"><i class="fe-x me-1"></i>回上一頁</button>
                                </div>
                            </div>
                    </div>
                </div>
                <!-- end row -->

                </form>
            </div> <!-- end card-body -->
        </div> <!-- end card-->
        <!-- end row -->

    </div> <!-- container -->
@endsection
