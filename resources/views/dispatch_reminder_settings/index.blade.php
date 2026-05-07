@extends('layouts.vertical', ['title' => '派工提醒設定'])

@section('content')
    <div class="container-fluid">
        @include('layouts.shared.page-title', ['title' => '派工提醒設定', 'subtitle' => '設定管理'])

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form method="POST" action="{{ route('dispatch-reminder-settings.update') }}">
                            @csrf
                            <div class="row g-3">
                                <div class="col-12 col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">最早提醒時間</label>
                                        <input type="time" name="window_start" class="form-control"
                                            value="{{ old('window_start', substr((string) $setting->window_start, 0, 5)) }}" required>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">最晚提醒時間</label>
                                        <input type="time" name="window_end" class="form-control"
                                            value="{{ old('window_end', substr((string) $setting->window_end, 0, 5)) }}" required>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">遲交提醒截止時間</label>
                                        <input type="time" name="overdue_cutoff_time" class="form-control"
                                            value="{{ old('overdue_cutoff_time', substr((string) $setting->overdue_cutoff_time, 0, 5)) }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-12 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">未接收提醒間隔（分鐘）</label>
                                        <input type="number" min="1" max="1440" name="accept_interval_minutes"
                                            class="form-control"
                                            value="{{ old('accept_interval_minutes', $setting->accept_interval_minutes) }}" required>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">交件前幾分鐘提醒</label>
                                        <input type="number" min="1" max="1440" name="due_before_minutes"
                                            class="form-control"
                                            value="{{ old('due_before_minutes', $setting->due_before_minutes) }}" required>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">遲交提醒間隔（分鐘）</label>
                                        <input type="number" min="1" max="1440" name="overdue_interval_minutes"
                                            class="form-control"
                                            value="{{ old('overdue_interval_minutes', $setting->overdue_interval_minutes) }}" required>
                                    </div>
                                </div>
                            </div>
                            <p class="text-muted mb-0">排程固定每分鐘檢查一次，並依上述分鐘數決定是否發送提醒。</p>

                            <hr>
                            <h5 class="mb-3">提醒訊息模板（可手動調整）</h5>
                            <p class="text-muted mb-2">可用變數：<code>{mentions}</code> <code>{project_name}</code> <code>{task_name}</code> <code>{task_url}</code> <code>{due_time}</code> <code>{cutoff_time}</code></p>
                            <div class="mb-3">
                                <label class="form-label">1) 派工接收提醒模板</label>
                                <textarea name="accept_template" class="form-control" rows="5">{{ old('accept_template', (string) $setting->accept_template) }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">2) 繳交提醒模板</label>
                                <textarea name="due_template" class="form-control" rows="5">{{ old('due_template', (string) $setting->due_template) }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">3) 遲交提醒模板</label>
                                <textarea name="overdue_template" class="form-control" rows="5">{{ old('overdue_template', (string) $setting->overdue_template) }}</textarea>
                            </div>

                            <button class="btn btn-primary" type="submit">儲存設定</button>
                        </form>

                        <form method="POST" action="{{ route('dispatch-reminder-settings.test') }}" class="mt-3">
                            @csrf
                            <button class="btn btn-warning" type="submit">發送測試訊息（Synology Chat ID=40）</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

