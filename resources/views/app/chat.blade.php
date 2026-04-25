@extends('layouts.vertical', ['title' => 'Chat Webhook'])

@section('content')
    <div class="container-fluid">
        @include('layouts.shared.page-title', ['title' => 'Chat Webhook', 'subtitle' => 'Webhook 整合模組'])

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
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">測試傳送</h5>
                        <form action="{{ route('app.chat.test') }}" method="POST">
                            @csrf
                            <div class="mb-2">
                                <label class="form-label">事件類型</label>
                                <select class="form-control" name="event_type" required>
                                    <option value="outgoing">outgoing</option>
                                    <option value="slash">slash</option>
                                    <option value="inbound">inbound</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Command（slash 可填）</label>
                                <input class="form-control" name="command" placeholder="/task done 1">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Text</label>
                                <textarea class="form-control" name="text" rows="3" placeholder="訊息內容"></textarea>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Username</label>
                                <input class="form-control" name="username" value="web-admin">
                            </div>
                            <button class="btn btn-primary w-100" type="submit">送出測試</button>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Webhook Endpoints</h5>
                        @foreach ($endpoints as $type => $url)
                            <div class="mb-3">
                                <div class="small text-muted text-uppercase">{{ $type }}</div>
                                <div class="input-group">
                                    <input class="form-control" value="{{ $url }}" readonly>
                                    <button class="btn btn-outline-secondary" type="button"
                                        onclick="navigator.clipboard.writeText('{{ $url }}')">複製</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">最近 Webhook 記錄</h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-centered">
                                <thead>
                                    <tr>
                                        <th>時間</th>
                                        <th>類型</th>
                                        <th>使用者</th>
                                        <th>指令</th>
                                        <th>狀態</th>
                                        <th>驗證</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($events as $event)
                                        <tr>
                                            <td>{{ $event->created_at }}</td>
                                            <td>{{ $event->event_type }}</td>
                                            <td>{{ $event->username ?? '-' }}</td>
                                            <td><code>{{ $event->command ?? '-' }}</code></td>
                                            <td>
                                                <span class="badge bg-{{ $event->status === 'processed' ? 'success' : ($event->status === 'failed' ? 'danger' : 'secondary') }}">
                                                    {{ $event->status }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($event->verified)
                                                    <span class="badge bg-success">verified</span>
                                                @else
                                                    <span class="badge bg-danger">no</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="bg-light">
                                                <details>
                                                    <summary>查看 payload</summary>
                                                    <pre class="mb-0 mt-2">{{ json_encode($event->payload_json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                </details>
                                                @if ($event->error_message)
                                                    <div class="text-danger mt-2">Error: {{ $event->error_message }}</div>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
