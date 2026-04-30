@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('content')
    <div class="container-fluid">
        @include('layouts.shared.page-title', ['title' => '群組管理', 'subtitle' => '群組管理'])

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>群組名稱</th>
                                        <th>狀態</th>
                                        <th>建立時間</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($datas as $key => $data)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $data->name }}</td>
                                            <td>
                                                @if (in_array((string) ($data->status ?? '0'), ['up', '0', 'enabled'], true))
                                                    <span class="badge bg-success">啟用</span>
                                                @else
                                                    <span class="badge bg-danger">停用</span>
                                                @endif
                                            </td>
                                            <td>{{ optional($data->created_at)->format('Y-m-d H:i') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">目前沒有群組資料</td>
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
