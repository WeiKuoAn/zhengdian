@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', ['title' => '會議管理', 'subtitle' => '會議列表'])
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-between">
                            <div class="col-md-10">
                                <form class="d-flex flex-wrap align-items-center" action="{{ route('meetDatas') }}" method="GET">
                                    @csrf
                                    <label for="inputPassword2" class="visually-hidden">Search</label>
                                    <div class="me-3">
                                        <input type="search" class="form-control my-1 my-md-0" id="inputPassword2"
                                            placeholder="客戶名稱..." name="name" value="{{ $request->name }}">
                                    </div>
                                    <label for="inputPassword2" class="visually-hidden">Search</label>
                                    <div class="me-3">
                                        <input type="search" class="form-control my-1 my-md-0" id="inputPassword2"
                                            placeholder="會議名稱..." name="name" value="{{ $request->name }}">
                                    </div>
                                    <button type="submit" class="btn btn-success waves-effect waves-light me-1">搜尋</button>
                                </form>
                            </div>
                            <div class="col-md-2">
                                <div class="text-md-end mt-3 mt-md-0">
                                    <a href="{{ route('meetData.create') }}">
                                        <button type="button" class="btn btn-danger waves-effect waves-light"><i
                                                class="mdi mdi-plus-circle me-1"></i> 新增會議</button>
                                    </a>
                                </div>
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
                            <table class="table table-centered table-nowrap table-striped" id="products-datatable">
                                <thead>
                                    <tr align="center">
                                        <th scope="col">No</th>
                                        <th scope="col">客戶名稱</th>
                                        <th scope="col">會議時間</th>
                                        <th scope="col">會議名稱</th>
                                        <th scope="col">狀態</th>
                                        <th scope="col" style="width: 200px;">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $key => $data)
                                        <tr align="center">
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $data->user_data->name}}</td>
                                            <td>{{ $data->date }}</td>
                                            <td>{{ $data->name }}</td>
                                            <td align="center"></td>
                                            <td align="center">
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item dropdown">
                                                        <a class="table-action-btn dropdown-toggle arrow-none btn btn-outline-dark waves-effect"
                                                            href="#" role="button" data-bs-toggle="dropdown"
                                                            aria-haspopup="true">動作
                                                            <i class="bx bxs-down-arrow"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item"
                                                                    href="{{ route('project.edit', $data->user_id) }}" >編輯</a>
                                                            {{-- <a class="dropdown-item"
                                                                @if ($data->type == 0) href="{{ route('user.project.business.appendix', $data->user_id) }}"
                                                        @elseif($data->type == 1)
                                                            href="{{ route('user.project.Manufacturing.appendix', $data->user_id) }}" @endif>附件</a>
                                                            <a class="dropdown-item"
                                                                @if ($data->type == 0) href="{{ route('user.project.business.preview', $data->user_id) }}"
                                                        @elseif($data->type == 1)
                                                            href="{{ route('user.project.Manufacturing.preview', $data->user_id) }}" @endif>預覽</a>
                                                            <a class="dropdown-item"
                                                                @if ($data->type == 0) href="{{ route('business-export-word', $data->user_id) }}"
                                                            @elseif($data->type == 1)
                                                                href="{{ route('user.project.Manufacturing.preview', $data->user_id) }}" @endif>填寫計畫內容</a> --}}
                                                        </div>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $datas->links('vendor.pagination.bootstrap-5') }}
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->

    </div> <!-- container -->
@endsection
