@extends('layouts.vertical', ['title' => 'CRM Customers'])

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
                            <table class="table table-centered table-nowrap table-striped" id="products-datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">專案/任務名稱</th>
                                        <th scope="col">派工類別</th>
                                        <th scope="col">執行階段</th>
                                        <th scope="col">優先序</th>
                                        <th scope="col">負責執行人員</th>
                                        <th scope="col">狀態</th>
                                        <th scope="col">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $key => $data)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $data->name }}</td>
                                            <td>{{ $data->task_template_data->name }}</td>
                                            <td>{{ $data->check_status_data->name }}</td>
                                            <td>
                                                @if ($data->priority == 1)
                                                    <span class="badge bg-primary p-1">高</span>
                                                @elseif($data->priority == 2)
                                                    <span class="badge bg-warning p-1">中</span>
                                                @else
                                                    <span class="badge bg-success p-1">低</span>
                                                @endif
                                            </td>
                                            <td>
                                                @foreach ($data->task_user as $task_user)
                                                    <span
                                                        class="badge bg-primary p-1 mb-1">{{ $task_user->user_data->name }} - {{ $task_user->context }}</span><br>
                                                @endforeach
                                            </td>
                                            <td>
                                                @if ($data->status == 0)
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
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('contractStatus.edit', $data->id) }}" class="action-icon">
                                                    <i class="mdi mdi-square-edit-outline"></i></a>
                                                {{-- <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a> --}}
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
