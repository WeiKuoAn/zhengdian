@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', [
            'title' => '製造業-資料',
            'subtitle' => Auth::user()->name,
        ])
        <!--  successfully modal  -->
        <div id="success-btn" class="modal fade" tabindex="-1" aria-labelledby="success-btnLabel" aria-hidden="true"
            data-bs-scroll="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center">
                            <i class="bx bx-check-circle display-1 text-success"></i>
                            <h4 class="mt-3">儲存資料成功！</h4>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <form action="{{ route('manufacturing.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">

                        <div class="col-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        <h2>人事資料</h2>
                                        <p class="font-size-20 text-danger">所有人員皆須在勞保投保明細中</p>
                                    </div>
                                    <div class="row">
                                        <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">計畫主持人資料<span
                                                class="text-danger">*</span></h5>
                                        <div class="col-md-4">
                                            <label class="form-label" for="AddNew-Phone"><b>姓名</b></label>
                                            <input type="text" class="form-control required-input" name="host_name"
                                                @if (isset($project_host_data)) value="{{ $project_host_data->name }}" @endif>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" for="AddNew-Username"><b>部門</b></label>
                                            <input type="text" class="form-control required-input" name="host_department"
                                                @if (isset($project_host_data)) value="{{ $project_host_data->department }}" @endif>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" for="AddNew-Username"><b>職稱</b></label>
                                            <input type="text" class="form-control required-input" name="host_job"
                                                @if (isset($project_host_data)) value="{{ $project_host_data->job }}" @endif>
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label class="form-label" for="AddNew-Username"><b>工作內容</b></label>
                                            <input type="text" class="form-control required-input" name="host_context"
                                                @if (isset($project_host_data)) value="{{ $project_host_data->context }}" @endif>
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label class="form-label" for="AddNew-Username"><b>專長</b></label>
                                            <input type="text" class="form-control required-input" name="host_experience"
                                                @if (isset($project_host_data)) value="{{ $project_host_data->experience }}" @endif>
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label class="form-label" for="AddNew-Username"><b>過往經歷</b></label>
                                            <input type="text" class="form-control required-input"
                                                name="host_past_experience"
                                                @if (isset($project_host_data)) value="{{ $project_host_data->past_experience }}" @endif>
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label class="form-label" for="AddNew-Username"><b>電話(含分機)</b></label>
                                            <input type="text" class="form-control required-input" name="host_mobile"
                                                @if (isset($project_host_data)) value="{{ $project_host_data->mobile }}" @endif>
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label class="form-label" for="AddNew-Username"><b>手機</b></label>
                                            <input type="text" class="form-control required-input" name="host_phone"
                                                @if (isset($project_host_data)) value="{{ $project_host_data->phone }}" @endif>
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label class="form-label" for="AddNew-Username"><b>信箱</b></label>
                                            <input type="text" class="form-control required-input" name="host_email"
                                                @if (isset($project_host_data)) value="{{ $project_host_data->email }}" @endif>
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label class="form-label" for="AddNew-Username"><b>實際薪資</b></label>
                                            <input type="text" class="form-control required-input" name="host_salary"
                                                @if (isset($project_host_data)) value="{{ $project_host_data->salary }}" @endif>
                                        </div>

                                        <hr class="mt-4 mb-4">

                                        <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">計畫聯絡人資料<span
                                                class="text-danger">*</span></h5>
                                        <div class="col-md-4">
                                            <label class="form-label" for="AddNew-Phone"><b>姓名</b></label>
                                            <input type="text" class="form-control required-input" name="contact_name"
                                                @if (isset($project_contact_data)) value="{{ $project_contact_data->name }}" @endif>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" for="AddNew-Username"><b>部門</b></label>
                                            <input type="text" class="form-control required-input"
                                                name="contact_department"
                                                @if (isset($project_contact_data)) value="{{ $project_contact_data->department }}" @endif>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" for="AddNew-Username"><b>職稱</b></label>
                                            <input type="text" class="form-control required-input" name="contact_job"
                                                @if (isset($project_contact_data)) value="{{ $project_contact_data->job }}" @endif>
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label class="form-label" for="AddNew-Username"><b>工作內容</b></label>
                                            <input type="text" class="form-control required-input"
                                                name="contact_context"
                                                @if (isset($project_contact_data)) value="{{ $project_contact_data->context }}" @endif>
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label class="form-label" for="AddNew-Username"><b>專長/經歷</b></label>
                                            <input type="text" class="form-control required-input"
                                                name="contact_experience"
                                                @if (isset($project_contact_data)) value="{{ $project_contact_data->experience }}" @endif>
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label class="form-label" for="AddNew-Username"><b>過往經歷</b></label>
                                            <input type="text" class="form-control required-input"
                                                name="contact_past_experience"
                                                @if (isset($project_contact_data)) value="{{ $project_contact_data->past_experience }}" @endif>
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label class="form-label" for="AddNew-Username"><b>電話(含分機)</b></label>
                                            <input type="text" class="form-control required-input"
                                                name="contact_mobile"
                                                @if (isset($project_contact_data)) value="{{ $project_contact_data->mobile }}" @endif>
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <label class="form-label" for="AddNew-Username"><b>手機</b></label>
                                            <input type="text" class="form-control required-input"
                                                name="contact_phone"
                                                @if (isset($project_contact_data)) value="{{ $project_contact_data->phone }}" @endif>
                                        </div>

                                        <div class="col-md-4 mt-3">
                                            <label class="form-label" for="AddNew-Username"><b>信箱</b></label>
                                            <input type="text" class="form-control required-input"
                                                name="contact_email"
                                                @if (isset($project_contact_data)) value="{{ $project_contact_data->email }}" @endif>
                                        </div>

                                        <div class="col-md-4 mt-3">
                                            <label class="form-label" for="AddNew-Username"><b>實際薪資</b></label>
                                            <input type="text" class="form-control required-input"
                                                name="contact_salary"
                                                @if (isset($project_contact_data)) value="{{ $project_contact_data->salary }}" @endif>
                                        </div>

                                        <hr class="mt-4 mb-4">

                                        <div class="col-md-12 mt-3">
                                            <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">
                                                人事名單（約4-6位-皆須在勞保投保明細中。因配合計畫申請，故薪資部分不一定會按填寫的實際薪資做編列）<span
                                                    class="text-danger">*</span></h5>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <table id="preson" class="table preson-list">
                                                            <thead>
                                                                <tr align="center">
                                                                    <th>編號</th>
                                                                    <th>姓名<span class="text-danger">*</span></th>
                                                                    <th>部門<span class="text-danger">*</span></th>
                                                                    <th>職稱<span class="text-danger">*</span></th>
                                                                    <th>工作內容<span class="text-danger">*</span></th>
                                                                    <th>專長<span class="text-danger">*</span></th>
                                                                    <th>過往經歷<span class="text-danger">*</span></th>
                                                                    <th>實際薪資<span class="text-danger">*</span></th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody valign="center" align="center">
                                                                @if (count($project->personnel_datas) > 0)
                                                                    @foreach ($project->personnel_datas as $key => $personnel_data)
                                                                        <tr id="row-{{ $key }}">
                                                                            <td>{{ $key + 1 }}</td>
                                                                            <td>
                                                                                <input id="pay_date-{{ $key }}"
                                                                                    class="mobile form-control required-input"
                                                                                    type="text"
                                                                                    name="personnel_names[]"
                                                                                    value="{{ $personnel_data->name }}">
                                                                            </td>
                                                                            <td>
                                                                                <input id="pay_date-{{ $key }}"
                                                                                    class="mobile form-control required-input"
                                                                                    type="text"
                                                                                    name="personnel_departments[]"
                                                                                    value="{{ $personnel_data->department }}">
                                                                            </td>
                                                                            <td>
                                                                                <input id="pay_price-{{ $key }}"
                                                                                    class="mobile form-control required-input"
                                                                                    type="text" name="personnel_jobs[]"
                                                                                    value="{{ $personnel_data->job }}">
                                                                            </td>
                                                                            <td>
                                                                                <input id="pay_price-{{ $key }}"
                                                                                    class="mobile form-control required-input"
                                                                                    type="text"
                                                                                    name="personnel_contexts[]"
                                                                                    value="{{ $personnel_data->context }}">
                                                                            </td>
                                                                            <td>
                                                                                <input id="pay_price-{{ $key }}"
                                                                                    class="mobile form-control required-input"
                                                                                    type="text"
                                                                                    name="personnel_experiences[]"
                                                                                    value="{{ $personnel_data->experience }}">
                                                                            </td>
                                                                            <td>
                                                                                <input id="pay_price-{{ $key }}"
                                                                                    class="mobile form-control required-input"
                                                                                    type="text"
                                                                                    name="personnel_past_experiences[]"
                                                                                    value="{{ $personnel_data->past_experience }}">
                                                                            </td>
                                                                            <td>
                                                                                <input id="pay_price-{{ $key }}"
                                                                                    class="mobile form-control required-input"
                                                                                    type="text"
                                                                                    name="personnel_salarys[]"
                                                                                    value="{{ $personnel_data->salary }}">
                                                                            </td>
                                                                            <td>
                                                                                <button
                                                                                    class="mobile btn btn-danger del-row"
                                                                                    alt="{{ $key }}"
                                                                                    type="button" name="button"
                                                                                    onclick="del_row(this)">刪除</button>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    @for ($i = 0; $i < 1; $i++)
                                                                        <tr id="row-{{ $i }}">
                                                                            <td>{{ $i + 1 }}</td>
                                                                            <td>
                                                                                <input id="pay_date-{{ $i }}"
                                                                                    class="mobile form-control required-input"
                                                                                    type="text"
                                                                                    name="personnel_names[]"
                                                                                    value="">
                                                                            </td>
                                                                            <td>
                                                                                <input id="pay_date-{{ $i }}"
                                                                                    class="mobile form-control required-input"
                                                                                    type="text"
                                                                                    name="personnel_departments[]"
                                                                                    value="">
                                                                            </td>
                                                                            <td>
                                                                                <input id="pay_price-{{ $i }}"
                                                                                    class="mobile form-control required-input"
                                                                                    type="text" name="personnel_jobs[]"
                                                                                    value="">
                                                                            </td>
                                                                            <td>
                                                                                <input id="pay_price-{{ $i }}"
                                                                                    class="mobile form-control required-input"
                                                                                    type="text"
                                                                                    name="personnel_contexts[]"
                                                                                    value="">
                                                                            </td>
                                                                            <td>
                                                                                <input id="pay_price-{{ $i }}"
                                                                                    class="mobile form-control required-input"
                                                                                    type="text"
                                                                                    name="personnel_experiences[]"
                                                                                    value="">
                                                                            </td>
                                                                            <td>
                                                                                <input id="pay_price-{{ $i }}"
                                                                                    class="mobile form-control required-input"
                                                                                    type="text"
                                                                                    name="personnel_past_experiences[]"
                                                                                    value="">
                                                                            </td>
                                                                            <td>
                                                                                <input id="pay_price-{{ $i }}"
                                                                                    class="mobile form-control required-input"
                                                                                    type="text"
                                                                                    name="personnel_salarys[]"
                                                                                    value="">
                                                                            </td>
                                                                            <td>
                                                                                <button
                                                                                    class="mobile btn btn-danger del-row"
                                                                                    alt="{{ $i }}"
                                                                                    type="button" name="button"
                                                                                    onclick="del_row(this)">刪除</button>
                                                                            </td>
                                                                        </tr>
                                                                    @endfor
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div> <!-- end .table-responsive -->
                                                    <div class="form-group row">
                                                        <div class="col-12">
                                                            <input id="add_preson" class="btn btn-primary" type="button"
                                                                name="" value="新增筆數">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-center mb-3">
                                        <h2>需求</h2>
                                        <p class="font-size-18">申請計畫使用</p>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mt-1">
                                            <div class="alert alert-danger text-center" role="alert">
                                                公司現在原有的系統或設備（有在財產清冊裡的設備即可）有哪些？哪一些設備已使用10-15年？當初向哪家客戶購入請簡述
                                                （ex：空壓機、冷凍機、採購系統、ERP企業資源計劃系統、MES執行系統...等）<br>
                                                📌並請針對想更新或汰換的系統或設備進行排序
                                            </div>
                                            <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">需求列表</h5>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <table id="need" class="table need-list">
                                                            <thead>
                                                                <tr align="center">
                                                                    <th>簡述內容<span class="text-danger">*</span></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody align="center">
                                                                <tr id="" valign="middle">
                                                                    <td width="90%">
                                                                        <textarea class="form-control" name="need_contexts[]" rows="8">
@if (isset($project->manufacture_need_data))
{{ $project->manufacture_need_data->context }}
@endif
</textarea>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div> <!-- end .table-responsive -->
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-4 mb-2">
                                            <div class="col text-center">
                                                <button class="btn btn-success" type="submit" id="btn_storage"><i
                                                        class="bx bx-file me-1"></i> 確認儲存 </button>
                                                <a href="{{ route('manufacturing.appendix') }}">
                                                    <button class="btn btn-primary" type="button" id="btn_submit"><i
                                                            class=" bx bx-check me-1"></i> 查看附件 </button>
                                                </a>
                                            </div> <!-- end col -->
                                        </div>
        </form>

    </div>
    </div>
    </div>
    </div>

    </div>


    </div>
@endsection

@section('script')
    @if (session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var successModal = new bootstrap.Modal(document.getElementById('success-btn'));
                successModal.show();
            });
        </script>
    @endif

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="{{ asset('assets/js/twzipcode-1.4.1-min.js') }}"></script>

        <script>
            $(document).ready(function(){
                $(".twzipcode").twzipcode({
                    css: ["twzipcode-select", "twzipcode-select" , "twzipcode-select"], // 自訂 "城市"、"地區" class 名稱 
                    countyName: "county", // 自訂城市 select 標籤的 name 值
                    districtName: "district", // 自訂地區 select 標籤的 name 值
                    zipcodeName: "zipcode", // 自訂地區 select 標籤的 name 值
                    'countySel': '{{ $project->county }}',
                    'districtSel': '{{ $project->district }}',
                    'zipcodeSel': '{{ $project->zipcode }}'
                });

                
                @if(session('success'))
                    $('#success-btn').modal('show');
                @endif
            });

            $(document).ready(function() {
                var presonRowCount = $('#preson tbody tr').length;

                $('#add_preson').click(function() {
                    if (presonRowCount < 6) {
                        presonRowCount++;
                        var newRow = `<tr id="row-${presonRowCount}">
                                        <td>
                                            ${presonRowCount}
                                        </td>
                                        <td>
                                            <input id="pay_date-${presonRowCount}" class="mobile form-control" type="text" name="personnel_names[]" value="">
                                        </td>
                                        <td>
                                            <input id="department-${presonRowCount}" class="mobile form-control" type="text" name="personnel_departments[]" value="">
                                        </td>
                                        <td>
                                            <input id="title-${presonRowCount}" class="mobile form-control" type="text" name="personnel_jobs[]" value="">
                                        </td>
                                        <td>
                                            <input id="title-${presonRowCount}" class="mobile form-control" type="text" name="personnel_contexts[]" value="">
                                        </td>
                                        <td>
                                            <input id="title-${presonRowCount}" class="mobile form-control" type="text" name="personnel_experiences[]" value="">
                                        </td>
                                        <td>
                                            <input id="title-${presonRowCount}" class="mobile form-control" type="text" name="personnel_past_experiences[]" value="">
                                        </td>
                                        <td>
                                            <input id="pay_price-${presonRowCount}" class="mobile form-control required-input" type="text" name="personnel_salarys[]" value="">
                                        </td>
                                        <td>
                                            <button class="mobile btn btn-danger del-row" alt="${presonRowCount}" type="button" name="button">刪除</button>
                                        </td>
                                    </tr>`;
                        $('#preson tbody').append(newRow);
                    } else {
                        alert('已達8筆最高新增上限');
                    }
                });

                // Event delegation for dynamically added elements
                $('#preson').on('click', '.del-row', function() {
                    $(this).closest('tr').remove();
                    presonRowCount--;
                });
            });


            var addDeviceRowCount = $('#need-device tbody tr').length;
            $('#add_device_need').click(function() {
                if (addDeviceRowCount < 5) {
                    addDeviceRowCount++;
                    var newRow = `<tr id="row-${addDeviceRowCount}">
                        <td>
                                                                <input id="pay_date-${addDeviceRowCount}" class="mobile form-control" type="text" name="expected_names[]" value="">
                                                            </td>
                                                            <td>
                                                                <input id="pay_date-${addDeviceRowCount}" class="mobile form-control" type="text" name="expected_brands[]" value="">
                                                            </td>
                                                            <td>
                                                                <input id="pay_date-${addDeviceRowCount}" class="mobile form-control" type="text" name="expected_models[]" value="">
                                                            </td>
                                                            <td>
                                                                <input id="pay_date-${addDeviceRowCount}" class="mobile form-control" type="text" name="expected_purposes[]" value="">
                                                            </td>
                                                            <td>
                                                                <input id="pay_date-${addDeviceRowCount}" class="mobile form-control" type="text" name="expected_costs[]" value="">
                                                            </td>
                                                            <td>
                                                                <input id="pay_date-${addDeviceRowCount}" class="mobile form-control" type="text" name="expected_procurements[]" value="">
                                                            </td>
                                                            <td>
                                                                <input id="pay_date-${addDeviceRowCount}" class="mobile form-control" type="text" name="expected_origins[]" value="">
                                                            </td>
                                    <td>
                                        <button class="mobile btn btn-danger del-row" alt="${addDeviceRowCount}" type="button" name="button">刪除</button>
                                    </td>
                                </tr>`;
                    $('#need-device tbody').append(newRow);
                } else {
                    alert('已達5筆最高新增上限');
                }
            });

            // Event delegation for dynamically added elements
            $('#need-device').on('click', '.del-row', function() {
                $(this).closest('tr').remove();
                addDeviceRowCount--;
            });


            var expectedDeviceRowCount = $('#expected-device tbody tr').length;
            $('#add_device_expected').click(function() {
                if (expectedDeviceRowCount < 5) {
                    expectedDeviceRowCount++;
                    var newRow = `<tr id="row-${expectedDeviceRowCount}">
                                    <td>
                                        <input id="pay_date-${expectedDeviceRowCount}" class="mobile form-control" type="text" name="improve_names[]" value="" required>
                                    </td>
                                    <td>
                                        <input id="department-${expectedDeviceRowCount}" class="mobile form-control" type="text" name="improve_focuss[]" value="" required>
                                    </td>
                                    <td>
                                        <input id="title-${expectedDeviceRowCount}" class="mobile form-control" type="text" name="improve_costs[]" value="" required>
                                    </td>
                                    <td>
                                        <input id="work_content-${expectedDeviceRowCount}" class="mobile form-control" type="text" name="improve_delegate_objects[]" value="" required>
                                    </td>
                                    <td>
                                        <button class="mobile btn btn-danger del-row" alt="${expectedDeviceRowCount}" type="button" name="button">刪除</button>
                                    </td>
                                </tr>`;
                    $('#expected-device tbody').append(newRow);
                } else {
                    alert('已達5筆最高新增上限');
                }
            });

            // Event delegation for dynamically added elements
            $('#expected-device').on('click', '.del-row', function() {
                $(this).closest('tr').remove();
                expectedDeviceRowCount--;
            });

            // var normcount = 1; // 用于跟踪当前添加的输入组数量

            // $('#add_norm').click(function(){
            //     if(normcount < 5) { // 检查是否已经添加了五个输入组
            //         normcount++; // 增加计数器
            //         var newInputGroup = $('<div class="col-md-2">' +
            //                             '    <div class="input-group">' +
            //                             '        <input type="text" class="form-control" id="norm' + normcount + ' " placeholder="公司指標客戶'+normcount+'">' +
            //                             '        <button class="btn btn-sm btn-secondary norm_del" type="button">－</button>' +
            //                             '    </div>' +
            //                             '</div>');
            //         $(this).closest('.form-group').before(newInputGroup); // 在当前元素之前添加新输入组
            //     }
            // });

            // // 使用事件委托处理动态添加的元素
            // $(document).on('click', '.norm_del', function(){
            //     $(this).closest('.col-md-2').remove(); // 移除最近的.col-md-2元素
            //     normcount--; // 减少计数器
            // });

            
        </script>
@endsection
