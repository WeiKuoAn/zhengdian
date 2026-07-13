@extends('layouts.vertical', ['title' => '官網總覽'])

@section('content')
    <div class="container-fluid">
        @include('layouts.shared.page-title', ['title' => '官網總覽', 'subtitle' => '前端管理'])

        @include('landing_admin.partials.preview_bar')

        <div class="row g-3">
            <div class="col-md-6 col-xl-4">
                <div class="card border-primary border-opacity-25 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start gap-3 mb-3">
                            <span class="avatar-sm rounded bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center">
                                <i class="mdi mdi-pencil-box-multiple-outline fs-4"></i>
                            </span>
                            <div>
                                <h5 class="card-title mb-1">編輯官網</h5>
                                <p class="text-muted small mb-0">依官網區段編輯文案與列表內容。</p>
                            </div>
                        </div>
                        <a href="{{ route('landing.sections') }}" class="btn btn-primary btn-sm">
                            <i class="mdi mdi-arrow-right-circle-outline me-1"></i>開始編輯
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start gap-3 mb-3">
                            <span class="avatar-sm rounded bg-warning-subtle text-warning d-inline-flex align-items-center justify-content-center">
                                <i class="mdi mdi-domain fs-4"></i>
                            </span>
                            <div>
                                <h5 class="card-title mb-1">產業類別與客戶 Logo</h5>
                                <p class="text-muted small mb-0">Brand Wall 的產業分類與客戶 Logo 圖片，獨立管理。</p>
                            </div>
                        </div>
                        <a href="{{ route('landing.industry-categories') }}" class="btn btn-outline-primary btn-sm">管理 Logo</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="text-muted text-uppercase small mb-3">快速前往區段</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach (\App\Support\LandingSectionRegistry::sections() as $key => $meta)
                                <a href="{{ route('landing.sections', ['section' => $key]) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="mdi {{ $meta['icon'] }} me-1"></i>{{ $meta['label'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h5 class="mb-3">官網區塊對照（由上而下）</h5>
                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 28%">官網看到的區塊</th>
                                <th style="width: 22%">編輯頁籤</th>
                                <th>說明</th>
                            </tr>
                        </thead>
                        <tbody class="small">
                            <tr>
                                <td>首頁主視覺、按鈕</td>
                                <td><a href="{{ route('landing.sections', ['section' => 'hero']) }}">首頁主視覺</a></td>
                                <td>大標題、說明、預約補助健檢按鈕文字</td>
                            </tr>
                            <tr>
                                <td>250+、6 億等數字</td>
                                <td><a href="{{ route('landing.sections', ['section' => 'stats']) }}">數據統計</a></td>
                                <td>首頁四格實績數字</td>
                            </tr>
                            <tr>
                                <td>服務架構、補助流程…</td>
                                <td><a href="{{ route('landing.sections', ['section' => 'services']) }}">服務架構</a> 等頁籤</td>
                                <td>標題與列表內容都在同一頁</td>
                            </tr>
                            <tr>
                                <td>產業案例 Brand Wall 標題</td>
                                <td><a href="{{ route('landing.sections', ['section' => 'cases']) }}">產業案例</a></td>
                                <td>區塊標題、說明與免責聲明</td>
                            </tr>
                            <tr>
                                <td>產業分類與客戶 Logo</td>
                                <td><a href="{{ route('landing.industry-categories') }}">產業類別與客戶 Logo</a></td>
                                <td>六大產業類別與 Logo 圖片上傳</td>
                            </tr>
                            <tr>
                                <td>聯絡我們、頁尾</td>
                                <td><a href="{{ route('landing.sections', ['section' => 'contact']) }}">聯絡與頁尾</a></td>
                                <td>電話、信箱、服務窗口</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
