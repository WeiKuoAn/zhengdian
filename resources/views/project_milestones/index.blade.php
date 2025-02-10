@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', ['title' => '排程列表', 'subtitle' => '排程管理'])

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-4">
                                <a href="{{ route('projectMilestones.create') }}">
                                    <button type="button" class="btn btn-danger waves-effect waves-light"><i
                                            class="mdi mdi-plus-circle me-1"></i> 新增排程</button>
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
                                        <th scope="col">客戶名稱</th>
                                        <th scope="col">專案派工</th>
                                        <th scope="col">表訂時間</th>
                                        <th scope="col">預計完成時間</th>
                                        <th scope="col">實際完成時間</th>
                                        <th scope="col">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $key => $data)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>@if(isset($data->project_data->user_data)){{ $data->project_data->user_data->name }}@endif</td>
                                            <td>@if(isset($data->task_data)){{ $data->task_data->name }}@endif</td>
                                            <td>{{ $data->order_date }}</td>
                                            <td>{{ $data->milestone_date }}</td>
                                            <td>{{ $data->formal_date }}</td>
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
