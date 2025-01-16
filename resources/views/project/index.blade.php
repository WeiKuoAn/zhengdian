@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', ['title' => '專案管理', 'subtitle' => '專案列表'])
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-between">
                            <div class="col-md-10">
                                <form class="d-flex flex-wrap align-items-center" action="{{ route('projects') }}" method="GET">
                                    @csrf
                                    <label for="inputPassword2" class="visually-hidden">Search</label>
                                    <div class="me-3">
                                        <input type="search" class="form-control my-1 my-md-0" id="inputPassword2"
                                            placeholder="客戶名稱..." name="cust_name" value="{{ $request->cust_name }}">
                                    </div>
                                    <label for="inputPassword2" class="visually-hidden">Search</label>
                                    <div class="me-3">
                                        <input type="search" class="form-control my-1 my-md-0" id="inputPassword2"
                                            placeholder="專案名稱..." name="project_name" value="{{ $request->project_name }}">
                                    </div>
                                    <label for="status-select" class="me-2">專案狀態</label>
                                    <div class="me-sm-3">
                                        <select class="form-select my-1 my-md-0" id="status-select" name="check_status" onchange="this.form.submit()">
                                            <option value="null" selected>不限</option>
                                            @foreach($check_statuss as $check_status)
                                                <option value="{{ $check_status->id }}" @if($request->check_status == $check_status->id) selected @endif>{{ $check_status->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-success waves-effect waves-light me-1">搜尋</button>
                                </form>
                            </div>
                            <div class="col-md-2">
                                <div class="text-md-end mt-3 mt-md-0">
                                    <a href="{{ route('project.create') }}">
                                        <button type="button" class="btn btn-danger waves-effect waves-light"><i
                                                class="mdi mdi-plus-circle me-1"></i> 新增專案</button>
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
                                        <th scope="col">申請年度</th>
                                        <th scope="col">客戶名稱</th>
                                        <th scope="col">專案名稱</th>
                                        {{-- <th scope="col">主要聯絡人</th>
                                        <th scope="col">聯絡人職稱</th>
                                        <th scope="col">聯絡人電話</th> --}}
                                        <th scope="col">狀態</th>
                                        <th scope="col" style="width: 200px;">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $key => $data)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $data->year }}年</td>
                                            <td>
                                                {{ $data->user_data->name }}
                                            </td>
                                            {{-- <td>
                                                @if ($data->type == 0)
                                                    商業服務業
                                                @endif
                                                @if ($data->type == 1)
                                                    製造業
                                                @endif
                                            </td> --}}
                                            <td>
                                                {{$data->name}}
                                            </td>
                                            {{-- <td>
                                                @if (isset($data->project_host))
                                                    {{ $data->project_host->name }}
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($data->project_host))
                                                    {{ $data->project_host->job }}
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($data->project_host))
                                                    {{ $data->project_host->mobile }}
                                                @endif
                                            </td> --}}
                                            {{-- <td>{{ $data->cust_data->county . $data->cust_data->district . $data->cust_data->address }} --}}
                                            <td align="center">
                                                @if(isset($data->check_data))
                                                {{$data->check_data->name}}
                                                @endif
                                            </td>
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
