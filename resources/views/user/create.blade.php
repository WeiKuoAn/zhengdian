@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', ['title' => '用戶管理', 'subtitle' => '新增用戶'])

        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('user.create.data') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="mb-3">
                                        <label class="form-label">職稱</label>
                                        <select class="form-select" name="job_id">
                                            @foreach ($jobs as $job)
                                                <option value="{{ $job->id }}">{{ $job->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="AddNew-Username">姓名</label>
                                        <input type="text" class="form-control" id="AddNew-Username" name="name">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="AddNew-Username">帳號</label>
                                        <input type="text" class="form-control" id="AddNew-Username" name="email">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="AddNew-Email">密碼</label>
                                        <input type="text" class="form-control" id="AddNew-Email" name="password">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">群組</label>
                                        <select class="form-select" name="group_id">
                                            @foreach ($groups as $group)
                                                <option value="{{ $group->id }}">{{ $group->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">權限</label>
                                        <select class="form-select" name="level">
                                            @if (Auth::user()->level == 0)
                                                <option value="1">管理者</option>
                                            @endif
                                            <option value="2" selected>一般使用者</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success" data-bs-toggle="modal"
                                            data-bs-target="#success-btn" id="btn-save-event">新增用戶</button>
                                        <button type="button" class="btn btn-danger me-1"
                                            data-bs-dismiss="modal">回上一頁</button>
                                    </div>
                                </div>
                            </div>


                        </form>
                    </div> <!-- end card-body -->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div>
        <!-- end row -->

    </div> <!-- container -->
@endsection
