@extends('layouts.vertical', ['title' => '官網產業類別'])

@section('content')
    <div class="container-fluid">
        @include('layouts.shared.page-title', ['title' => '產業類別', 'subtitle' => '前端管理'])
        <div class="row mb-3">
            <div class="col-12">
                <a href="{{ route('landing.industry-categories.create') }}" class="btn btn-danger btn-sm"><i class="mdi mdi-plus-circle me-1"></i>新增產業類別</a>
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
                                        <th>代碼</th>
                                        <th>名稱</th>
                                        <th>客戶數</th>
                                        <th>欄數</th>
                                        <th>排序</th>
                                        <th>狀態</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $key => $data)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $data->code }}</td>
                                            <td>{{ $data->name }}</td>
                                            <td>{{ $data->brand_clients_count }}</td>
                                            <td>{{ $data->grid_columns }}</td>
                                            <td>{{ $data->seq }}</td>
                                            <td>{{ $data->status === 'up' ? '啟用' : '停用' }}</td>
                                            <td>
                                                <a href="{{ route('landing.brand-clients', ['category_id' => $data->id]) }}" class="action-icon" title="管理客戶"><i class="mdi mdi-view-grid"></i></a>
                                                <a href="{{ route('landing.industry-categories.edit', $data->id) }}" class="action-icon"><i class="mdi mdi-square-edit-outline"></i></a>
                                                @if ((int) (Auth::user()->level ?? 2) !== 2)
                                                    <a href="{{ route('landing.industry-categories.del', $data->id) }}" class="action-icon"><i class="mdi mdi-trash-can-outline"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
