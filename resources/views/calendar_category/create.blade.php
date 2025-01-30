@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', ['title' => '行事曆類別新增', 'subtitle' => '設定管理'])

        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('CalendarCategory.create.data') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="mb-3">
                                    <label class="form-label">名稱<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" value="" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">顏色類別<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="classname" value="bg-primary" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">排序<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="seq" value="0" required>
                                </div>
                                <div class="mb-1">
                                    <label for="project-priority" class="form-label">狀態<span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" data-toggle="select" data-width="100%" name="status">
                                        <option value="up">上架</option>
                                        <option value="down">下架</option>
                                    </select>
                                </div>
                            </div> <!-- end col-->
                    </div>
                    <!-- end row -->
                    <div class="row mb-3">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                    class="fe-check-circle me-1"></i>新增</button>
                            <button type="reset" class="btn btn-secondary waves-effect waves-light m-1"
                                onclick="history.go(-1)"><i class="fe-x me-1"></i>回上一頁</button>
                        </div>
                    </div>
                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col-->
        <!-- end row -->

    </div> <!-- container -->
@endsection
