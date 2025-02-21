@extends('layouts.vertical', ['title' => 'CRM Customers'])
@section('css')
    @vite(['node_modules/spectrum-colorpicker2/dist/spectrum.min.css', 'node_modules/flatpickr/dist/flatpickr.min.css', 'node_modules/clockpicker/dist/bootstrap-clockpicker.min.css', 'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css'])
@endsection
@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', ['title' => '會議管理', 'subtitle' => '編輯會議'])

        <div class="row">
            <div class="col-xl-7">
                <div class="card">
                    <div class="card-body">
                        <form class="form-horizontal" method="POST" action="{{ route('meetData.edit.data',$data->id) }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-4 col-xl-3 col-form-label"
                                    style="text-align: right;">客戶名稱：</label>
                                <div class="col-8 col-xl-9">
                                    <select class="form-control" data-toggle="select" data-width="100%" name="user_id">
                                        <option value="" selected>請選擇</option>
                                        @foreach ($cust_datas as $key => $cust_data)
                                            <option value="{{ $cust_data->id }}" @if($data->user_id == $cust_data->id) selected @endif>{{ $cust_data->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-4 col-xl-3 col-form-label"
                                    style="text-align: right;">會議名稱：</label>
                                <div class="col-8 col-xl-9">
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $data->name }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputPassword3" class="col-4 col-xl-3 col-form-label"
                                    style="text-align: right;">議程：</label>
                                <div class="col-8 col-xl-9">
                                    <textarea class="form-control" id="example-textarea" name="agenda" rows="2">{{ $data->agenda }}</textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputPassword5" class="col-4 col-xl-3 col-form-label"
                                    style="text-align: right;">時間：</label>
                                <div class="col-8 col-xl-9">
                                    <div class="input-group mb-2">
                                        <input type="date" class="form-control" name="date" value="{{ substr($data->date, 0, 10) }}" required>
                                        <input type="text" id="24hours-timepicker" name="datetime"
                                            class="form-control" placeholder="時：分" value="{{ substr($data->date, 11, 5) }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-4 col-xl-3 col-form-label"
                                    style="text-align: right;">地點：</label>
                                <div class="col-8 col-xl-9">
                                    <input type="text" class="form-control" id="place" name="place" value="{{ $data->place }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-4 col-xl-3 col-form-label"
                                    style="text-align: right;">列席：</label>
                                <div class="col-8 col-xl-9">
                                    <input type="text" class="form-control" id="attend" name="attend" value="{{ $data->attend }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-4 col-xl-3 col-form-label"
                                    style="text-align: right;">會議記錄：</label>
                                <div class="col-8 col-xl-9">
                                    <textarea class="form-control" id="example-textarea" name="record" rows="5">{{ $data->record }}</textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-4 col-xl-3 col-form-label"
                                    style="text-align: right;">錚典待辦：</label>
                                <div class="col-8 col-xl-9">
                                    <textarea class="form-control" id="example-textarea" name="to_do" rows="3">{{ $data->to_do }}</textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-4 col-xl-3 col-form-label"
                                    style="text-align: right;">客戶待辦：</label>
                                <div class="col-8 col-xl-9">
                                    <textarea class="form-control" id="example-textarea" name="cust_to_do" rows="3">{{ $data->cust_to_do }}</textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-4 col-xl-3 col-form-label"
                                    style="text-align: right;">Nas連結：</label>
                                <div class="col-8 col-xl-9">
                                    <input type="text" class="form-control" id="nas_link" name="nas_link" value="{{ $data->nas_link }}">
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                            class="fe-check-circle me-1"></i>編輯</button>
                                    <button type="reset" class="btn btn-secondary waves-effect waves-light m-1"
                                        onclick="history.go(-1)"><i class="fe-x me-1"></i>回上一頁</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- end row -->

                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col-->
        <!-- end row -->

    </div> <!-- container -->
@endsection
@section('script')
    @vite(['resources/js/pages/form-pickers.init.js'])
    <script>
        $(document).ready(function() {
            $('form').on('submit', function(event) {
                let timepickerValue = $('#24hours-timepicker').val().trim(); // 取得輸入值並去除空格

                if (timepickerValue === '') {
                    alert('請輸入預計完成時間！'); // 顯示警告
                    $('#24hours-timepicker').focus(); // 將焦點放到該輸入框
                    event.preventDefault(); // 阻止表單提交
                }
            });
        });
    </script>
@endsection
