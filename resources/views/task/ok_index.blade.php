@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('css')
    @vite('node_modules/tippy.js/dist/tippy.css')
@endsection

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', ['title' => '派工列表', 'subtitle' => '派工管理'])

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-between">
                            <div class="col-md-10">
                                <form class="d-flex flex-wrap align-items-center" action="{{ route('task.ok.index') }}"
                                    method="GET">
                                    @csrf
                                    <label for="status-select" class="me-2">預計完成時間</label>
                                    <div class="me-1">
                                        <input type="date" class="form-control" name="estimated_date_start"
                                            value="{{ $request->estimated_date_start }}">
                                    </div>
                                    <div class="me-3">
                                        <input type="date" class="form-control" name="estimated_date_end"
                                            value="{{ $request->estimated_date_end }}">
                                    </div>
                                    <label for="status-select" class="me-1">執行人員</label>
                                    <div class="me-2">
                                        <select class="form-control" data-toggle="select2" data-width="100%" name="user_id"
                                            onchange="this.form.submit()">
                                            <option value="" selected>請選擇</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}"
                                                    {{ $request->user_id == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-success waves-effect waves-light me-1">搜尋</button>
                                </form>
                            </div>
                            <div class="col-md-2">

                            </div><!-- end col-->
                        </div> <!-- end row -->
                    </div>
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-centered  table-striped" id="products-datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">專案名稱</th>
                                        <th scope="col">派工項目</th>
                                        <th scope="col">優先序</th>
                                        <th scope="col">負責執行人員</th>
                                        <th scope="col">派工進度</th>
                                        <th scope="col">完成時間</th>
                                        <th scope="col">主要派工人</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $key => $data)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td width="20%">
                                                @if (isset($data->project_data))
                                                    {{ $data->project_data->user_data->name }}{{ $data->project_data->name }}
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($data->task_template_data))
                                                    {{ $data->task_template_data->name }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($data->priority == 0)
                                                    <span class="badge bg-danger p-1">緊急</span>
                                                @elseif($data->priority == 1)
                                                    <span class="badge bg-primary p-1">高</span>
                                                @elseif($data->priority == 2)
                                                    <span class="badge bg-warning p-1">中</span>
                                                @else
                                                    <span class="badge bg-success p-1">低</span>
                                                @endif
                                            </td>
                                            <td>
                                                @foreach ($data->items as $item)
                                                    <span class="badge bg-primary p-1 mb-1">{{ $item->user_data->name }}
                                                        @if (isset($item->context))
                                                            （{{ $item->context }}）
                                                        @endif
                                                    </span><br>
                                                @endforeach
                                            </td>
                                            <td>
                                                {{-- @if ($data->status == 0)
                                                    <span class="badge bg-primary p-1">進行中</span>
                                                @elseif($data->status == 1)
                                                    <span class="badge bg-success p-1">送出派工</span>
                                                @elseif($data->status == 2)
                                                    <span class="badge bg-success p-1">接收派工</span>
                                                @elseif($data->status == 3)
                                                    <span class="badge bg-success p-1">進行中</span>
                                                @elseif($data->status == 4)
                                                    <span class="badge bg-success p-1">移轉</span>
                                                @else
                                                    <span class="badge bg-danger p-1">完成</span>
                                                @endif --}}
                                                <div class="button-list" id="tooltip-container">
                                                    <button type="button" class="btn btn-white"
                                                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        title="@foreach ($data->items as $item) {{ $item->user_data->name }}（{{ $item->status() }}）、 @endforeach">
                                                        {{ $data->status() }}
                                                    </button>
                                                </div>
                                            </td>
                                            <td>{{ $data->estimated_end }}</td>
                                            <td>{{ $data->user_data->name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->

    </div> <!-- container -->
@endsection
