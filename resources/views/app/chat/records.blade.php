@extends('layouts.vertical', ['title' => 'Webhook 記錄'])

@section('css')
    <style>
        .webhook-filter-card .form-label {
            font-size: 13px;
            margin-bottom: 6px;
        }

        .webhook-filter-card .webhook-filter-field {
            min-width: 140px;
            flex: 1 1 140px;
        }

        .webhook-filter-card .webhook-filter-actions {
            flex: 0 0 auto;
        }

        .webhook-records-details {
            padding-left: 0;
        }

        .webhook-records-details > summary {
            cursor: pointer;
            list-style-position: inside;
        }

        .webhook-message-content {
            white-space: pre-wrap;
            word-break: break-word;
            font-size: 14px;
            line-height: 1.6;
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            margin-left: 0;
            padding: 10px 12px;
        }

        .webhook-payload-content {
            white-space: pre-wrap;
            word-break: break-word;
            font-size: 12px;
            line-height: 1.5;
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            margin-left: 0;
            padding: 10px 12px;
            max-height: 320px;
            overflow: auto;
        }

        .webhook-records-pagination {
            margin-bottom: 0;
        }

        .webhook-records-pagination .pagination {
            margin-bottom: 0;
        }

        .webhook-records-pagination .page-link {
            border-radius: 6px;
            margin: 0 2px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        @include('layouts.shared.page-title', ['title' => 'Webhook 記錄', 'subtitle' => 'Webhook 管理'])

        <div class="row">
            <div class="col-12">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form id="webhook-records-filter" method="GET" action="{{ route('app.webhook.records') }}"
                            class="mb-3 webhook-filter-card d-flex flex-wrap align-items-end gap-2">
                            <div class="webhook-filter-field">
                                <label class="form-label">開始日期</label>
                                <input type="date" class="form-control webhook-filter-auto" name="date_from"
                                    value="{{ request('date_from') }}">
                            </div>
                            <div class="webhook-filter-field">
                                <label class="form-label">結束日期</label>
                                <input type="date" class="form-control webhook-filter-auto" name="date_to"
                                    value="{{ request('date_to') }}">
                            </div>
                            <div class="webhook-filter-field">
                                <label class="form-label">發送給誰</label>
                                <select class="form-control webhook-filter-auto" name="synology_user_id">
                                    <option value="">全部使用者</option>
                                    @foreach ($recipientUsers as $user)
                                        <option value="{{ $user->synology_user_id }}"
                                            @selected((string) request('synology_user_id') === (string) $user->synology_user_id)>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="webhook-filter-field">
                                <label class="form-label">類型</label>
                                <select class="form-control webhook-filter-auto" name="event_type">
                                    @foreach (\App\Models\ChatWebhookEvent::filterEventTypeOptions() as $value => $label)
                                        <option value="{{ $value }}" @selected(request('event_type') === (string) $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="webhook-filter-field">
                                <label class="form-label">狀態</label>
                                <select class="form-control webhook-filter-auto" name="status">
                                    @foreach (\App\Models\ChatWebhookEvent::filterStatusOptions() as $value => $label)
                                        <option value="{{ $value }}" @selected(request('status') === (string) $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="webhook-filter-actions d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="mdi mdi-magnify me-1"></i>篩選
                                </button>
                                <a href="{{ route('app.webhook.records') }}" class="btn btn-secondary">
                                    <i class="mdi mdi-refresh me-1"></i>重置
                                </a>
                            </div>
                        </form>

                        <div class="mb-2 text-muted">共 {{ $events->total() }} 筆資料</div>

                        <div class="table-responsive">
                            <table class="table table-striped table-centered">
                                <thead>
                                    <tr>
                                        <th>時間</th>
                                        <th>類型</th>
                                        <th>指令</th>
                                        <th>發送給誰</th>
                                        <th>狀態</th>
                                        <th>
                                            Webhook 驗證
                                            <i class="mdi mdi-information-outline text-muted"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="表示此筆請求是否通過 Webhook 安全驗證（Token／簽章／IP）。系統自動提醒一律為已驗證。"></i>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($events as $event)
                                        <tr>
                                            <td>{{ $event->created_at }}</td>
                                            <td>{{ \App\Models\ChatWebhookEvent::eventTypeLabel($event->event_type) }}</td>
                                            <td><code>{{ $event->command ?? '-' }}</code></td>
                                            <td class="small">
                                                {{ $event->formatRecipientsLabel($usersBySynologyId ?? collect()) }}
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ \App\Models\ChatWebhookEvent::statusBadgeClass($event->status) }}">
                                                    {{ \App\Models\ChatWebhookEvent::statusLabel($event->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $event->verified ? 'success' : 'danger' }}">
                                                    {{ \App\Models\ChatWebhookEvent::verifiedLabel((bool) $event->verified) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="bg-light">
                                                <details class="webhook-records-details">
                                                    <summary>查看訊息內容</summary>
                                                    <div class="webhook-message-content mt-2">{{ $event->displayMessageContent() }}</div>
                                                </details>
                                                @if ($event->error_message)
                                                    <div class="text-danger mt-2">發送失敗：{{ $event->error_message }}</div>
                                                    @if ($event->synologyErrorSummary())
                                                        <div class="text-danger small mt-1">
                                                            Synology：{{ $event->synologyErrorSummary() }}
                                                        </div>
                                                    @endif
                                                    @if ($event->shouldShowFailurePayload())
                                                        <details class="webhook-records-details mt-2">
                                                            <summary>查看 payload</summary>
                                                            <pre class="webhook-payload-content mt-2 mb-0"><code>{{ $event->displayFailurePayloadJson() }}</code></pre>
                                                        </details>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">尚無 webhook 記錄</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3 d-flex flex-wrap justify-content-between align-items-center gap-2 webhook-records-pagination">
                            <div class="text-muted small">
                                顯示第 {{ $events->firstItem() ?? 0 }} 到 {{ $events->lastItem() ?? 0 }} 筆，共 {{ $events->total() }} 筆
                            </div>
                            <nav aria-label="Webhook 記錄分頁">
                                {{ $events->links('pagination::custom-bootstrap-5') }}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function(el) {
                new bootstrap.Tooltip(el);
            });

            const filterForm = document.getElementById('webhook-records-filter');
            if (filterForm) {
                filterForm.querySelectorAll('.webhook-filter-auto').forEach(function(el) {
                    el.addEventListener('change', function() {
                        filterForm.submit();
                    });
                });
            }
        });
    </script>
@endsection
