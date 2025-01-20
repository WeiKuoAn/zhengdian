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
                        <div class="row mb-2">
                            <div class="col-sm-4">
                                <a href="{{ route('task.create') }}">
                                    <button type="button" class="btn btn-danger waves-effect waves-light"><i
                                            class="mdi mdi-plus-circle me-1"></i> 新增派工</button>
                                </a>
                            </div>
                            <div class="col-sm-8">
                            </div><!-- end col-->
                        </div>

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
                                        <th scope="col">預計完成時間</th>
                                        {{-- <th scope="col">派工主管</th> --}}
                                        <th scope="col">操作</th>
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
                                                        - {{ $item->context }}(已完成)</span><br>
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
                                                    <button type="button" class="btn btn-light"
                                                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        title="魏國安(已完成)、
                                                        黃茹椿(待確認)">
                                                        進行中
                                                    </button>
                                                </div>
                                            </td>
                                            <td>{{ substr($data->estimated_end, 0, 11) }}</td>
                                            {{-- <td>{{ $data->user_data->name }}</td> --}}
                                            <td>
                                                <a href="{{ route('task.edit', $data->id) }}" class="action-icon">
                                                    <i class="mdi mdi-square-edit-outline"></i></a>
                                                <a href="{{ route('task.del', $data->id) }}" class="action-icon"> <i
                                                        class="mdi mdi-trash-can-outline"></i></a>
                                            </td>
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
