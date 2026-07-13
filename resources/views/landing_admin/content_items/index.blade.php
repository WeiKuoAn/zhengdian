@extends('layouts.vertical', ['title' => '區塊內容'])

@section('content')
    <div class="container-fluid">
        @include('layouts.shared.page-title', ['title' => '區塊內容', 'subtitle' => '前端管理'])

        @include('landing_admin.partials.preview_bar')

        <div class="row mb-3">
            <div class="col-12">
                <div class="alert alert-light border mb-0">
                    <strong>目前編輯：{{ $typeLabels[$type] ?? '' }}</strong>
                    <span class="text-muted ms-2">{{ \App\Models\LandingContentItem::typeHints()[$type] ?? '' }}</span>
                    <div class="small text-muted mt-1">區塊的「標題與說明」請到 <a href="{{ route('landing.settings') }}">文案與聯絡</a> 修改。</div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                @include('landing_admin.partials.content_type_tabs')
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12 d-flex flex-wrap gap-2 align-items-center">
                <a href="{{ route('landing.content-items.create', ['type' => $type]) }}" class="btn btn-danger btn-sm">
                    <i class="mdi mdi-plus-circle me-1"></i>新增一筆
                </a>
                <a href="{{ route('landing.dashboard') }}" class="btn btn-light btn-sm border">回官網總覽</a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-centered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>主標題 / 數字</th>
                                        <th>副標 / 圖示</th>
                                        <th>內容</th>
                                        <th>排序</th>
                                        <th>狀態</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($datas as $key => $data)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $data->title }}</td>
                                            <td>{{ $data->subtitle ?: $data->icon }}{{ $data->extra ? ' / ' . $data->extra : '' }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit($data->body, 40) }}</td>
                                            <td>{{ $data->seq }}</td>
                                            <td>
                                                <span class="badge {{ $data->status === 'up' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                                                    {{ $data->status === 'up' ? '顯示中' : '已隱藏' }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('landing.content-items.edit', $data->id) }}" class="action-icon" title="編輯"><i class="mdi mdi-square-edit-outline"></i></a>
                                                @if (in_array((int) (Auth::user()->level ?? 2), [0, 1], true))
                                                    <a href="{{ route('landing.content-items.del', $data->id) }}" class="action-icon" title="刪除"><i class="mdi mdi-trash-can-outline"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-4">
                                                尚無資料，請按上方「新增一筆」
                                            </td>
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
