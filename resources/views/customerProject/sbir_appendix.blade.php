@extends('layouts.vertical', ['title' => 'SBIR附件'])

@section('content')
    <style>
        textarea {
            white-space: pre;
        }
    </style>
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', [
            'title' => $project->user_data->name,
            'subtitle' => '專案瀏覽',
        ])

        <div class="row">
            <form
                action="{{ route('project.appendix.update', \App\Services\EncryptionService::encryptProjectId($project->id)) }}"
                method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-12 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <!--選單-->
                                        <ul class="nav nav-tabs">
                                            {{-- <li class="nav-item">
                                                <a href="{{ route('project.sbir01', \App\Services\EncryptionService::encryptProjectId($project->id)) }}" class="nav-link ">
                                                    壹、計畫書基本資料
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir02', \App\Services\EncryptionService::encryptProjectId($project->id)) }}" class="nav-link ">
                                                    貳、計畫申請表
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir03', \App\Services\EncryptionService::encryptProjectId($project->id)) }}" class="nav-link ">
                                                    參、計畫摘要表
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir04', \App\Services\EncryptionService::encryptProjectId($project->id)) }}" class="nav-link">
                                                    肆、公司概況
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir05', \App\Services\EncryptionService::encryptProjectId($project->id)) }}" class="nav-link">
                                                    伍、研發動機
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir06', \App\Services\EncryptionService::encryptProjectId($project->id)) }}" class="nav-link">
                                                    陸、計畫目標
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir07', \App\Services\EncryptionService::encryptProjectId($project->id)) }}" class="nav-link">
                                                    柒、實施方式
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir08', \App\Services\EncryptionService::encryptProjectId($project->id)) }}" class="nav-link">
                                                    捌、智財分析
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir09', \App\Services\EncryptionService::encryptProjectId($project->id)) }}" class="nav-link">
                                                    玖、計畫執行查核點說明
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir10', \App\Services\EncryptionService::encryptProjectId($project->id)) }}" class="nav-link">
                                                    拾、經費需求
                                                </a>
                                            </li> --}}
                                            <li class="nav-item">
                                                <a href="{{ route('customer.project.sbir.appendix', \App\Services\EncryptionService::encryptProjectId($project->id)) }}"
                                                    class="nav-link active">
                                                    附件確認
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('customer.project.supplement', \App\Services\EncryptionService::encryptProjectId($project->id)) }}"
                                                    class="nav-link">
                                                    補充資料填寫
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="card-body mt-3">
                                            <div class="alert alert-primary" role="alert">
                                                <label class="form-label" for="AddNew-Username"><b>1.資料範本參考：
                                                        <a href="{{ $cust_data->nas_link ?? '#' }}" target="_blank">
                                                            請點擊我
                                                        </a></b>
                                                </label><br>
                                                <label class="form-label" for="AddNew-Username"><b>2.上傳附件連結：
                                                        <a href="{{ $cust_data->nas_link ?? '#' }}" target="_blank">
                                                            請點擊我
                                                        </a></b>
                                                </label>
                                            </div>
                                            @if (isset($appendix->comment))
                                                <div class="row">
                                                    <label class="form-label">備註</label>
                                                    <div class="mb-3 mt-1">
                                                        <textarea class="form-control" rows="5" placeholder="" name="comment" readonly>{{ $appendix->comment }}</textarea>
                                                    </div>
                                                    <div class="text-end">
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="bx bx-save me-1"></i>儲存
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="row">
                                                <div class="col-md-12 ">
                                                    <div class="text-center mb-3">
                                                        <h2>送件階段-檢附資料</h2>
                                                    </div>

                                                    <div class="table-responsive">
                                                        <table class="table table-nowrap align-middle mb-0">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="width: 40px;">
                                                                        <div class="form-check font-size-16">
                                                                            <input class="form-check-input" type="checkbox"
                                                                                id="sbir_appendix01" name="sbir_appendix01">
                                                                            <label class="form-check-label"
                                                                                for="sbir_appendix01">
                                                                                <h5 class="font-size-16 m-0">
                                                                                    1.最近一年之年度損益及稅額計算表
                                                                                </h5>
                                                                            </label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 40px;">
                                                                        <div class="form-check font-size-16">
                                                                            <input class="form-check-input" type="checkbox"
                                                                                id="sbir_appendix02" name="sbir_appendix02">
                                                                            <label class="form-check-label"
                                                                                for="sbir_appendix02">
                                                                                <h5 class="font-size-16 m-0">
                                                                                    2.當年度的暫結損益表<span
                                                                                        class="text-danger">（可不用上傳）</span>
                                                                                </h5>
                                                                            </label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 40px;">
                                                                        <div class="form-check font-size-16">
                                                                            <input class="form-check-input" type="checkbox"
                                                                                id="sbir_appendix03" name="sbir_appendix03">
                                                                            <label class="form-check-label"
                                                                                for="sbir_appendix03">
                                                                                <h5 class="font-size-16 m-0">
                                                                                    3.最近一期勞保繳費清單之投保人數資料
                                                                                </h5>
                                                                            </label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 40px;">
                                                                        <div class="form-check font-size-16">
                                                                            <input class="form-check-input" type="checkbox"
                                                                                id="sbir_appendix04" name="sbir_appendix04">
                                                                            <label class="form-check-label"
                                                                                for="sbir_appendix04">
                                                                                <h5 class="font-size-16 m-0">4.最近 1
                                                                                    個月國稅局無違章欠稅證明
                                                                                </h5>
                                                                            </label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 40px;">
                                                                        <div class="form-check font-size-16">
                                                                            <input class="form-check-input" type="checkbox"
                                                                                id="sbir_appendix05" name="sbir_appendix05">
                                                                            <label class="form-check-label"
                                                                                for="sbir_appendix05">
                                                                                <h5 class="font-size-16 m-0">5.最近 1
                                                                                    個月稅捐稽徵處無違章欠稅證明
                                                                                </h5>
                                                                            </label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 40px;">
                                                                        <div class="form-check font-size-16">
                                                                            <input class="form-check-input" type="checkbox"
                                                                                id="sbir_appendix06" name="sbir_appendix06">
                                                                            <label class="form-check-label"
                                                                                for="sbir_appendix06">
                                                                                <h5 class="font-size-16 m-0">6.個資同意書正本<span
                                                                                        class="text-danger">（每位計畫人員皆要）</span>
                                                                                </h5>
                                                                            </label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 40px;">
                                                                        <div class="form-check font-size-16">
                                                                            <input class="form-check-input"
                                                                                type="checkbox" id="sbir_appendix07"
                                                                                name="sbir_appendix07">
                                                                            <label class="form-check-label"
                                                                                for="sbir_appendix07">
                                                                                <h5 class="font-size-16 m-0">7.計畫申請表
                                                                                </h5>
                                                                            </label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 40px;">
                                                                        <div class="form-check font-size-16">
                                                                            <input class="form-check-input"
                                                                                type="checkbox" id="sbir_appendix08"
                                                                                name="sbir_appendix08">
                                                                            <label class="form-check-label"
                                                                                for="sbir_appendix08">
                                                                                <h5 class="font-size-16 m-0">8.申請公司基本資料表
                                                                                </h5>
                                                                            </label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 40px;">
                                                                        <div class="form-check font-size-16">
                                                                            <input class="form-check-input"
                                                                                type="checkbox" id="sbir_appendix09"
                                                                                name="sbir_appendix09">
                                                                            <label class="form-check-label"
                                                                                for="sbir_appendix09">
                                                                                <h5 class="font-size-16 m-0">9.建議迴避之人員清單
                                                                                </h5>
                                                                            </label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 40px;">
                                                                        <div class="form-check font-size-16">
                                                                            <input class="form-check-input"
                                                                                type="checkbox" id="sbir_appendix10"
                                                                                name="sbir_appendix10">
                                                                            <label class="form-check-label"
                                                                                for="sbir_appendix10">
                                                                                <h5 class="font-size-16 m-0">
                                                                                    10.曾執行政府計畫揭露聲明書正本 1 份
                                                                                </h5>
                                                                            </label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 40px;">
                                                                        <div class="form-check font-size-16">
                                                                            <input class="form-check-input"
                                                                                type="checkbox" id="sbir_appendix11"
                                                                                name="sbir_appendix11">
                                                                            <label class="form-check-label"
                                                                                for="sbir_appendix11">
                                                                                <h5 class="font-size-16 m-0">11.申請者自我檢查表
                                                                                </h5>
                                                                            </label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 40px;">
                                                                        <div class="form-check font-size-16">
                                                                            <input class="form-check-input"
                                                                                type="checkbox" id="sbir_appendix12"
                                                                                name="sbir_appendix12">
                                                                            <label class="form-check-label"
                                                                                for="sbir_appendix12">
                                                                                <h5 class="font-size-16 m-0">12.合作意向書
                                                                                </h5>
                                                                            </label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-12 mb-4">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-md-12 mt-3">
                                                                            <div class="text-center mb-3">
                                                                                <h2>提案階段-檢附資料</h2>
                                                                            </div>


                                                                            <div class="table-responsive">
                                                                                <table
                                                                                    class="table table-nowrap align-middle mb-0">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td style="width: 40px;">
                                                                                                <div
                                                                                                    class="form-check font-size-16">
                                                                                                    <input
                                                                                                        class="form-check-input"
                                                                                                        type="checkbox"
                                                                                                        id="sbir_two_appendix01"
                                                                                                        name="sbir_two_appendix01">
                                                                                                    <label
                                                                                                        class="form-check-label"
                                                                                                        for="sbir_two_appendix01">
                                                                                                        <h5
                                                                                                            class="font-size-16 m-0">
                                                                                                            1.最新一期勞保投保名細
                                                                                                        </h5>
                                                                                                    </label>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td style="width: 40px;">
                                                                                                <div
                                                                                                    class="form-check font-size-16">
                                                                                                    <input
                                                                                                        class="form-check-input"
                                                                                                        type="checkbox"
                                                                                                        id="sbir_two_appendix02"
                                                                                                        name="sbir_two_appendix02">
                                                                                                    <label
                                                                                                        class="form-check-label"
                                                                                                        for="sbir_two_appendix02">
                                                                                                        <h5
                                                                                                            class="text-truncate font-size-16 m-0">
                                                                                                            2.簽到表
                                                                                                        </h5>
                                                                                                    </label>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td style="width: 40px;">
                                                                                                <div
                                                                                                    class="form-check font-size-16">
                                                                                                    <input
                                                                                                        class="form-check-input"
                                                                                                        type="checkbox"
                                                                                                        id="sbir_two_appendix03"
                                                                                                        name="sbir_two_appendix03">
                                                                                                    <label
                                                                                                        class="form-check-label"
                                                                                                        for="sbir_two_appendix03">
                                                                                                        <h5
                                                                                                            class="text-truncate font-size-16 m-0">
                                                                                                            3.問卷
                                                                                                        </h5>
                                                                                                    </label>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div> <!-- container -->
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/js/twzipcode-1.4.1-min.js') }}"></script>

    <script>
        $(document).ready(function() {
            var checkboxesStatus = {!! $checkboxesStatus ?? '{}' !!}; // 轉換為 JavaScript 變數
            var project_id = {!! $project->id !!};

            $.each(checkboxesStatus, function(key, value) {
                if (value === "1") {
                    $('#' + key).prop('checked', true);
                } else {
                    $('#' + key).prop('checked', false);
                }
            });

            $('.form-check-input').change(function() {
                var checkboxId = $(this).attr('id');
                var isChecked = $(this).is(':checked') ? 1 : 0;
                console.log(project_id);
                // var project_id = 
                $.ajax({
                    url: '{{ route('appendix-status') }}', // Laravel 路由 URL
                    type: 'POST',
                    data: {
                        id: checkboxId,
                        status: isChecked,
                        project_id: project_id,
                        _token: '{{ csrf_token() }}' // CSRF token
                    },
                    success: function(response) {
                        console.log('Checkbox status updated successfully.');
                    },
                    error: function(error) {
                        console.error('Error updating checkbox status.');
                    }
                });
            });


        });
    </script>
@endsection
