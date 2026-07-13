@extends('layouts.vertical', ['title' => '文案與聯絡'])

@section('content')
    <div class="container-fluid">
        @include('layouts.shared.page-title', ['title' => '文案與聯絡', 'subtitle' => '前端管理'])

        @include('landing_admin.partials.preview_bar')

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <p class="text-muted small mb-4">
                            這裡調整官網「標題、說明、按鈕文字」與聯絡方式。若某一區塊裡有多張卡片或列表，請到
                            <a href="{{ route('landing.content-items', ['type' => 'stat']) }}">區塊內容</a> 編輯。
                        </p>

                        <form method="POST" action="{{ route('landing.settings.update') }}">
                            @csrf

                            <div class="accordion landing-settings-accordion" id="landingSettingsAccordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading-seo">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#section-seo" aria-expanded="true">
                                            搜尋引擎設定（Google 搜尋結果）
                                        </button>
                                    </h2>
                                    <div id="section-seo" class="accordion-collapse collapse show" data-bs-parent="#landingSettingsAccordion">
                                        <div class="accordion-body">
                                            <div class="mb-3">
                                                <label class="form-label">頁面標題</label>
                                                <input type="text" class="form-control" name="meta_title" value="{{ old('meta_title', $settings['meta_title'] ?? '') }}">
                                                <div class="form-text">顯示在瀏覽器分頁與 Google 搜尋結果標題</div>
                                            </div>
                                            <div class="mb-0">
                                                <label class="form-label">搜尋結果描述</label>
                                                <textarea class="form-control" name="meta_description" rows="2">{{ old('meta_description', $settings['meta_description'] ?? '') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading-hero">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#section-hero">
                                            首頁主視覺（一進官網看到的大區塊）
                                        </button>
                                    </h2>
                                    <div id="section-hero" class="accordion-collapse collapse" data-bs-parent="#landingSettingsAccordion">
                                        <div class="accordion-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">上方小標</label>
                                                    <input type="text" class="form-control" name="hero_eyebrow" value="{{ old('hero_eyebrow', $settings['hero_eyebrow'] ?? '') }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">副標語</label>
                                                    <input type="text" class="form-control" name="hero_tagline" value="{{ old('hero_tagline', $settings['hero_tagline'] ?? '') }}">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">主標題</label>
                                                <textarea class="form-control" name="hero_title" rows="2">{{ old('hero_title', $settings['hero_title'] ?? '') }}</textarea>
                                                <div class="form-text">需要換行時直接按 Enter</div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">說明文字</label>
                                                <textarea class="form-control" name="hero_lead" rows="3">{{ old('hero_lead', $settings['hero_lead'] ?? '') }}</textarea>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-0">
                                                    <label class="form-label">主要按鈕（例如：預約補助健檢）</label>
                                                    <input type="text" class="form-control" name="hero_btn_primary" value="{{ old('hero_btn_primary', $settings['hero_btn_primary'] ?? '') }}">
                                                </div>
                                                <div class="col-md-6 mb-0">
                                                    <label class="form-label">次要按鈕</label>
                                                    <input type="text" class="form-control" name="hero_btn_secondary" value="{{ old('hero_btn_secondary', $settings['hero_btn_secondary'] ?? '') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @php
                                    $sectionBlocks = [
                                        'services' => ['label' => '服務架構', 'hint' => '四宮格服務介紹區塊的標題；卡片內容請到「區塊內容 → 服務架構」'],
                                        'workflow' => ['label' => '補助流程', 'hint' => '六步驟流程區塊的標題；步驟內容請到「區塊內容 → 補助流程」', 'footer' => true],
                                        'themes' => ['label' => '補助主題', 'hint' => '三張主題卡片區塊的標題'],
                                        'scenarios' => ['label' => '服務場景', 'hint' => '三種情境說明區塊的標題'],
                                        'cases' => ['label' => '產業案例 Brand Wall', 'hint' => '客戶 Logo 牆上方的標題；Logo 請到「產業案例與客戶 Logo」', 'disclaimer' => true],
                                        'academic' => ['label' => '國際資源', 'hint' => '產學合作、院校與國家列表區塊的標題', 'note' => true],
                                        'why' => ['label' => '為什麼選擇錚典', 'hint' => '四大優勢區塊的標題'],
                                    ];
                                @endphp

                                @foreach ($sectionBlocks as $prefix => $block)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading-{{ $prefix }}">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#section-{{ $prefix }}">
                                                {{ $block['label'] }}（區塊標題）
                                            </button>
                                        </h2>
                                        <div id="section-{{ $prefix }}" class="accordion-collapse collapse" data-bs-parent="#landingSettingsAccordion">
                                            <div class="accordion-body">
                                                <p class="text-muted small">{{ $block['hint'] }}</p>
                                                <div class="mb-3">
                                                    <label class="form-label">小標籤</label>
                                                    <input type="text" class="form-control" name="{{ $prefix }}_eyebrow" value="{{ old($prefix . '_eyebrow', $settings[$prefix . '_eyebrow'] ?? '') }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">區塊標題</label>
                                                    <input type="text" class="form-control" name="{{ $prefix }}_title" value="{{ old($prefix . '_title', $settings[$prefix . '_title'] ?? '') }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">區塊說明</label>
                                                    <textarea class="form-control" name="{{ $prefix }}_subtitle" rows="2">{{ old($prefix . '_subtitle', $settings[$prefix . '_subtitle'] ?? '') }}</textarea>
                                                </div>
                                                @if (!empty($block['footer']))
                                                    <div class="mb-0">
                                                        <label class="form-label">流程底部補充說明</label>
                                                        <input type="text" class="form-control" name="workflow_footer" value="{{ old('workflow_footer', $settings['workflow_footer'] ?? '') }}">
                                                    </div>
                                                @elseif (!empty($block['disclaimer']))
                                                    <div class="mb-0">
                                                        <label class="form-label">免責聲明</label>
                                                        <textarea class="form-control" name="cases_disclaimer" rows="2">{{ old('cases_disclaimer', $settings['cases_disclaimer'] ?? '') }}</textarea>
                                                    </div>
                                                @elseif (!empty($block['note']))
                                                    <div class="mb-0">
                                                        <label class="form-label">底部備註</label>
                                                        <textarea class="form-control" name="academic_note" rows="2">{{ old('academic_note', $settings['academic_note'] ?? '') }}</textarea>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading-contact">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#section-contact">
                                            聯絡我們與頁尾
                                        </button>
                                    </h2>
                                    <div id="section-contact" class="accordion-collapse collapse" data-bs-parent="#landingSettingsAccordion">
                                        <div class="accordion-body">
                                            <div class="mb-3">
                                                <label class="form-label">聯絡區標題</label>
                                                <textarea class="form-control" name="cta_title" rows="2">{{ old('cta_title', $settings['cta_title'] ?? '') }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">聯絡區說明</label>
                                                <textarea class="form-control" name="cta_text" rows="3">{{ old('cta_text', $settings['cta_text'] ?? '') }}</textarea>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">服務窗口姓名</label>
                                                    <input type="text" class="form-control" name="contact_name" value="{{ old('contact_name', $settings['contact_name'] ?? '') }}">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">手機</label>
                                                    <input type="text" class="form-control" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">市話</label>
                                                    <input type="text" class="form-control" name="contact_tel" value="{{ old('contact_tel', $settings['contact_tel'] ?? '') }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" class="form-control" name="contact_email" value="{{ old('contact_email', $settings['contact_email'] ?? '') }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">LINE 連結</label>
                                                    <input type="text" class="form-control" name="contact_line_url" value="{{ old('contact_line_url', $settings['contact_line_url'] ?? '') }}">
                                                </div>
                                            </div>
                                            <div class="mb-0">
                                                <label class="form-label">頁尾簡介</label>
                                                <textarea class="form-control" name="footer_desc" rows="3">{{ old('footer_desc', $settings['footer_desc'] ?? '') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-success px-4"><i class="fe-check-circle me-1"></i>儲存全部文案</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const hash = window.location.hash;
            if (!hash) {
                return;
            }
            const panel = document.querySelector(hash);
            if (!panel || !panel.classList.contains('accordion-collapse')) {
                return;
            }
            const collapse = bootstrap.Collapse.getOrCreateInstance(panel, { toggle: false });
            collapse.show();
            panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    </script>
@endsection
