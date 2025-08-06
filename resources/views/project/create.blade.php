@extends('layouts.vertical', ['title' => 'CRM Customers'])
@section('css')
    @vite(['node_modules/selectize/dist/css/selectize.bootstrap3.css', 'node_modules/mohithg-switchery/dist/switchery.min.css', 'node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css', 'node_modules/select2/dist/css/select2.min.css', 'node_modules/multiselect/css/multi-select.css'])
@endsection
@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', ['title' => '新增專案', 'subtitle' => '專案管理'])

        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('project.create.data') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="mb-3">
                                    <label class="form-label">專案起始日期<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="date" value="" required>
                                </div>
                                <div class="mb-3">
                                    <label for="project-priority" class="form-label">專案類型<span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" data-toggle="select" data-width="100%" name="type">
                                        @foreach ($project_types as $key => $project_type)
                                            <option value="{{ $project_type->id }}">{{ $project_type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="project-priority" class="form-label">客戶名稱<span
                                            class="text-danger">*</span></label>
                                    <select class="form-control"data-toggle="select2" data-width="100%" name="user_id" id="cust_select">
                                        <option value="" selected>請選擇</option>
                                        @foreach ($cust_datas as $key => $cust_data)
                                            <option value="{{ $cust_data->id }}">{{ $cust_data->name }}</option>
                                        @endforeach
                                        
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">計畫登入帳號</label>
                                    <input type="text" class="form-control" name="account" value="" id="cust_account">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">計畫登入密碼</label>
                                    <input type="password" class="form-control" name="password" value="" id="cust_password">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">檢附資料連結<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="attached_link" value="" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">上傳附件連結<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="upload_link" value="" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">計劃書下載連結<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="download_link" value="" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">專案執行階段：<span class="text-danger">*</span></label>
                                    <select class="form-control" data-toggle="select2" data-width="100%" name="check_status"
                                        required>
                                        <option value="" selected>請選擇</option>
                                        @foreach ($check_statuss as $key => $check_status)
                                            <optgroup label="{{ $check_status->name }}">
                                                @foreach ($check_status->check_childrens as $num => $check_children)
                                                    <option value="{{ $check_children->id }}">{{ $check_children->name }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
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


@section('script')
<!---根據user抓取帳號密碼 ---->

    @vite(['resources/js/pages/form-advanced.init.js'])
    <script>
       document.addEventListener("DOMContentLoaded", function() {
    let cust_select = document.getElementById("cust_select");
    let cust_account = document.getElementById("cust_account");
    let cust_password = document.getElementById("cust_password");

    cust_select.addEventListener("change", function() {
        let id = this.value;  // 確保用的是 id 而不是 customer_id

        // 檢查是否選擇了有效的客戶 ID
        if (id) {
            fetch(`/get-customer-account/${id}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);  // 檢查返回的資料

                    // 如果返回的資料有帳號和密碼，則填充表單
                    if (data.cust_account && data.cust_password) {
                        cust_account.value = data.cust_account;
                        cust_password.value = data.cust_password;
                    } else {
                        cust_account.value = "查無帳號資料";
                        cust_password.value = "查無密碼資料";
                    }
                })
                .catch(error => console.error("錯誤:", error));
        } else {
            // 如果沒有選擇客戶，則清空表單
            cust_account.value = "請選擇一個客戶";
            cust_password.value = "請選擇一個客戶";
        }
    });
});
    </script>
@endsection

