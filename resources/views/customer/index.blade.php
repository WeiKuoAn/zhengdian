@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', ['title' => '客戶管理', 'subtitle' => '客戶列表'])
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-between">
                            <div class="col-md-10">
                                <form class="d-flex flex-wrap align-items-center" action="{{ route('customers') }}"
                                    method="GET">
                                    @csrf
                                    <label for="inputPassword2" class="visually-hidden">Search</label>
                                    <div class="me-3">
                                        <input type="search" class="form-control my-1 my-md-0" id="inputPassword2"
                                            placeholder="客戶名稱..." name="name" value="{{ $request->name }}">
                                    </div>
                                    <label for="status-select" class="me-2">專案狀態</label>
                                    <div class="me-sm-3">
                                        <select class="form-select my-1 my-md-0" id="status-select" name="contract_status"
                                            onchange="this.form.submit()">
                                            <option value="null" selected>不限</option>
                                            @foreach ($contract_status as $contract_statu)
                                                <option value="{{ $contract_statu->id }}"
                                                    @if ($request->contract_status == $contract_statu->id) selected @endif>
                                                    {{ $contract_statu->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label for="status-select" class="me-2">帳號狀態</label>
                                    <div class="me-sm-3">
                                        <select class="form-select" name="status" onchange="this.form.submit()">
                                            <option value="0" @if (!isset($request->status) && $request->status == '0') selected @endif>開通
                                            </option>
                                            <option value="1" @if ($request->status == '1') selected @endif>關閉
                                            </option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-success waves-effect waves-light me-1">搜尋</button>
                                </form>
                            </div>
                            <div class="col-md-2">
                                <div class="text-md-end mt-3 mt-md-0">
                                    <a href="{{ route('customer.create') }}">
                                        <button type="button" class="btn btn-danger waves-effect waves-light"><i
                                                class="mdi mdi-plus-circle me-1"></i> 新增客戶</button>
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
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">客戶名稱</th>
                                        <th scope="col">負責人</th>
                                        <th scope="col">統編</th>
                                        <th scope="col">主要聯絡人</th>
                                        <th scope="col">專案狀態</th>
                                        <th scope="col">權限</th>
                                        <th scope="col" style="width: 200px;">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $key => $data)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <a href="#" class="text-body">{{ $data->name }}</a>
                                            </td>
                                            <td>{{ $data->principal_name }}</td>
                                            <td>{{ $data->registration_no }}</td>
                                            <td>{{ $data->contact_name . ' / ' . $data->contact_job }}</td>
                                            <td>
                                                @if (isset($check_status[$data->contract_status]))
                                                    {{ $check_status[$data->contract_status] }}
                                                @else
                                                    {{ $data->contract_status }}
                                                @endif
                                            </td>
                                            <td>
                                                {{-- {{ dd($data) }} --}}
                                                @if ($data->status == 0)
                                                    開通
                                                @elseif($data->status == 1)
                                                    <span class="text-danger"><b>關閉</b></span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group dropdown">
                                                    <a href="javascript: void(0);"
                                                        class="table-action-btn dropdown-toggle arrow-none btn btn-outline-secondary waves-effect"
                                                        data-bs-toggle="dropdown" aria-expanded="false">動作 <i
                                                            class="mdi mdi-arrow-down-drop-circle"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item"
                                                            href="{{ route('customer.edit', $data->user_id) }}"><i
                                                                class="mdi mdi-pencil me-2 text-muted font-18 vertical-middle"></i>編輯客戶帳戶資料</a>
                                                        {{-- <a class="dropdown-item" href="#"><i class="mdi mdi-delete me-2 text-muted font-18 vertical-middle"></i>刪除</a> --}}
                                                        <a class="dropdown-item" href="#"><i
                                                                class="mdi mdi-clipboard-text-search me-2 font-18 text-muted vertical-middle"></i>編輯客戶基本資料</a>
                                                        <a class="dropdown-item" href="#"><i
                                                                class="mdi mdi-clipboard-text-search me-2 font-18 text-muted vertical-middle"></i>查看專案資料</a>
                                                    </div>
                                                </div>
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
