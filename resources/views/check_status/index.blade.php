@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', ['title' => '專案階段設定', 'subtitle' => '設定管理'])

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <a href="{{ route('checkStatus.create') }}">
                                    <button type="button" class="btn btn-danger waves-effect waves-light"><i
                                            class="mdi mdi-plus-circle me-1"></i> 新增專案階段</button>
                                </a>
                            </div>
                            <div class="col-sm-8">
                            </div><!-- end col-->
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap table-striped" id="products-datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">專案狀態</th>
                                        <th scope="col">專案階段</th>
                                        <th scope="col">排序</th>
                                        <th scope="col">狀態</th>
                                        <th scope="col">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $key => $data)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                @if (isset($data->check_data))
                                                    {{ $data->check_data->name }}
                                                @endif
                                            </td>
                                            <td>{{ $data->name }} </td>
                                            <td>{{ $data->seq }}</td>
                                            <td>
                                                @if ($data->status == 'up')
                                                    啟用
                                                @else
                                                    <b style="color:red;">停用</b>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('checkStatus.edit', $data->id) }}" class="action-icon"> <i
                                                        class="mdi mdi-square-edit-outline"></i></a>
                                                <a href="{{ route('checkStatus.del', $data->id) }}" class="action-icon"> <i class="mdi mdi-trash-can-outline"></i></a>
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
