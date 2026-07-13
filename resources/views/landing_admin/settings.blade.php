@extends('layouts.vertical', ['title' => '官網基本內容'])

@section('content')
    <div class="container-fluid">
        @include('layouts.shared.page-title', ['title' => '官網基本內容', 'subtitle' => '前端管理'])

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form method="POST" action="{{ route('landing.settings.update') }}">
                            @csrf

                            <h5 class="mb-3">SEO / Meta</h5>
                            <div class="mb-3">
                                <label class="form-label">頁面標題</label>
                                <input type="text" class="form-control" name="meta_title" value="{{ old('meta_title', $settings['meta_title'] ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Meta Description</label>
                                <textarea class="form-control" name="meta_description" rows="2">{{ old('meta_description', $settings['meta_description'] ?? '') }}</textarea>
                            </div>

                            <hr>
                            <h5 class="mb-3">Hero 主視覺</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Eyebrow</label>
                                    <input type="text" class="form-control" name="hero_eyebrow" value="{{ old('hero_eyebrow', $settings['hero_eyebrow'] ?? '') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tagline</label>
                                    <input type="text" class="form-control" name="hero_tagline" value="{{ old('hero_tagline', $settings['hero_tagline'] ?? '') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">主標題（換行用 Enter）</label>
                                <textarea class="form-control" name="hero_title" rows="2">{{ old('hero_title', $settings['hero_title'] ?? '') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">說明文字</label>
                                <textarea class="form-control" name="hero_lead" rows="3">{{ old('hero_lead', $settings['hero_lead'] ?? '') }}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">主按鈕文字</label>
                                    <input type="text" class="form-control" name="hero_btn_primary" value="{{ old('hero_btn_primary', $settings['hero_btn_primary'] ?? '') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">次按鈕文字</label>
                                    <input type="text" class="form-control" name="hero_btn_secondary" value="{{ old('hero_btn_secondary', $settings['hero_btn_secondary'] ?? '') }}">
                                </div>
                            </div>

                            @foreach ([
                                'services' => '服務架構',
                                'workflow' => '補助流程',
                                'themes' => '補助主題',
                                'scenarios' => '服務場景',
                                'cases' => '產業案例 Brand Wall',
                                'academic' => '國際資源',
                                'why' => '為什麼選擇錚典',
                            ] as $prefix => $label)
                                <hr>
                                <h5 class="mb-3">{{ $label }}</h5>
                                <div class="mb-3">
                                    <label class="form-label">Eyebrow</label>
                                    <input type="text" class="form-control" name="{{ $prefix }}_eyebrow" value="{{ old($prefix . '_eyebrow', $settings[$prefix . '_eyebrow'] ?? '') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">標題</label>
                                    <input type="text" class="form-control" name="{{ $prefix }}_title" value="{{ old($prefix . '_title', $settings[$prefix . '_title'] ?? '') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">副標</label>
                                    <textarea class="form-control" name="{{ $prefix }}_subtitle" rows="2">{{ old($prefix . '_subtitle', $settings[$prefix . '_subtitle'] ?? '') }}</textarea>
                                </div>
                                @if ($prefix === 'workflow')
                                    <div class="mb-3">
                                        <label class="form-label">流程底部說明</label>
                                        <input type="text" class="form-control" name="workflow_footer" value="{{ old('workflow_footer', $settings['workflow_footer'] ?? '') }}">
                                    </div>
                                @endif
                                @if ($prefix === 'cases')
                                    <div class="mb-3">
                                        <label class="form-label">免責聲明</label>
                                        <textarea class="form-control" name="cases_disclaimer" rows="2">{{ old('cases_disclaimer', $settings['cases_disclaimer'] ?? '') }}</textarea>
                                    </div>
                                @endif
                                @if ($prefix === 'academic')
                                    <div class="mb-3">
                                        <label class="form-label">底部備註</label>
                                        <textarea class="form-control" name="academic_note" rows="2">{{ old('academic_note', $settings['academic_note'] ?? '') }}</textarea>
                                    </div>
                                @endif
                            @endforeach

                            <hr>
                            <h5 class="mb-3">聯絡 / CTA</h5>
                            <div class="mb-3">
                                <label class="form-label">CTA 標題（換行用 Enter）</label>
                                <textarea class="form-control" name="cta_title" rows="2">{{ old('cta_title', $settings['cta_title'] ?? '') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">CTA 說明</label>
                                <textarea class="form-control" name="cta_text" rows="3">{{ old('cta_text', $settings['cta_text'] ?? '') }}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">服務窗口</label>
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
                            <div class="mb-3">
                                <label class="form-label">Footer 簡介</label>
                                <textarea class="form-control" name="footer_desc" rows="3">{{ old('footer_desc', $settings['footer_desc'] ?? '') }}</textarea>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success m-1"><i class="fe-check-circle me-1"></i>儲存</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
