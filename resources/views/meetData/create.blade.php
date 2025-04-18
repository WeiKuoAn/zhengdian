@extends('layouts.vertical', ['title' => 'CRM Customers'])
@section('css')
    @vite(['node_modules/selectize/dist/css/selectize.bootstrap3.css', 'node_modules/mohithg-switchery/dist/switchery.min.css', 'node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css', 'node_modules/select2/dist/css/select2.min.css', 'node_modules/multiselect/css/multi-select.css'])
@endsection
@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', ['title' => '會議管理', 'subtitle' => '新增會議'])

        <div class="row">
            <div class="col-xl-7">
                <div class="card">
                    <div class="card-body">
                        <form class="form-horizontal" method="POST" action="{{ route('meetData.create.data') }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-4 col-xl-3 col-form-label"
                                    style="text-align: right;">客戶名稱：</label>
                                <div class="col-8 col-xl-9">
                                    <select class="form-control" data-toggle="select2" data-width="100%" name="user_id">
                                        <option value="" selected>請選擇</option>
                                        @foreach ($cust_datas as $key => $cust_data)
                                            <option value="{{ $cust_data->id }}">{{ $cust_data->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-4 col-xl-3 col-form-label"
                                    style="text-align: right;">會議名稱：</label>
                                <div class="col-8 col-xl-9">
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputPassword3" class="col-4 col-xl-3 col-form-label"
                                    style="text-align: right;">議程：</label>
                                <div class="col-8 col-xl-9">
                                    <textarea class="form-control" id="example-textarea" name="agenda" rows="2"></textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputPassword5" class="col-4 col-xl-3 col-form-label"
                                    style="text-align: right;">時間：</label>
                                <div class="col-8 col-xl-9">
                                    <div class="input-group mb-2">
                                        <input type="date" class="form-control" name="date" required>
                                        <input type="text" id="24hours-timepicker" name="datetime" class="form-control"
                                            placeholder="時：分" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-4 col-xl-3 col-form-label"
                                    style="text-align: right;">地點：</label>
                                <div class="col-8 col-xl-9">
                                    <input type="text" class="form-control" id="place" name="place">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-4 col-xl-3 col-form-label"
                                    style="text-align: right;">列席：</label>
                                <div class="col-8 col-xl-9">
                                    <input type="text" class="form-control" id="attend" name="attend">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-4 col-xl-3 col-form-label"
                                    style="text-align: right;">會議記錄：</label>
                                <div class="col-8 col-xl-9">
                                    <textarea class="form-control" id="example-textarea" name="record" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-4 col-xl-3 col-form-label"
                                    style="text-align: right;">錚典待辦：</label>
                                <div class="col-8 col-xl-9">
                                    <textarea class="form-control" id="example-textarea" name="to_do" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-4 col-xl-3 col-form-label"
                                    style="text-align: right;">客戶待辦：</label>
                                <div class="col-8 col-xl-9">
                                    <textarea class="form-control" id="example-textarea" name="cust_to_do" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputEmail3" class="col-4 col-xl-3 col-form-label"
                                    style="text-align: right;">Nas連結：</label>
                                <div class="col-8 col-xl-9">
                                    <input type="text" class="form-control" id="nas_link" name="nas_link">
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                            class="fe-check-circle me-1"></i>新增</button>
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
@vite(['resources/js/pages/form-advanced.init.js'])
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
