@extends('layouts.vertical', ['title' => 'Webhook 端點資訊'])

@section('content')
    <div class="container-fluid">
        @include('layouts.shared.page-title', ['title' => 'Webhook 端點資訊', 'subtitle' => 'Webhook 管理'])

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
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Webhook 端點資訊</h5>
                        <p class="text-muted small">請將下列 URL 設定至 Synology Chat 或外部系統的 Webhook 設定中。</p>
                        @foreach ($endpoints as $type => $url)
                            <div class="mb-3">
                                <div class="small text-muted text-uppercase">
                                    @if ($type === 'outgoing')
                                        傳出 Webhook
                                    @elseif($type === 'slash')
                                        斜線指令
                                    @elseif($type === 'inbound')
                                        傳入 Webhook
                                    @else
                                        {{ $type }}
                                    @endif
                                </div>
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

            <div class="col-lg-7">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">測試傳送</h5>
                        <p class="text-muted small mb-3">可在此送出測試訊息，結果會寫入 <a href="{{ route('app.webhook.records') }}">Webhook 記錄</a>。</p>
                        <form action="{{ route('app.webhook.test') }}" method="POST">
                            @csrf
                            <div class="mb-2">
                                <label class="form-label">事件類型</label>
                                <select class="form-control" name="event_type" required>
                                    <option value="outgoing">傳出</option>
                                    <option value="slash">斜線指令</option>
                                    <option value="inbound">傳入</option>
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
                            <button class="btn btn-primary" type="submit">送出測試</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
