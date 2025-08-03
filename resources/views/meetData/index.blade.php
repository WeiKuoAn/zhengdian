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
                                <form class="d-flex flex-wrap align-items-center" action="{{ route('meetDatas') }}"
                                    method="GET">
                                    @csrf
                                    <label for="inputPassword2" class="visually-hidden">Search</label>
                                    <div class="me-3">
                                        <input type="search" class="form-control my-1 my-md-0" id="inputPassword2"
                                            placeholder="客戶名稱..." name="cust_name" value="{{ $request->cust_name }}">
                                    </div>
                                    <label for="inputPassword2" class="visually-hidden">Search</label>
                                    <div class="me-3">
                                        <input type="search" class="form-control my-1 my-md-0" id="inputPassword2"
                                            placeholder="會議名稱..." name="meet_name" value="{{ $request->meet_name }}">
                                    </div>
                                    <div class="me-3">
                                        <select class="form-control my-1 my-md-0" name="status" onchange="this.form.submit()">
                                            <option value="">全部狀態</option>
                                            <option value="0" {{ $request->status === '0' ? 'selected' : '' }}>未確認</option>
                                            <option value="1" {{ $request->status === '1' ? 'selected' : '' }}>已確認</option>
                                        </select>
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
                                        <th scope="col">地點</th>
                                        <!---<th scope="col">錚典待辦</th>--->
                                        <!---<th scope="col">客戶待辦</th>--->
                                        <th scope="col">確認狀態</th>
                                        <th scope="col">NAS連結</th>
                                        <th scope="col" style="width: 200px;">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $key => $data)
                                        <tr align="center">
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $data->user_data->name }}</td>
                                            <td>
                                                {{ substr($data->date, 0, 10) }}
                                                @if (isset($data->start_time) && isset($data->end_time))
                                                    {{ substr($data->start_time, 0, 5) }}~{{ substr($data->end_time, 0, 5) }}
                                                @endif
                                            </td>
                                            <td>{{ $data->name }}</td>
                                            <td>{{ $data->place }}</td>
                                            <!--- <td>{{ $data->to_do }}</td>---->
                                            <!--- <td>{{ $data->cust_to_do }}</td>---->
                                            <td>
                                                @if ($data->status == 1)
                                                    已確認 / {{ $data->confirm_time }}
                                                @else
                                                    未確認
                                                @endif
                                            </td>
                                            <td><a href="{{ $data->nas_link }}">連結</a></td>
                                            <td align="center">
                                                <a href="{{ route('meetData.exportWordWithHtml', $data->id) }}" class="action-icon">
                                                    <i class="mdi mdi-file-word"></i>
                                                </a>
                                                <a href="{{ route('meetData.edit', $data->id) }}" class="action-icon"> <i
                                                        class="mdi mdi-square-edit-outline"></i></a>
                                                <a href="{{ route('meetData.del', $data->id) }}" class="action-icon"> <i
                                                        class="mdi mdi-trash-can-outline"></i></a>
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
