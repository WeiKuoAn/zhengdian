@php
    $settingLabels = [
        'meta_title' => '頁面標題',
        'meta_description' => '搜尋結果描述',
        'hero_eyebrow' => '上方小標',
        'hero_tagline' => '副標語',
        'hero_title' => '主標題',
        'hero_lead' => '說明文字',
        'hero_btn_primary' => '主要按鈕',
        'hero_btn_secondary' => '次要按鈕',
        'workflow_footer' => '流程底部補充',
        'cases_disclaimer' => '免責聲明',
        'academic_note' => '底部備註',
        'cta_title' => '聯絡區標題',
        'cta_text' => '聯絡區說明',
        'contact_name' => '服務窗口',
        'contact_phone' => '手機',
        'contact_tel' => '市話',
        'contact_email' => 'Email',
        'contact_line_url' => 'LINE 連結',
        'footer_desc' => '頁尾簡介',
    ];
    foreach (['services', 'workflow', 'themes', 'scenarios', 'cases', 'academic', 'why'] as $prefix) {
        $settingLabels[$prefix . '_eyebrow'] = '小標籤';
        $settingLabels[$prefix . '_title'] = '區塊標題';
        $settingLabels[$prefix . '_subtitle'] = '區塊說明';
    }
    $settingKeys = \App\Support\LandingSectionRegistry::settingKeysFor($sectionKey);
    $previewUrl = route('landing.test') . ($section['anchor'] ?? '');
@endphp

@extends('layouts.vertical', ['title' => '編輯官網｜' . $section['label']])

@section('css')
<style>
.landing-editor-hero {
    background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 55%, #2563eb 100%);
    border-radius: 16px;
    color: #fff;
    padding: 24px 28px;
}
.landing-section-nav {
    margin-bottom: 1.5rem;
}
.landing-section-nav .card-body {
    padding: 16px !important;
}
.landing-section-tabs {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
    gap: 8px;
    width: 100%;
}
.landing-section-tabs .tab-link {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 9px 12px;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    background: #fff;
    color: #475569;
    font-size: 12px;
    font-weight: 600;
    line-height: 1.3;
    text-align: center;
    min-width: 0;
    transition: all .2s ease;
}
.landing-section-tabs .tab-link i {
    font-size: 16px;
    flex-shrink: 0;
}
.landing-section-tabs .tab-link span {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.landing-section-tabs .tab-link:hover {
    border-color: #93c5fd;
    color: #1d4ed8;
    background: #eff6ff;
}
.landing-section-tabs .tab-link.active {
    background: linear-gradient(135deg, #1e3a8a, #2563eb);
    border-color: transparent;
    color: #fff;
    box-shadow: 0 4px 12px rgba(37, 99, 235, .2);
}
.landing-panel {
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    background: #fff;
    box-shadow: 0 8px 24px rgba(15, 23, 42, .04);
    overflow: hidden;
}
.landing-panel-header {
    padding: 18px 22px;
    border-bottom: 1px solid #f1f5f9;
    background: linear-gradient(180deg, #fafbff 0%, #fff 100%);
}
.landing-panel-body { padding: 22px; }
.landing-items-table {
    width: 100%;
    table-layout: fixed;
    margin-bottom: 0;
}
.landing-items-table thead th {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: .04em;
    color: #64748b;
    background: #f8fafc;
    white-space: nowrap;
    vertical-align: middle;
}
.landing-items-table td {
    vertical-align: middle;
    word-break: break-word;
}
.landing-items-table .col-index { width: 48px; }
.landing-items-table .col-title { width: 18%; }
.landing-items-table .col-sub { width: 20%; }
.landing-items-table .col-body {
    width: auto;
    max-width: 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.landing-items-table .col-seq { width: 64px; }
.landing-items-table .col-status { width: 88px; }
.landing-items-table .col-actions {
    width: 72px;
    white-space: nowrap;
}
.landing-type-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 999px;
    background: #eff6ff;
    color: #1d4ed8;
    font-size: 12px;
    font-weight: 700;
}
@media (max-width: 991.98px) {
    .landing-items-table .col-body,
    .landing-items-table .col-body-h {
        display: none;
    }
}
@media (max-width: 767.98px) {
    .landing-section-tabs {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
    .landing-items-table .col-sub,
    .landing-items-table .col-sub-h {
        display: none;
    }
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    @include('layouts.shared.page-title', ['title' => '編輯官網', 'subtitle' => '前端管理'])

    @include('landing_admin.partials.preview_bar')

    <div class="landing-editor-hero mb-4 d-flex flex-wrap justify-content-between align-items-start gap-3">
        <div>
            <div class="small text-white-50 mb-1">依官網區段編輯 · 文案與列表在同一頁</div>
            <h4 class="mb-2 text-white">{{ $section['label'] }}</h4>
            <p class="mb-0 text-white-50">{{ $section['hint'] }}</p>
        </div>
        <a href="{{ $previewUrl }}" target="_blank" rel="noopener" class="btn btn-light btn-sm">
            <i class="mdi mdi-open-in-new me-1"></i>預覽此區段
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm landing-section-nav">
        <div class="card-body">
            <div class="landing-section-tabs">
                @foreach ($sections as $key => $meta)
                    <a href="{{ route('landing.sections', ['section' => $key]) }}"
                        class="tab-link {{ $sectionKey === $key ? 'active' : '' }}"
                        title="{{ $meta['label'] }}">
                        <i class="mdi {{ $meta['icon'] }}"></i>
                        <span>{{ $meta['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    @if ($settingKeys !== [])
        <div class="landing-panel mb-4">
            <div class="landing-panel-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">區塊文案</h5>
                    <div class="text-muted small">標題、說明等文字設定</div>
                </div>
            </div>
            <div class="landing-panel-body">
                <form method="POST" action="{{ route('landing.sections.update', $sectionKey) }}">
                    @csrf
                    <div class="row g-3">
                        @foreach ($settingKeys as $key)
                            @php
                                $isLong = in_array($key, [
                                    'meta_description', 'hero_title', 'hero_lead',
                                    'cta_title', 'cta_text', 'footer_desc',
                                    'cases_disclaimer', 'academic_note',
                                ], true) || str_ends_with($key, '_subtitle');
                            @endphp
                            <div class="{{ $isLong ? 'col-12' : 'col-md-6' }}">
                                <label class="form-label fw-semibold">{{ $settingLabels[$key] ?? $key }}</label>
                                @if ($isLong)
                                    <textarea class="form-control" name="{{ $key }}" rows="{{ in_array($key, ['hero_title', 'cta_title'], true) ? 2 : 3 }}">{{ old($key, $settings[$key] ?? '') }}</textarea>
                                @else
                                    <input type="text" class="form-control" name="{{ $key }}" value="{{ old($key, $settings[$key] ?? '') }}">
                                @endif
                                @if ($key === 'hero_title' || $key === 'cta_title')
                                    <div class="form-text">需要換行時按 Enter</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fe-check-circle me-1"></i>儲存文案
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if ($sectionKey === 'cases')
        <div class="alert alert-light border d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
            <div class="small mb-0">
                <i class="mdi mdi-information-outline me-1"></i>
                此頁只編輯區塊標題與說明。產業分類與客戶 Logo 請到獨立頁面管理。
            </div>
            <a href="{{ route('landing.industry-categories') }}" class="btn btn-sm btn-outline-primary">
                <i class="mdi mdi-domain me-1"></i>管理產業類別與 Logo
            </a>
        </div>
    @endif

    @foreach ($section['content_types'] ?? [] as $type)
        <div class="landing-panel mb-4">
            <div class="landing-panel-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <span class="landing-type-chip mb-2"><i class="mdi mdi-format-list-bulleted"></i>{{ $typeLabels[$type] ?? $type }}</span>
                    <div class="text-muted small">{{ $typeHints[$type] ?? '' }}</div>
                </div>
                <a href="{{ route('landing.content-items.create', ['type' => $type, 'section' => $sectionKey]) }}" class="btn btn-sm btn-danger">
                    <i class="mdi mdi-plus-circle me-1"></i>新增
                </a>
            </div>
            <div class="landing-panel-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 landing-items-table">
                        <thead>
                            <tr>
                                <th class="col-index">#</th>
                                <th class="col-title">主標題 / 數字</th>
                                <th class="col-sub col-sub-h">副標 / 圖示</th>
                                <th class="col-body col-body-h">內容</th>
                                <th class="col-seq">排序</th>
                                <th class="col-status">狀態</th>
                                <th class="col-actions"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($itemsByType[$type] ?? [] as $index => $item)
                                <tr>
                                    <td class="col-index">{{ $index + 1 }}</td>
                                    <td class="col-title fw-semibold">{{ $item->title }}</td>
                                    <td class="col-sub">{{ $item->subtitle ?: $item->icon }}{{ $item->extra ? ' / ' . $item->extra : '' }}</td>
                                    <td class="col-body text-muted small" title="{{ $item->body }}">{{ \Illuminate\Support\Str::limit($item->body, 48) }}</td>
                                    <td class="col-seq">{{ $item->seq }}</td>
                                    <td class="col-status">
                                        <span class="badge {{ $item->status === 'up' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                                            {{ $item->status === 'up' ? '顯示中' : '已隱藏' }}
                                        </span>
                                    </td>
                                    <td class="col-actions text-end">
                                        <a href="{{ route('landing.content-items.edit', ['id' => $item->id, 'section' => $sectionKey]) }}" class="action-icon"><i class="mdi mdi-square-edit-outline"></i></a>
                                        @if (in_array((int) (Auth::user()->level ?? 2), [0, 1], true))
                                            <a href="{{ route('landing.content-items.del', ['id' => $item->id, 'section' => $sectionKey]) }}" class="action-icon"><i class="mdi mdi-trash-can-outline"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">尚無資料，請按「新增」</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
