@extends('layouts.vertical', ['title' => '區塊項目'])

@section('content')
    <div class="container-fluid">
        @include('layouts.shared.page-title', ['title' => '區塊項目', 'subtitle' => '前端管理'])

        <div class="row mb-3">
            <div class="col-12">
                @include('landing_admin.partials.content_type_tabs')
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <a href="{{ route('landing.content-items.create', ['type' => $type]) }}" class="btn btn-danger btn-sm">
                    <i class="mdi mdi-plus-circle me-1"></i>新增{{ $typeLabels[$type] ?? '' }}
                </a>
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
                                        <th>No</th>
                                        <th>標題</th>
                                        <th>副標 / 圖示</th>
                                        <th>內容摘要</th>
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
                                            <td>{{ $data->status === 'up' ? '啟用' : '停用' }}</td>
                                            <td>
                                                <a href="{{ route('landing.content-items.edit', $data->id) }}" class="action-icon"><i class="mdi mdi-square-edit-outline"></i></a>
                                                @if ((int) (Auth::user()->level ?? 2) !== 2)
                                                    <a href="{{ route('landing.content-items.del', $data->id) }}" class="action-icon"><i class="mdi mdi-trash-can-outline"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="7" class="text-center text-muted">尚無資料</td></tr>
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
