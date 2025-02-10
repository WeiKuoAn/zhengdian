@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', [
            'title' => '商業類-預覽',
            'subtitle' => Auth::user()->name,
        ])
        <!--  successfully modal  -->
        <div class="row">
            <div class="col-lg-12">
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <h2>客戶基本資料</h2>
                            </div>
                            <div class="row">'
                                <div class="col-md-12">
                                    <div class="mb-4">
                                        <label class="form-label" for="AddNew-Username"><b>客戶名稱</b><span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control required-input"
                                            value="{{ $cust_data->user_data->name }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-4">
                                        <label class="form-label" for="AddNew-Username"><b>公司統編</b><span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control required-input" name="registration_no"
                                            value="{{ $cust_data->registration_no }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-4">
                                        <label class="form-label" for="AddNew-Phone"><b>去年整年度營業額（單位：元/新台幣）</b><span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control required-input" name="last_year_revenue"
                                            @if (isset($project)) value="{{ $cust_data->last_year_revenue }}" @else value="0" @endif>
                                    </div>
                                </div>
                                <!-- 公司登記地址 -->
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">公司登記地址<span class="text-danger">*</span></label>
                                        <div>
                                            <div class="col-3 d-inline-block">
                                                <select id="company_county" name="county" class="form-select col-4">
                                                    <option value="">請選擇縣市</option>
                                                </select>
                                            </div>
                                            <div class="col-3 d-inline-block">
                                                <select id="company_district" name="district" class="form-select col-4">
                                                    <option value="">請選擇區域</option>
                                                </select>
                                            </div>
                                            <input type="hidden" id="company_zipcode" name="zipcode">
                                            <div class="col-4 d-inline-block">
                                                <input type="text" class="form-control" name="address" placeholder="輸入地址"
                                                    value="{{ $cust_data->address }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- 工廠登記地址 -->
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">工廠登記地址<span class="text-danger">*</span></label>
                                        <div>
                                            <div class="col-3 d-inline-block">
                                                <select id="factory_county" name="factory_county" class="form-select col-4">
                                                    <option value="">請選擇縣市</option>
                                                </select>
                                            </div>
                                            <div class="col-3 d-inline-block">
                                                <select id="factory_district" name="factory_district"
                                                    class="form-select col-4">
                                                    <option value="">請選擇區域</option>
                                                </select>
                                            </div>
                                            <input type="hidden" id="factory_zipcode" name="factory_zipcode">
                                            <div class="col-4 d-inline-block">
                                                <input type="text" class="form-control" name="factory_address"
                                                    placeholder="輸入地址" value="{{ $cust_data->factory_address }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <label class="form-label" for="AddNew-Phone"><b>近一年平均投保人數</b>（申請計畫使用）<span
                                        class="text-danger">*</span></label>
                                <div class="col-md-12">
                                    <div class="mb-4">
                                        <input type="number" class="form-control required-input number-input"
                                            name="Insured_employees" placeholder="近一年平均投保人數"
                                            @if (isset($project)) value="{{ $cust_data->insured_employees }}" @endif>
                                    </div>
                                </div>
                                <label class="form-label" for="AddNew-Phone"><b>最近一期勞保投保人數</b>（申請計畫使用）<span
                                        class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <label class="form-label" for="AddNew-Phone">男生投保人數<span
                                            class="text-danger">*</span></label>
                                    <div class="mb-4">
                                        <input type="number" class="form-control required-input number-input"
                                            name="insurance_male" id="insurance_male" placeholder="男生投保人數"
                                            @if (isset($project)) value="{{ $cust_data->insurance_male }}" @endif>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="AddNew-Phone">女生投保人數<span
                                            class="text-danger">*</span></label>
                                    <div class="mb-4">
                                        <input type="number" class="form-control required-input number-input"
                                            name="insurance_female" id="insurance_female" placeholder="女生投保人數"
                                            @if (isset($project)) value="{{ $cust_data->insurance_female }}" @endif>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="AddNew-Phone">總投保人數<span
                                            class="text-danger">*</span></label>
                                    <div class="mb-4">
                                        <input type="number" class="form-control required-input" placeholder="總投保人數"
                                            name="insurance_total" id="insurance_total"
                                            @if (isset($project)) value="{{ $cust_data->insurance_total }}" @endif
                                            readonly>
                                    </div>
                                </div>
                                <label class="form-label" for="AddNew-Username"><b>公司主要聯繫窗口</b>（用於與計畫窗口對接）<span
                                        class="text-danger">*</span></label>
                                <div class="col-md-2">
                                    <div class="mb-4">
                                        <input type="text" class="form-control required-input"
                                            name="main_contact_name" placeholder="姓名"
                                            @if (isset($project)) value="{{ $cust_data->contact_name }}" @endif>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-4">
                                        <input type="text" class="form-control required-input" name="main_contact_job"
                                            placeholder="職稱"
                                            @if (isset($project)) value="{{ $cust_data->contact_job }}" @endif>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-4">
                                        <input type="email" class="form-control required-input"
                                            name="main_contact_email" placeholder="信箱"
                                            @if (isset($project)) value="{{ $cust_data->contact_email }}" @endif>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-4">
                                        <input type="text" class="form-control required-input"
                                            name="main_contact_phone" placeholder="電話"
                                            @if (isset($project)) value="{{ $cust_data->contact_phone }}" @endif>
                                    </div>
                                </div>
                                <label class="form-label" for="AddNew-Username"><b>提供一組全新的gmail帳號密碼</b><span
                                        class="text-danger">（供計畫做為聯絡信箱使用，計畫完整結案後，將歸還信箱使用權限）</span><span
                                        class="text-danger">*</span>
                                    <br>※若無未使用信箱帳號密碼，可申辦一組gmail信箱，用於收發計畫相關資料</label><br>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <input type="text" class="form-control required-input" name="receive_email"
                                            placeholder="信箱"
                                            @if (isset($cust_data)) value="{{ $cust_data->receive_email }}" @endif>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <input type="text" class="form-control required-input"
                                            name="receive_email_pwd" placeholder="密碼"
                                            @if (isset($cust_data)) value="{{ $cust_data->receive_email_pwd }}" @endif>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-md-12 font-size-18">
                                    <label class="form-label" for="AddNew-Username">&nbsp;</label>
                                    <input type="checkbox" class="form-check-input" name="customCheck1"
                                        id="customCheck1" value="{{ $cust_data->subsidy == '1' ? '1' : '0' }}"
                                        {{ $cust_data->subsidy == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="customCheck1"><span
                                            class="text-danger">有</span>申請其他政府機關之研發或升級轉型補助</label>
                                </div>
                                <div class="col-md-8 px-5 mb-4" id="customCheck1_div">
                                    @if ($cust_data->subsidy == '1')
                                        <div class="customCheck1_data row mt-2">
                                            <div class="table-responsive mt-1">
                                                <table id="customer" class="table customer-list">
                                                    <thead>
                                                        <tr align="center">
                                                            <th>年份<span class="text-danger">*</span></th>
                                                            <th>計畫名稱<span class="text-danger">*</span></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody valign="center" align="center">
                                                        @if (count($cust_data->manufacture_subsidy_datas) > 0)
                                                            @foreach ($cust_data->manufacture_subsidy_datas as $cust_data->manufacture_subsidy_data)
                                                                <tr valign="middle">
                                                                    <td>{{ $cust_data->manufacture_subsidy_data->year }}
                                                                    </td>
                                                                    <td>{{ $cust_data->manufacture_subsidy_data->name }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr valign="middle">
                                                                <td colspan="3">無資料</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div> <!-- end .table-responsive -->
                                        </div>
                                    @else
                                        <div class="customCheck1_data row">
                                            <div class="col-4">
                                                <input type="text" class="form-control" name="subsidy_years[]"
                                                    value="" placeholder="請提供年份">
                                            </div>
                                            <div class="col-4">
                                                <input type="text" class="form-control" name="subsidy_names[]"
                                                    value="" placeholder="請提供計畫名稱">
                                            </div>
                                        </div>
                                        <div class="customCheck1_container ">
                                            <!-- 這裡放置您原有的自定義檢查項目 HTML 程式碼 -->
                                        </div>
                                    @endif
                                </div>


                                <div class="col-md-12 font-size-18">
                                    <label class="form-label" for="AddNew-Username">&nbsp;</label>
                                    <input type="checkbox" class="form-check-input" name="customCheck2"
                                        id="customCheck2" value="{{ $cust_data->avoid == '1' ? '1' : '0' }}"
                                        {{ $cust_data->avoid == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="customCheck2"><span
                                            class="text-danger">有</span>須於審查階段迴避之人員</label>
                                </div>
                                <div class="row px-5" id="customCheck2_div">
                                    @if ($cust_data->avoid == '1')
                                        @if (isset($cust_data->manufacture_avoid_data))
                                            <div class="table-responsive mt-1 col-md-8">
                                                <table id="customer" class="table customer-list">
                                                    <thead>
                                                        <tr align="center">
                                                            <th>單位<span class="text-danger">*</span></th>
                                                            <th>職稱<span class="text-danger">*</span></th>
                                                            <th>姓名<span class="text-danger">*</span></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody valign="center" align="center">
                                                        <tr valign="middle">
                                                            <td>{{ $cust_data->manufacture_avoid_data->department }}
                                                            </td>
                                                            <td>{{ $cust_data->manufacture_avoid_data->job }}</td>
                                                            <td>{{ $cust_data->manufacture_avoid_data->name }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div> <!-- end .table-responsive -->
                                        @endif
                                    @else
                                        <div class="col-md-2">
                                            <input type="text" class="form-control" name="avoid_department"
                                                value="" placeholder="單位">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control" name="avoid_job" value=""
                                                placeholder="職稱">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control" name="avoid_name" value=""
                                                placeholder="姓名">
                                        </div>
                                    @endif
                                </div>

                                <hr class="mt-3">
                                <div class="col-md-12 row mt-3 appendix">
                                    <label for="example-search-input"
                                        class="col-form-label"><b>附件上傳</b>（EX：公司介紹、產品簡報）<span
                                            class="text-danger">*</span></label>
                                    <div class="pl-5">
                                        <div class="pl-5">
                                            上傳網址： <a href="{{ $cust_data->nas_link }}">{{ $cust_data->nas_link }}</a>
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
                                <h2>公司簡介</h2>
                                <p class="font-size-18">申請計畫使用<span class="text-danger">*</span></p>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-4">
                                        <label class="form-label" for="AddNew-Phone"><b>公司基本介紹</b><span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control required-input" name="introduce" rows="4">
@if (isset($cust_data))
{{ $cust_data->introduce }}
@endif
</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-4">
                                        <label class="form-label" for="AddNew-Phone"><b>產品製程圖</b><span
                                                class="text-danger">*</span></label>
                                        <div class="col-md-12 appendix">
                                            <div class="pl-5">
                                                上傳網址： <a href="{{ $cust_data->nas_link }}">{{ $cust_data->nas_link }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-4">
                                        <label class="form-label"
                                            for="AddNew-Phone"><b>主要客戶與市場</b>(如過往公司有介紹簡報有提到相關內容也可提供)<span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control required-input" name="clients_market" rows="4">{{ $cust_data->clients_market }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-4">
                                        <label class="form-label" for="AddNew-Phone"><b>公司產品出口情形/比例</b><span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control required-input" name="export_status" rows="4">{{ $cust_data->export_status }}</textarea>
                                    </div>
                                </div>
                                <div>
                                    <label class="form-label" for="AddNew-Phone"><b>前三年營收</b><span
                                            class="text-danger">*</span></label>
                                </div>
                                @if (count($cust_data->manufacture_income_datas) > 0)
                                    @foreach ($cust_data->manufacture_income_datas as $cust_data->manufacture_income_data)
                                        <div class="col-md-4">
                                            <label class="form-label"
                                                for="AddNew-Phone"><b>{{ $cust_data->manufacture_income_data->year }}年度</b><span
                                                    class="text-danger">*</span></label>
                                            <input type="hidden" class="form-control" name="three_years[]"
                                                value="{{ $cust_data->manufacture_income_data->year }}">
                                            <input type="number" class="form-control" name="three_incomes[]"
                                                value="{{ $cust_data->manufacture_income_data->income }}">
                                        </div>
                                    @endforeach
                                @else
                                    @foreach ($years as $year)
                                        <div class="col-md-4">
                                            <label class="form-label"
                                                for="AddNew-Phone"><b>{{ $year }}年度</b><span
                                                    class="text-danger">*</span></label>
                                            <input type="hidden" class="form-control" name="three_years[]"
                                                value="{{ $year }}">
                                            <input type="number" class="form-control" name="three_incomes[]"
                                                value="" placeholder="{{ $year }}年">
                                        </div>
                                    @endforeach
                                @endif


                                <hr class="mt-4 mb-4">
                                <label class="form-label" for="AddNew-Username"><b>公司指標客戶（請列舉3-5家）</b><span
                                        class="text-danger">*</span></label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive mt-1">
                                            <table id="customer" class="table customer-list">
                                                <thead>
                                                    <tr align="center">
                                                        <th>編號</th>
                                                        <th>公司指標客戶<span class="text-danger">*</span></th>
                                                        <th>指標客戶服務<span class="text-danger">*</span></th>
                                                    </tr>
                                                </thead>
                                                <tbody valign="center" align="center">
                                                    @if (count($cust_data->manufacture_norm_datas) > 0)
                                                        @foreach ($cust_data->manufacture_norm_datas as $key => $manufacture_norm_data)
                                                            <tr id="row-{{ $key }}" valign="middle">
                                                                <td>{{ $key + 1 }}</td>
                                                                <td>
                                                                    {{ $manufacture_norm_data->name }}
                                                                </td>
                                                                <td>
                                                                    {{ $manufacture_norm_data->context }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr valign="middle">
                                                            <td colspan="3">無資料</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div> <!-- end .table-responsive -->
                                    </div>
                                </div>
                                <hr class="mt-4 mb-4">

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h5 class="text-uppercase bg-light p-2 mt-0 mb-1">
                                                公司對外的網站或社群網址-若有不只一個，請都附上。若無，請寫「無」即可<span class="text-danger">*</span>
                                            </h5>
                                            <div class="table-responsive mt-1">
                                                <table id="socail" class="table socail-list">
                                                    <thead>
                                                        <tr align="center">
                                                            <th>編號</th>
                                                            <th>類別<span class="text-danger">*</span></th>
                                                            <th>網址<span class="text-danger">*</span></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody valign="center" align="center">
                                                        @if (count($cust_data->socail_datas) > 0)
                                                            @foreach ($cust_data->socail_datas as $key => $socail_data)
                                                                <tr id="row-{{ $key }}">
                                                                    <td>{{ $key + 1 }}</td>
                                                                    <td>
                                                                        @if ($socail_data->type == '0')
                                                                            網站
                                                                        @endif
                                                                        @if ($socail_data->type == '1')
                                                                            社群
                                                                        @endif
                                                                        @if ($socail_data->type == '2')
                                                                            其他
                                                                        @endif

                                                                    </td>
                                                                    <td>
                                                                        {{ $socail_data->context }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr valign="middle">
                                                                <td colspan="3">無資料</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div> <!-- end .table-responsive -->
                                        </div>
                                    </div>
                                </div>

                                <hr class="mt-4 mb-4">

                                <div class="col-md-12 font-size-18">
                                    <label class="form-label" for="AddNew-Username">&nbsp;</label>
                                    <input type="checkbox" class="form-check-input" name="carbonCheck" id="carbonCheck"
                                        value="{{ $cust_data->carbon_done == '1' ? '1' : '0' }}"
                                        {{ $cust_data->carbon_done == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="carbonCheck">是否做過碳盤查？</label>
                                    @if ($cust_data->carbon_done == '0')
                                        <span class="text-danger"
                                            id="carbonCheck_text"> </span>
                                    @elseif($cust_data->carbon_done == '1')
                                        <span class="text-danger" id="carbonCheck_text">※是，請提供碳排查報告</span>
                                    @endif
                                </div>

                                <div class="col-md-12 font-size-18">
                                    <label class="form-label" for="AddNew-Username">&nbsp;</label>
                                    <input type="checkbox" class="form-check-input" name="checkIso" id="checkIso"
                                        value="{{ $cust_data->carbon_iso == '1' ? '1' : '0' }}"
                                        {{ $cust_data->carbon_iso == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="checkIso">是否有已申請過的ISO或是目前正在申請的ISO資訊？</label>
                                </div>
                                <div class="checkIso_div px-5">
                                    @if ($cust_data->carbon_iso == '1')
                                        <div class="table-responsive mt-1 col-md-8">
                                            <table id="customer" class="table customer-list">
                                                <thead>
                                                    <tr align="center">
                                                        <th>ISO名稱<span class="text-danger">*</span></th>
                                                        <th>年份<span class="text-danger">*</span></th>
                                                        <th>狀態<span class="text-danger">*</span></th>
                                                    </tr>
                                                </thead>
                                                <tbody valign="center" align="center">
                                                    @if (count($cust_data->manufacture_iso_datas) > 0)
                                                        @foreach ($cust_data->manufacture_iso_datas as $manufacture_iso_data)
                                                            <tr valign="middle">
                                                                <td>{{ $manufacture_iso_data->name }}</td>
                                                                <td>{{ $manufacture_iso_data->year }}</td>
                                                                <td>
                                                                    @if ($manufacture_iso_data->status = '0')
                                                                        已通過
                                                                    @endif
                                                                    @if ($manufacture_iso_data->status = '1')
                                                                        申請中
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr valign="middle">
                                                            <td colspan="3">無資料</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        @for ($i = 0; $i < 1; $i++)
                                            <div class="row  mt-2">
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control" name="iso_names[]"
                                                        value="" placeholder="ISO名稱">
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control" name="iso_years[]"
                                                        value="" placeholder="年份">
                                                </div>
                                                <div class="col-md-2">
                                                    <select class="form-select" name="iso_status[]">
                                                        <option value="" selected>選擇狀態</option>
                                                        <option value="0">已通過</option>
                                                        <option value="1">申請中</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <button class="mobile btn btn-danger del-row" alt=""
                                                        type="button" name="button" onclick="del_row(this)">刪除</button>
                                                </div>
                                            </div>
                                        @endfor
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
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
                                    <label class="form-label" for="AddNew-Username"><b>專長/經歷</b></label>
                                    <input type="text" class="form-control required-input" name="host_experience"
                                        @if (isset($project_host_data)) value="{{ $project_host_data->experience }}" @endif>
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
                                    <input type="text" class="form-control required-input" name="contact_department"
                                        @if (isset($project_contact_data)) value="{{ $project_contact_data->department }}" @endif>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="AddNew-Username"><b>職稱</b></label>
                                    <input type="text" class="form-control required-input" name="contact_job"
                                        @if (isset($project_contact_data)) value="{{ $project_contact_data->job }}" @endif>
                                </div>
                                <div class="col-md-4 mt-3">
                                    <label class="form-label" for="AddNew-Username"><b>工作內容</b></label>
                                    <input type="text" class="form-control required-input" name="contact_context"
                                        @if (isset($project_contact_data)) value="{{ $project_contact_data->context }}" @endif>
                                </div>
                                <div class="col-md-4 mt-3">
                                    <label class="form-label" for="AddNew-Username"><b>專長/經歷</b></label>
                                    <input type="text" class="form-control required-input" name="contact_experience"
                                        @if (isset($project_contact_data)) value="{{ $project_contact_data->experience }}" @endif>
                                </div>
                                <div class="col-md-4 mt-3">
                                    <label class="form-label" for="AddNew-Username"><b>電話(含分機)</b></label>
                                    <input type="text" class="form-control required-input" name="contact_mobile"
                                        @if (isset($project_contact_data)) value="{{ $project_contact_data->mobile }}" @endif>
                                </div>
                                <div class="col-md-4 mt-3">
                                    <label class="form-label" for="AddNew-Username"><b>手機</b></label>
                                    <input type="text" class="form-control required-input" name="contact_phone"
                                        @if (isset($project_contact_data)) value="{{ $project_contact_data->phone }}" @endif>
                                </div>

                                <div class="col-md-4 mt-3">
                                    <label class="form-label" for="AddNew-Username"><b>信箱</b></label>
                                    <input type="text" class="form-control required-input" name="contact_email"
                                        @if (isset($project_contact_data)) value="{{ $project_contact_data->email }}" @endif>
                                </div>
                                <div class="col-md-4 mt-3">
                                    <label class="form-label" for="AddNew-Username"><b>實際薪資</b></label>
                                    <input type="text" class="form-control required-input" name="contact_salary"
                                        @if (isset($project_contact_data)) value="{{ $project_contact_data->salary }}" @endif>
                                </div>

                                <hr class="mt-4 mb-4">

                                <div class="col-md-12 mt-3">
                                    <h5 class="text-uppercase bg-light p-2 mt-0 mb-3">人事名單（約4-6位-皆須在勞保投保明細中）<span
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
                                                            <th>專長經歷<span class="text-danger">*</span></th>
                                                            <th>實際薪資<span class="text-danger">*</span></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody valign="center" align="center">
                                                        @if (count($project->personnel_datas) > 0)
                                                            @foreach ($project->personnel_datas as $key => $personnel_data)
                                                                <tr id="row-{{ $key }}">
                                                                    <td>{{ $key + 1 }}</td>
                                                                    <td>
                                                                        {{ $personnel_data->name }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $personnel_data->department }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $personnel_data->job }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $personnel_data->context }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $personnel_data->experience }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $personnel_data->salary }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr valign="middle">
                                                                <td colspan="7">無資料</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div> <!-- end .table-responsive -->
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
                                        公司現在原有的系統或設備（有在財產清冊裡的設備即可）有哪些？哪一些設備已使用10-15年？<br>
                                        當初向哪家客戶購入請簡述（ex：空壓機、冷凍機、採購系統、ERP企業資源計劃系統、MES執行系統...等）<br>
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

                                {{-- <hr>
    
                                    <h5 class="text-uppercase bg-light p-2 mt-4 mb-3">預計購買新設備等設備資訊列表（若無請填「無」）</h5>
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table id="need-device" class="table need-device-list">
                                                    <thead>
                                                        <tr align="center">
                                                            <th>設備名稱<span class="text-danger">*</span></th>
                                                            <th>設備品牌</th>
                                                            <th>設備型號</th>
                                                            <th>用途/規格</th>
                                                            <th>費用</th>
                                                            <th>採購對象</th>
                                                            <th>產地</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody valign="center" align="center">
                                                        @if (count($project->manufacture_expected_datas) > 0)
                                                            @foreach ($project->manufacture_expected_datas as $key => $manufacture_expected_data)
                                                                <tr id="row-{{ $key }}" valign="middle" >
                                                                    <td>
                                                                        {{ $manufacture_expected_data->name }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $manufacture_expected_data->brand }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $manufacture_expected_data->model }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $manufacture_expected_data->purpose }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $manufacture_expected_data->cost }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $manufacture_expected_data->procurement }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $manufacture_expected_data->origin }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr valign="middle" >
                                                                <td colspan="7">無資料</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            </div> <!-- end .table-responsive -->
                                        </div>
    
                                        <hr>
    
                                    <h5 class="text-uppercase bg-light p-2 mt-4 mb-3">預計改善設備等設備資訊（若無請填「無」）</h5>
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table id="expected-device" class="table expected-device-list">
                                                    <thead>
                                                        <tr align="center">
                                                            <th>設備名稱<span class="text-danger">*</span></th>
                                                            <th>改善重點</th>
                                                            <th>費用</th>
                                                            <th>委託對象</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody valign="center" align="center">
                                                        @if (count($project->manufacture_improve_datas) > 0)
                                                            @foreach ($project->manufacture_improve_datas as $key => $manufacture_improve_data)
                                                                <tr id="row-{{ $key }}" >
                                                                    <td>
                                                                        {{ $manufacture_improve_data->name }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $manufacture_improve_data->focus }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $manufacture_improve_data->cost }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $manufacture_improve_data->delegate_object }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr valign="middle" >
                                                                <td colspan="4">無資料</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            </div> <!-- end .table-responsive -->
                                        </div> 
    
                                    </div> --}}


                            </div>

                        </div>
                    </div>
                    <div class="row mt-4 mb-2 d-print-none">
                        <div class="col text-center">
                            <button type="button" class="btn btn-danger me-1" onclick="history.go(-1)"><i
                                    class="bx bx-x me-1"></i> 回上一頁</button>
                            <a href="javascript:window.print()" class="btn btn-success me-1"><i
                                    class="fa fa-print me-1"></i>列印</a>
                            {{-- <a href="{{ route('project.business.appendix') }}">
                                    <button class="btn btn-primary" type="button" id="btn_submit"><i class=" bx bx-check me-1"></i> 確認送出 </button>
                                </a> --}}
                        </div> <!-- end col -->
                    </div>
                    </form>
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
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // 讀取 JSON 檔案
                fetch("/json/city.json") // 👈 確保路徑正確，符合你的 public 資料夾位置
                    .then(response => response.json())
                    .then(jsonData => {
                        function populateCounties(selectElement, selectedCounty) {
                            selectElement.innerHTML = '<option value="">請選擇縣市</option>';
                            jsonData.forEach(city => {
                                let option = document.createElement("option");
                                option.value = city.CityName;
                                option.textContent = city.CityName;
                                if (selectedCounty && city.CityName === selectedCounty) {
                                    option.selected = true;
                                }
                                selectElement.appendChild(option);
                            });
                        }

                        function populateDistricts(countySelect, districtSelect, zipcodeInput, selectedDistrict) {
                            let selectedCounty = countySelect.value;
                            districtSelect.innerHTML = '<option value="">請選擇區域</option>';

                            let cityData = jsonData.find(city => city.CityName === selectedCounty);
                            if (cityData) {
                                cityData.AreaList.forEach(area => {
                                    let option = document.createElement("option");
                                    option.value = area.AreaName;
                                    option.textContent = area.AreaName;
                                    if (selectedDistrict && area.AreaName === selectedDistrict) {
                                        option.selected = true;
                                        zipcodeInput.value = area.ZipCode;
                                    }
                                    districtSelect.appendChild(option);
                                });
                            }

                            // 當區域變更時，自動填充郵遞區號
                            districtSelect.addEventListener("change", function() {
                                let selectedDistrict = districtSelect.value;
                                let areaData = cityData.AreaList.find(area => area.AreaName ===
                                    selectedDistrict);
                                zipcodeInput.value = areaData ? areaData.ZipCode : "";
                            });
                        }

                        function setupCountyDistrict(countyId, districtId, zipcodeId, selectedCounty,
                            selectedDistrict) {
                            let countySelect = document.getElementById(countyId);
                            let districtSelect = document.getElementById(districtId);
                            let zipcodeInput = document.getElementById(zipcodeId);

                            // 填充縣市選單
                            populateCounties(countySelect, selectedCounty);

                            // 如果已經有選定的縣市，則加載區域
                            if (selectedCounty) {
                                populateDistricts(countySelect, districtSelect, zipcodeInput, selectedDistrict);
                            }

                            // 當縣市變更時，載入對應區域
                            countySelect.addEventListener("change", function() {
                                populateDistricts(countySelect, districtSelect, zipcodeInput, "");
                            });
                        }

                        // ✅ 設定「公司登記地址」
                        setupCountyDistrict(
                            "company_county",
                            "company_district",
                            "company_zipcode",
                            "{{ $cust_data->county }}",
                            "{{ $cust_data->district }}"
                        );

                        // ✅ 設定「工廠登記地址」
                        setupCountyDistrict(
                            "factory_county",
                            "factory_district",
                            "factory_zipcode",
                            "{{ $cust_data->factory_county }}",
                            "{{ $cust_data->factory_district }}"
                        );

                        console.log("✅ 縣市區域選單載入完成！");
                    })
                    .catch(error => console.error("❌ 無法載入 JSON:", error));
            });
        </script>
        <script>
            $(document).ready(function() {
                $(".twzipcode").twzipcode({
                    css: ["twzipcode-select", "twzipcode-select", "twzipcode-select"], // 自訂 "城市"、"地區" class 名稱 
                    countyName: "county", // 自訂城市 select 標籤的 name 值
                    districtName: "district", // 自訂地區 select 標籤的 name 值
                    zipcodeName: "zipcode", // 自訂地區 select 標籤的 name 值
                    'countySel': '{{ $cust_data->county }}',
                    'districtSel': '{{ $cust_data->district }}',
                    'zipcodeSel': '{{ $cust_data->zipcode }}'
                });

                $(".factorytwzipcode").twzipcode({
                    css: ["twzipcode-select", "twzipcode-select", "twzipcode-select"], // 自訂 "城市"、"地區" class 名稱 
                    countyName: "factory_county", // 自訂城市 select 標籤的 name 值
                    districtName: "factory_district", // 自訂地區 select 標籤的 name 值
                    zipcodeName: "factory_zipcode", // 自訂地區 select 標籤的 name 值
                    'countySel': '{{ $cust_data->factory_county }}',
                    'districtSel': '{{ $cust_data->factory_district }}',
                    'zipcodeSel': '{{ $cust_data->factory_zipcode }}'
                });

                @if (session('success'))
                    $('#success-btn').modal('show');
                @endif
            });



            $(document).ready(function() {
                $("#customCheck1_div").hide();
                $("#customCheck2_div").hide();
                $(".checkIso_div").hide();
                $("#CheckNeed_div").hide();


                if ($("#customCheck1").is(':checked')) {
                    // 如果被選中，顯示 #customCheck1_div
                    $("#customCheck1_div").show(300);
                } else {
                    // 否則隱藏 #customCheck1_div
                    $("#customCheck1_div").hide();
                }

                $("#customCheck1").on("change", function() {
                    // 首先，將 checkbox 的值設置為 0
                    $("#customCheck1").val(0);

                    // 檢查 checkbox 是否被選中
                    if ($("#customCheck1").is(':checked')) {
                        // 如果被選中，顯示相關的 HTML 元素並將值改為 1
                        $("#customCheck1_div").show(300);
                        $("#customCheck1").val(1);
                    } else {
                        // 如果未被選中，隱藏相關的 HTML 元素
                        $("#customCheck1_div").hide(300);
                    }
                });



                if ($("#customCheck2").is(':checked')) {
                    // 如果被選中，顯示 #customCheck1_div
                    $("#customCheck2_div").show(300);
                } else {
                    // 否則隱藏 #customCheck1_div
                    $("#customCheck2_div").hide();
                }

                $("#customCheck2").on("change", function() {
                    if ($(this).is(':checked')) {
                        $("#customCheck2_div").show(300);
                        $(this).val(1);
                    } else {
                        $("#customCheck2_div").hide(300);
                    }
                });

                $("#carbonCheck").on("change", function() {
                    if ($(this).is(':checked')) {
                        $("#carbonCheck_text").html('※是，請提供碳排查報告');
                        $("#carbon_need_text").html('是 - 碳盤查報告書');
                        $(this).val(1);
                    } else {
                        $(this).val(0);
                        $("#carbonCheck_text").html(' ');
                        $("#carbon_need_text").html('否 - 油(柴油、汽油)、電(要注意一般用電或是其他用電)、水、天然氣費帳單是 - 碳盤查報告書');
                    }
                    console.log($(this).val());
                });

                if ($("#checkIso").is(':checked')) {
                    // 如果被選中，顯示 #customCheck1_div
                    $(".checkIso_div").show(300);
                } else {
                    // 否則隱藏 #customCheck1_div
                    $(".checkIso_div").hide();
                }

                var socailRowCount = $('#socail tbody tr').length;

                $('#add_socail').click(function() {
                    socailRowCount++;
                    var newRow = `<tr id="row-${socailRowCount}">
                                    <td>
                                        ${socailRowCount}
                                    </td>
                                    <td>
                                        <select id="gdpaper_id_${socailRowCount}" alt="${socailRowCount}" class="mobile form-select" name="socail_types[]">
                                            <option value="" selected>請選擇...</option>
                                            <option value="0">網站</option>
                                            <option value="1">社群</option>
                                            <option value="2">其他</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input id="department-${socailRowCount}" class="mobile form-control required-input" type="text" name="socail_contexts[]" value="" required>
                                    </td>
                                    <td>
                                        <button class="mobile btn btn-danger del-row" alt="${socailRowCount}" type="button" name="button">刪除</button>
                                    </td>
                                </tr>`;
                    $('#socail tbody').append(newRow);
                });

                // Event delegation for dynamically added elements
                $('#socail').on('click', '.del-row', function() {
                    $(this).closest('tr').remove();
                    socailRowCount--;
                });


                var presonRowCount = $('#preson tbody tr').length;

                $('#add_preson').click(function() {
                    presonRowCount++;
                    var newRow = `<tr id="row-${presonRowCount}" >
                                <td>${presonRowCount}</td>
                                <td>
                                    <input id="pay_date-${presonRowCount}" class="mobile form-control required-input" type="text" name="personnel_names[]" value="">
                                </td>
                                <td>
                                    <input id="pay_date-${presonRowCount}" class="mobile form-control required-input" type="text" name="personnel_departments[]" value="">
                                </td>
                                <td>
                                    <input id="pay_price-${presonRowCount}" class="mobile form-control required-input" type="text" name="personnel_jobs[]" value="">
                                </td>
                                <td>
                                    <input id="pay_price-${presonRowCount}" class="mobile form-control required-input" type="text" name="personnel_contexts[]" value="">
                                </td>
                                <td>
                                    <button class="mobile btn btn-danger del-row" alt="${presonRowCount}" type="button" name="button" onclick="del_row(this)">刪除</button>
                                </td>
                            </tr>`;
                    $('#preson tbody').append(newRow);
                });

                // Event delegation for dynamically added elements
                $('#preson').on('click', '.del-row', function() {
                    $(this).closest('tr').remove();
                    presonRowCount--;
                });
            });

            var branchRowCount = $('#branch tbody tr').length;

            $('#add_branch').click(function() {
                branchRowCount++;
                var newRow = `<tr id="row-${branchRowCount}">
                            <td>
                                ${branchRowCount}
                            </td>
                            <td>
                                <input id="pay_date-${branchRowCount}" class="mobile form-control required-input" type="text" name="drive_names[]" value="" required>
                            </td>
                            <td>
                                <input id="department-${branchRowCount}" class="mobile form-control required-input" type="text" name="drive_numbers[]" value="" required>
                            </td>
                            <td>
                                <input id="title-${branchRowCount}" class="mobile form-control required-input" type="text" name="drive_principals[]" value="" required>
                            </td>
                            <td>
                                <input id="work_content-${branchRowCount}" class="mobile form-control required-input" type="text" name="drive_employeecounts[]" value="" required>
                            </td>
                            <td>
                                <button class="mobile btn btn-danger del-row" alt="${branchRowCount}" type="button" name="button">刪除</button>
                            </td>
                         </tr>`;
                $('#branch tbody').append(newRow);
            });

            // Event delegation for dynamically added elements
            $('#branch').on('click', '.del-row', function() {
                if (branchRowCount > 5) {
                    $(this).closest('tr').remove();
                    branchRowCount--;
                } else {
                    alert('需至少提供5家被帶動企業');
                }

            });

            var needRowCount = $('#need tbody tr').length;

            $('#add_need').click(function() {
                needRowCount++;
                var newRow = `<tr id="row-${needRowCount}">
                                <td>
                                    ${needRowCount}
                                </td>
                                <td>
                                    <input id="pay_date-${needRowCount}" class="mobile form-control required-input" type="text" name="need_names[]" value="">
                                </td>
                                <td>
                                    <input id="department-${needRowCount}" class="mobile form-control required-input" type="text" name="need_contexts[]" value="">
                                </td>
                                <td>
                                    <button class="mobile btn btn-danger del-row" alt="${needRowCount}" type="button" name="button">刪除</button>
                                </td>
                            </tr>`;
                $('#need tbody').append(newRow);
            });

            // Event delegation for dynamically added elements
            $('#need').on('click', '.del-row', function() {
                $(this).closest('tr').remove();
                needRowCount--;
            });

            var situationRowCount = $('#situation tbody tr').length;

            $('#add_situation').click(function() {
                situationRowCount++;
                var newRow = `<tr id="row-${situationRowCount}" valign="middle">
                                <td width="90%">
                                    <textarea  class="form-control required-input" name="situation_contexts[]" rows="2"></textarea>
                                </td>
                                <td>
                                    <button class="mobile btn btn-danger del-row" alt="${situationRowCount}" type="button" name="button">刪除</button>
                                </td>
                            </tr>`;
                $('#situation tbody').append(newRow);
                checkRequiredFields();
            });

            // Event delegation for dynamically added elements
            $('#situation').on('click', '.del-row', function() {
                $(this).closest('tr').remove();
                situationRowCount--;
            });

            function updateTotal() {
                var maleCount = parseInt($('#insurance_male').val()) || 0;
                var femaleCount = parseInt($('#insurance_female').val()) || 0;
                $('#insurance_total').val(maleCount + femaleCount);
            }

            // 為 insurance_male 和 insurance_female 欄位添加 change 事件監聽器
            $('#insurance_male, #insurance_female').on('change', function() {
                updateTotal();
            });
        </script>
    @endsection
