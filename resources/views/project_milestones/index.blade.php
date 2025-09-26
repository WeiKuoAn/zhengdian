@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', ['title' => '排程列表', 'subtitle' => '排程管理'])

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <!-- 篩選表單 -->
                        <form method="GET" action="{{ route('projectMilestones') }}" class="mb-3">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">客戶名稱</label>
                                    <input type="text" class="form-control" name="customer_name" value="{{ request('customer_name') }}" placeholder="請輸入客戶名稱">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">日期欄位</label>
                                    <select class="form-control" name="date_field" data-toggle="select" data-width="100%">
                                        <option value="order_date" @if(request('date_field') == 'order_date') selected @endif>表訂時間</option>
                                        <option value="milestone_date" @if(request('date_field') == 'milestone_date') selected @endif>預計完成時間</option>
                                        <option value="formal_date" @if(request('date_field') == 'formal_date') selected @endif>實際完成時間</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">開始日期</label>
                                    <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">結束日期</label>
                                    <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light">
                                            <i class="mdi mdi-magnify me-1"></i> 篩選
                                        </button>
                                        <a href="{{ route('projectMilestones') }}" class="btn btn-secondary waves-effect waves-light">
                                            <i class="mdi mdi-refresh me-1"></i> 重置
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="row mb-2">
                            <div class="col-sm-4">
                                <a href="{{ route('projectMilestones.create') }}">
                                    <button type="button" class="btn btn-danger waves-effect waves-light"><i
                                            class="mdi mdi-plus-circle me-1"></i> 新增排程</button>
                                </a>
                            </div>
                            <div class="col-sm-8">
                                <div class="text-end">
                                    <span class="text-muted">共 {{ $datas->total() }} 筆資料</span>
                                </div>
                            </div><!-- end col-->
                        </div>

                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap table-striped" id="products-datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">客戶名稱</th>
                                        <th scope="col">專案派工</th>
                                        <th scope="col">表訂時間</th>
                                        <th scope="col">預計完成時間</th>
                                        <th scope="col">實際完成時間</th>
                                        <th scope="col">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($datas as $key => $data)
                                        <tr>
                                            <td>{{ $datas->firstItem() + $key }}</td>
                                            <td>@if(isset($data->project_data->user_data)){{ $data->project_data->user_data->name }}@endif</td>
                                            <td>@if(isset($data->task_data)){{ $data->task_data->name }}@endif</td>
                                            <td>{{ $data->order_date ? \Carbon\Carbon::parse($data->order_date)->format('Y-m-d') : '' }}</td>
                                            <td>{{ $data->milestone_date ? \Carbon\Carbon::parse($data->milestone_date)->format('Y-m-d') : '' }}</td>
                                            <td>{{ $data->formal_date ? \Carbon\Carbon::parse($data->formal_date)->format('Y-m-d') : '' }}</td>
                                            <td>
                                                <a href="{{ route('projectMilestones.edit', $data->id) }}" class="action-icon">
                                                    <i class="mdi mdi-square-edit-outline"></i></a>
                                                {{-- <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a> --}}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">沒有找到符合條件的資料</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- 分頁 -->
                        <div class="row mt-3">
                            <div class="col-sm-12 col-md-6">
                                <div class="text-muted">
                                    顯示第 {{ $datas->firstItem() }} 到 {{ $datas->lastItem() }} 筆，共 {{ $datas->total() }} 筆資料
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="text-end">
                                    {{ $datas->appends(request()->query())->links() }}
                                </div>
                            </div>
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->

    </div> <!-- container -->
@endsection
