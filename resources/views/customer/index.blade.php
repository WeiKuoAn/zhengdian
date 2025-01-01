@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', ['title' => '客戶管理', 'subtitle' => '客戶列表'])

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-4">
                                <a href="{{ route('user.create') }}">
                                    <button type="button" class="btn btn-danger waves-effect waves-light"><i
                                            class="mdi mdi-plus-circle me-1"></i> 新增客戶</button>
                                </a>
                            </div>
                            <div class="col-sm-8">
                                {{-- <div class="text-sm-end mt-2 mt-sm-0">
                                    <button type="button" class="btn btn-success mb-2 me-1"><i
                                            class="mdi mdi-cog"></i></button>
                                    <button type="button" class="btn btn-light mb-2 me-1">Import</button>
                                    <button type="button" class="btn btn-light mb-2">Export</button>
                                </div> --}}
                            </div><!-- end col-->
                        </div>

                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap table-striped" id="products-datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">客戶名稱</th>
                                        <th scope="col">負責人</th>
                                        <th scope="col">統編</th>
                                        <th scope="col">商業服務業</th>
                                        <th scope="col">製造業</th>
                                        <th scope="col">主要聯絡人</th>
                                        <th scope="col">聯絡人職稱</th>
                                        <th scope="col">聯絡人電話</th>
                                        <th scope="col">nas連結</th>
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
                                            <td align="center">
                                                @if (!empty($types) && $types[$data->user_id]['type'] == 0)
                                                    <i class="mdi mdi-check" style="color: red;"></i>
                                                @endif
                                            </td>
                                            <td align="center">
                                                @if (!empty($types) && $types[$data->user_id]['type'] == 1)
                                                    <i class="mdi mdi-check" style="color: red;"></i>
                                                @endif
                                            </td>
                                            <td>{{ $data->contact_name }}</td>
                                            <td>{{ $data->contact_job }}</td>
                                            <td>{{ $data->contact_phone }}</td>
                                            {{-- <td>{{ $data->contact_email  }}</td> --}}
                                            {{-- <td>{{ $data->county.$data->district.$data->address  }}</td> --}}
                                            <td>
                                                <a href="{{ $data->nas_link }}" target="_blank">
                                                    <button type="button"
                                                        class="btn btn-sm btn-link text-dark text-decoration-none font-size-20">
                                                        <i class="bx bx-link"></i>連結</button>
                                                </a>
                                            </td>
                                            <td>
                                                {{-- {{ dd($data) }} --}}
                                                @if ($data->status == 0)
                                                    啟動
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
                                                        <a class="dropdown-item" href="#"><i
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
