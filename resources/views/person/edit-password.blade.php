@extends('layouts.vertical', ['title' => '變更密碼'])
@section('css')
    @vite(['node_modules/spectrum-colorpicker2/dist/spectrum.min.css', 'node_modules/flatpickr/dist/flatpickr.min.css', 'node_modules/clockpicker/dist/bootstrap-clockpicker.min.css', 'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css'])
@endsection
@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', [
            'title' => '變更密碼',
            'subtitle' => '變更密碼',
        ])

        <div class="row">
            <div class="col-xl-6">
                @if ($hint == '1')
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        會員密碼修改失敗！請重新再一次
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if ($hint == '2')
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        新密碼與確認密碼輸入不符！請重新再一次
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('user-password.data') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="mb-3">
                                        <label for="projectname" class="form-label">舊密碼<span
                                                class="text-danger">*</span></label>
                                        <input type="password" id="projectname" class="form-control" name="password"
                                            required>
                                    </div>
                                </div> <!-- end col-->

                                <div class="col-xl-12">
                                    <div class="mb-3">
                                        <label for="projectname" class="form-label">新密碼<span
                                                class="text-danger">*</span></label>
                                        <input type="password" id="password_new" class="form-control" name="password_new"
                                            required>
                                    </div>
                                </div>

                                <div class="col-xl-12">
                                    <div class="mb-3">
                                        <label for="projectname" class="form-label">確認密碼<span
                                                class="text-danger">*</span></label>
                                        <input type="password" id="password_conf" class="form-control" name="password_conf"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->


                            <div class="row mt-3">
                                <div class="col-12 text-center">
                                    <button type="button" class="btn btn-danger me-1"
                                        onclick="history.go(-1)">回上一頁</button>
                                    <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                            class="fe-check-circle me-1"></i>修改</button>
                                </div>
                            </div>
                        </form>
                    </div> <!-- end card-body -->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div>

    </div> <!-- container -->
@endsection
@section('script')
    @vite(['resources/js/pages/form-pickers.init.js'])
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
