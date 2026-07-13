@extends('layouts.vertical', ['title' => '官網合作客戶'])

@section('content')
    <div class="container-fluid">
        @include('layouts.shared.page-title', ['title' => '合作客戶 Logo', 'subtitle' => '前端管理'])

        <div class="row mb-3">
            <div class="col-md-8">
                <form method="GET" class="d-flex gap-2">
                    <select name="category_id" class="form-select" onchange="this.form.submit()">
                        <option value="">全部產業類別</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected((string) $categoryId === (string) $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="{{ route('landing.brand-clients.create', ['category_id' => $categoryId]) }}" class="btn btn-danger btn-sm">
                    <i class="mdi mdi-plus-circle me-1"></i>新增合作客戶
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
                        <div class="table-responsive">
                            <table class="table table-centered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Logo</th>
                                        <th>名稱</th>
                                        <th>產業類別</th>
                                        <th>排序</th>
                                        <th>狀態</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($datas as $key => $data)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                @if ($data->logoUrl())
                                                    <img src="{{ $data->logoUrl() }}" alt="{{ $data->name }}" style="height:36px;max-width:80px;object-fit:contain;">
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>{{ $data->name }}</td>
                                            <td>{{ $data->category->name ?? '—' }}</td>
                                            <td>{{ $data->seq }}</td>
                                            <td>{{ $data->status === 'up' ? '啟用' : '停用' }}</td>
                                            <td>
                                                <a href="{{ route('landing.brand-clients.edit', $data->id) }}" class="action-icon"><i class="mdi mdi-square-edit-outline"></i></a>
                                                @if ((int) (Auth::user()->level ?? 2) !== 2)
                                                    <a href="{{ route('landing.brand-clients.del', $data->id) }}" class="action-icon"><i class="mdi mdi-trash-can-outline"></i></a>
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
