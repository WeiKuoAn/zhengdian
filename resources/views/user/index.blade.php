@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', ['title' => '用戶管理', 'subtitle' => '用戶列表'])

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-4">
                                <div class="mt-2 mt-sm-0">
                                    <form method="GET" action="{{ route('users') }}"
                                        class="d-inline-flex align-items-center flex-nowrap">
                                        <label for="status_filter" class="me-2 mb-0 text-nowrap">狀態篩選</label>
                                        <select id="status_filter" name="status_filter" class="form-select form-select-sm"
                                            style="min-width: 90px;"
                                            onchange="this.form.submit()">
                                            <option value="all" {{ ($statusFilter ?? 'enabled') === 'all' ? 'selected' : '' }}>全部</option>
                                            <option value="enabled" {{ ($statusFilter ?? 'enabled') === 'enabled' ? 'selected' : '' }}>啟用</option>
                                            <option value="disabled" {{ ($statusFilter ?? 'enabled') === 'disabled' ? 'selected' : '' }}>停用</option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="text-sm-end mt-2 mt-sm-0">
                                    <a href="{{ route('user.create') }}">
                                        <button type="button" class="btn btn-danger waves-effect waves-light"><i
                                                class="mdi mdi-plus-circle me-1"></i> 新增用戶</button>
                                    </a>
                                </div>
                            </div><!-- end col-->
                        </div>

                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap table-striped" id="products-datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">姓名</th>
                                        <th scope="col" width="30%">帳號</th>
                                        <th scope="col">群組</th>
                                        <th scope="col">職稱</th>
                                        <th scope="col">等級</th>
                                        <th scope="col">權限</th>
                                        <th scope="col" style="width: 200px;">動作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $key => $data)
                                        <tr>
                                            <td>
                                                {{ $key + 1 }}
                                            </td>
                                            <td>
                                                {{ $data->name }}
                                            </td>
                                            <td>{{ $data->email }}</td>
                                            <td>{{ $data->group_data->name }}</td>
                                            <td>
                                                @if (isset($data->job_data))
                                                    {{ $data->job_data->name }}
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-soft-success font-size-14">
                                                    @if ($data->level == 0)
                                                        超級管理者
                                                    @elseif($data->level == 1)
                                                        管理者
                                                    @else
                                                        一般使用者
                                                    @endif
                                                </span>
                                            </td>
                                            <td>
                                                @if ($data->status == 0)
                                                    開通
                                                @else
                                                    <b class="text-danger">停用</b>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group dropdown">
                                                    @if ($data->level != '0')
                                                        <a href="javascript: void(0);"
                                                            class="table-action-btn dropdown-toggle arrow-none btn btn-outline-secondary waves-effect"
                                                            data-bs-toggle="dropdown" aria-expanded="false">動作 <i
                                                                class="mdi mdi-arrow-down-drop-circle"></i></a>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item"
                                                                href="{{ route('user.edit', $data->id) }}"><i
                                                                    class="mdi mdi-pencil me-2 text-muted font-18 vertical-middle"></i>編輯</a>
                                                            <a class="dropdown-item"
                                                                href="{{ route('person.task.calendar.user', $data->id) }}"><i
                                                                    class="mdi mdi-calendar-month-outline me-2 font-18 text-muted vertical-middle"></i>查看派工行事曆</a>
                                                            @if ((int) Auth::user()->level === 0)
                                                                <form action="{{ route('user.del.data', $data->id) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('確定要刪除此帳號嗎？此動作無法復原。');">
                                                                    @csrf
                                                                    <button type="submit" class="dropdown-item text-danger">
                                                                        <i
                                                                            class="mdi mdi-delete me-2 font-18 vertical-middle"></i>刪除
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
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

    <!-- Modal -->
    {{-- <div class="modal fade" id="custom-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Add New Customers</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body p-4">
                    <form>
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter full name">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                        </div>
                        <div class="mb-3">
                            <label for="position" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="position" placeholder="Enter phone number">
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Location</label>
                            <input type="text" class="form-control" id="category" placeholder="Enter Location">
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success waves-effect waves-light">Save</button>
                            <button type="button" class="btn btn-danger waves-effect waves-light"
                                data-bs-dismiss="modal">Continue</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div> --}}
    <!-- /.modal -->
@endsection
