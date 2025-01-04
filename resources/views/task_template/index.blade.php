@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', ['title' => '派工類別設定', 'subtitle' => '設定管理'])

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-4">
                                <a href="{{ route('TaskTemplate.create') }}">
                                    <button type="button" class="btn btn-danger waves-effect waves-light"><i
                                            class="mdi mdi-plus-circle me-1"></i> 新增計畫狀態類別</button>
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
                                        <th scope="col">名稱</th>
                                        <th scope="col">父項目</th>
                                        <th scope="col">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $key => $data)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $data->name }}</td>
                                            <td>
                                                @if(isset($data->task_template_data))
                                                {{ $data->task_template_data->name }}
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('TaskTemplate.edit', $data->id) }}" class="action-icon"> <i
                                                        class="mdi mdi-square-edit-outline"></i></a>
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
