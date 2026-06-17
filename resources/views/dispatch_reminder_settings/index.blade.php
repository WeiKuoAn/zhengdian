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

                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="remind_on_holidays"
                                        name="remind_on_holidays" value="1"
                                        {{ old('remind_on_holidays', $setting->remind_on_holidays ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remind_on_holidays">假日提醒</label>
                                </div>
                            </div>

                            <hr>
                            <h5 class="mb-3">Synology Chat 連線</h5>
                            <div class="mb-3">
                                <label class="form-label" for="synology_chat_host">Chat Host（NAS 網址）</label>
                                <input type="url" name="synology_chat_host" id="synology_chat_host" class="form-control"
                                    placeholder="https://zhengdian.direct.quickconnect.to:52667"
                                    value="{{ old('synology_chat_host', $setting->synology_chat_host ?? ($defaultSynologyChatHost ?? '')) }}">
                                <div class="form-text">
                                    NAS 重啟後若 QuickConnect 埠號改變，請在此更新；儲存後派工提醒、派工通知都會使用此網址。
                                    @if (!empty($defaultSynologyChatHost))
                                        若留空則使用 .env 的 <code>SYNOLOGY_CHAT_HOST</code>（目前：{{ $defaultSynologyChatHost }}）。
                                    @endif
                                </div>
                            </div>

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
                            <button class="btn btn-warning" type="submit">發送測試訊息（發送至目前登入者的 Synology Chat）</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

