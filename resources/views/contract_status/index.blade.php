@extends('layouts.vertical', ['title' => '專案狀態設定'])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', ['title' => '專案狀態設定', 'subtitle' => '設定管理'])

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-4">
                                <a href="{{ route('contractStatus.create') }}">
                                    <button type="button" class="btn btn-danger waves-effect waves-light"><i
                                            class="mdi mdi-plus-circle me-1"></i> 新增專案狀態</button>
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
                                        <th scope="col">專案狀態名稱</th>
                                        <th scope="col">排序</th>
                                        <th scope="col">狀態</th>
                                        <th scope="col">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $key => $data)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $data->name }}</td>
                                            <td>{{ $data->seq }}</td>
                                            <td>
                                                @if ($data->status == 'up')
                                                    啟用
                                                @else
                                                    <b style="color:red;">停用</b>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('contractStatus.edit', $data->id) }}" class="action-icon"> <i
                                                        class="mdi mdi-square-edit-outline"></i></a>
                                                <a href="{{ route('contractStatus.del', $data->id) }}" class="action-icon"> <i class="mdi mdi-trash-can-outline"></i></a>
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
