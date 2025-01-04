@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', ['title' => '專案管理', 'subtitle' => '專案列表'])

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-10">
                                <form action="#" method="GET">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row align-items-center">
                                                        @csrf
                                                        <div class="col-md-2">
                                                            <label class="form-label">公司名稱</label>
                                                            <input type="text" class="form-control" name="name"
                                                                value="{{ $request->name }}">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="form-label">申請類別</label>
                                                            <select class="form-select" name="type"
                                                                onchange="this.form.submit()">
                                                                <option value="null"
                                                                    @if (!isset($request->type) && $request->type == 'null') selected @endif>不限
                                                                </option>
                                                                <option value="0"
                                                                    @if ($request->type == '0') selected @endif>商業服務業
                                                                </option>
                                                                <option value="1"
                                                                    @if ($request->type == '1') selected @endif>製造業
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="form-label">送件狀態</label>
                                                            <select class="form-select" name="check_status"
                                                                onchange="this.form.submit()">
                                                                <option value="0"
                                                                    @if (!isset($request->check_status) && $request->check_status == '0') selected @endif>
                                                                    未結案/待送件
                                                                </option>
                                                                <option value="1"
                                                                    @if ($request->check_status == '1') selected @endif>已送件
                                                                </option>
                                                                <option value="3"
                                                                    @if ($request->check_status == '3') selected @endif>未過案
                                                                </option>
                                                                <option value="9"
                                                                    @if ($request->check_status == '9') selected @endif>已結案
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="form-label">狀態</label>
                                                            <select class="form-select" name="status"
                                                                onchange="this.form.submit()">
                                                                <option value="0"
                                                                    @if (!isset($request->status) && $request->status == '0') selected @endif>開通
                                                                </option>
                                                                <option value="1"
                                                                    @if ($request->status == '1') selected @endif>關閉
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button type="submit"
                                                                class="btn btn-danger waves-effect waves-light">
                                                                <i class="mdi mdi-search-web me-1"></i>
                                                                查詢</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-2">
                                <div class="text-sm-end mt-3 mt-sm-0">
                                    <a href="{{ route('project.create') }}">
                                        <button type="button" class="btn btn-danger waves-effect waves-light"><i
                                                class="mdi mdi-plus-circle me-1"></i> 新增專案</button>
                                    </a>
                                </div>
                            </div><!-- end col-->
                        </div>

                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap table-striped" id="products-datatable">
                                <thead>
                                    <tr align="center">
                                        <th scope="col">No</th>
                                        <th scope="col">申請年度</th>
                                        <th scope="col">客戶名稱</th>
                                        <th scope="col">申請類別</th>
                                        <th scope="col">主要聯絡人</th>
                                        <th scope="col">聯絡人職稱</th>
                                        <th scope="col">聯絡人電話</th>
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
                                            <td>
                                                @if ($data->type == 0)
                                                    商業服務業
                                                @endif
                                                @if ($data->type == 1)
                                                    製造業
                                                @endif
                                            </td>
                                            <td>
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
                                            </td>
                                            <td>{{ $data->cust_data->county . $data->cust_data->district . $data->cust_data->address }}
                                            </td>
                                            <td></td>
                                            <td>
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
