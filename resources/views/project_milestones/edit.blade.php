@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', ['title' => '排程管理', 'subtitle' => '專案排程編輯'])

        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('projectMilestones.edit.data', $data->id) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">客戶名稱<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" value="{{ $data->project_data->user_data->name ?? '' }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">專案派工<span class="text-danger">*</span></label>
                                        <select class="form-control" data-toggle="select" data-width="100%" name="milestone_type" required>
                                            <option value="">請選擇派工</option>
                                            @foreach ($task_datas as $task_data)
                                                <option value="{{ $task_data->id }}" @if($data->milestone_type == $task_data->id) selected @endif>{{ $task_data->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">表訂時間<span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="order_date" value="{{ $data->order_date }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">預計完成時間<span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="milestone_date" value="{{ $data->milestone_date }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">實際完成時間</label>
                                        <input type="date" class="form-control" name="formal_date" value="{{ $data->formal_date }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">行事曆類別<span class="text-danger">*</span></label>
                                        <select class="form-control" data-toggle="select" data-width="100%" name="category_id" required>
                                            <option value="">請選擇類別</option>
                                            @foreach ($calendar_categorys as $category)
                                                <option value="{{ $category->id }}" @if($data->category_id == $category->id) selected @endif>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div> <!-- end row -->
                            
                            <div class="row mb-3">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                            class="fe-check-circle me-1"></i>更新</button>
                                    <button type="button" class="btn btn-secondary waves-effect waves-light m-1"
                                        onclick="history.go(-1)"><i class="fe-x me-1"></i>回上一頁</button>
                                </div>
                            </div>
                        </form>
                    </div> <!-- end card-body -->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div> <!-- end row -->

    </div> <!-- container -->
@endsection
