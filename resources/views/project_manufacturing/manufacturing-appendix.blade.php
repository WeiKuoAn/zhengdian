@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', [
            'title' => '製造類-附件',
            'subtitle' => Auth::user()->name,
        ])
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mt-3">
                                        <div class="text-center mb-3">
                                            <h2>第一階段檢附資料</h2>
                                        </div>
                                        <div class="alert alert-primary" role="alert">
                                            <label class="form-label" for="AddNew-Username"><b>上傳連結：
                                                    <a href="{{ $cust_data->nas_link }}" target="_blank">
                                                        請點擊我
                                                    </a></b>
                                            </label>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-nowrap align-middle mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 40px;">
                                                            <div class="form-check font-size-16">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="m_appendix01" name="m_appendix01">
                                                                <label class="form-check-label" for="m_appendix01">
                                                                    <h5 class="font-size-16 m-0">1.公司變更登記表</h5>
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 40px;">
                                                            <div class="form-check font-size-16">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="m_appendix02" name="m_appendix02">
                                                                <label class="form-check-label" for="m_appendix02">
                                                                    <h5 class="font-size-16 m-0">2.最近一年度稅務申報書</h5>
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 40px;">
                                                            <div class="form-check font-size-16">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="m_appendix03" name="m_appendix03">
                                                                <label class="form-check-label" for="m_appendix03">
                                                                    <h5 class="font-size-16 m-0">3.最近一年度資產負債表</h5>
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 40px;">
                                                            <div class="form-check font-size-16">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="m_appendix04" name="m_appendix04">
                                                                <label class="form-check-label" for="m_appendix04">
                                                                    <h5 class="font-size-16 m-0">4.最近一年度損益表</h5>
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 40px;">
                                                            <div class="form-check font-size-16">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="m_appendix05" name="m_appendix05">
                                                                <label class="form-check-label" for="m_appendix05">
                                                                    <h5 class="font-size-16 m-0">5.工廠登記證明文件</h5>
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 40px;">
                                                            <div class="form-check font-size-16">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="m_appendix06" name="m_appendix06">
                                                                <label class="form-check-label" for="m_appendix06">
                                                                    <h5 class="font-size-16 m-0">6.財產清冊(需確認設備資料)</h5>
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 40px;">
                                                            <div class="form-check font-size-16">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="m_appendix07" name="m_appendix07">
                                                                <label class="form-check-label" for="m_appendix07">
                                                                    <h5 class="font-size-16 m-0">7.最新的投保單位被保險人名冊</h5>
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 40px;">
                                                            <div class="form-check font-size-16">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="m_appendix08" name="m_appendix08">
                                                                <label class="form-check-label" for="m_appendix08">
                                                                    <h5 class="font-size-16 m-0">8.碳盤查報告(計劃書需要)<br>
                                                                        <ul style="line-height:30px;">
                                                                            <li>否 - 提供最近一年度全年度的
                                                                                <br><input class="form-check-input"
                                                                                    type="checkbox" id="carbon_appendix01"
                                                                                    name="carbon_appendix01">【１】油(柴油、汽油)公升數
                                                                                <br><input class="form-check-input"
                                                                                    type="checkbox" id="carbon_appendix02"
                                                                                    name="carbon_appendix02">【２】電費帳單(要注意一般用電或是其他用電)
                                                                                <br><input class="form-check-input"
                                                                                    type="checkbox" id="carbon_appendix03"
                                                                                    name="carbon_appendix03">【３】水費帳單
                                                                                <br><input class="form-check-input"
                                                                                    type="checkbox" id="carbon_appendix04"
                                                                                    name="carbon_appendix04">【４】天然氣費帳單公升數
                                                                                <br><input class="form-check-input"
                                                                                    type="checkbox" id="carbon_appendix05"
                                                                                    name="carbon_appendix05">【５】個別冷媒設備銘牌(如:冷氣、冰水機、飲水機，若無銘牌提供設備名稱、設備型號、數量)
                                                                                <a href="http://gofile.me/6XXhY/ja15jeTmc"
                                                                                    target="_blank">
                                                                                    （請點擊我下載空白冷媒碳盤查相關紀錄表）
                                                                                </a>
                                                                                <br><input class="form-check-input"
                                                                                    type="checkbox" id="carbon_appendix06"
                                                                                    name="carbon_appendix06">【６】前一年度每月員工人數（若無每月明細，請提供最多員工數量）
                                                                                <br><input class="form-check-input"
                                                                                    type="checkbox" id="carbon_appendix07"
                                                                                    name="carbon_appendix07">【７】製程設備使用燃料公升數，如：焊接、加熱製程
                                                                            </li>
                                                                            <li>是 - 碳盤查報告書</li>
                                                                        </ul>
                                                                    </h5>
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 40px;">
                                                            <div class="form-check font-size-16">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="m_appendix09" name="m_appendix09">
                                                                <label class="form-check-label" for="m_appendix09">
                                                                    <h5 class="font-size-16 m-0">9.如有通過ISO請提供ISO相關資料</h5>
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 40px;">
                                                            <div class="form-check font-size-16">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="m_appendix10" name="m_appendix10">
                                                                <label class="form-check-label" for="m_appendix10">
                                                                    <h5 class="font-size-16 m-0">10.如有申請公司銀行貸款，請提供銀行營運計畫書
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

        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mt-3">
                                        <div class="text-center mb-3">
                                            <h2>第二階段檢附資料(送件前須檢附完成)</h2>
                                        </div>
                                        <div class="alert alert-primary" role="alert">
                                            <label class="form-label" for="AddNew-Username">
                                                <b>上傳連結：
                                                    <a href="{{ $cust_data->nas_link }}" target="_blank">
                                                        請點擊我
                                                    </a>'
                                                </b>
                                            </label>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-nowrap align-middle mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 40px;">
                                                            <div class="form-check font-size-16">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="m_two_appendix01" name="m_two_appendix01">
                                                                <label class="form-check-label" for="m_two_appendix01">
                                                                    <h5 class="font-size-16 m-0">
                                                                        1.蒐集個人資料告知事項暨個人資料提供同意書<span
                                                                            class="text-danger">（一式兩份並正本簽名）</span>
                                                                        <a href="{{ URL::asset('downloads/製造業_個人資料提供同意書.pdf') }}"
                                                                            download="製造業_個人資料提供同意書.pdf">
                                                                            （請點擊我下載空白文件）
                                                                        </a>
                                                                    </h5>
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 40px;">
                                                            <div class="form-check font-size-16">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="m_two_appendix02" name="m_two_appendix02">
                                                                <label class="form-check-label" for="m_two_appendix02">
                                                                    <h5 class="font-size-16 m-0">
                                                                        2.建議迴避之人員清單（若無者請於表格中姓名欄中填【無】，另下方處需加蓋公司大小章。）
                                                                        <a href="{{ URL::asset('downloads/製造業_建議迴避之人員清單.pdf') }}"
                                                                            download="製造業_建議迴避之人員清單.pdf">
                                                                            （請點擊我下載空白文件）
                                                                        </a>
                                                                    </h5>
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 40px;">
                                                            <div class="form-check font-size-16">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="m_two_appendix03" name="m_two_appendix03">
                                                                <label class="form-check-label" for="m_two_appendix03">
                                                                    <h5 class="font-size-16 m-0">3.基本資料暨同意聲明
                                                                        <a href="{{ URL::asset('downloads/製造業_基本資料暨同意聲明.pdf') }}"
                                                                            download="製造業_基本資料暨同意聲明.pdf">
                                                                            （請點擊我下載空白文件）
                                                                        </a>
                                                                    </h5>
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 40px;">
                                                            <div class="form-check font-size-16">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="m_two_appendix04" name="m_two_appendix04">
                                                                <label class="form-check-label" for="m_two_appendix04">
                                                                    <h5 class="font-size-16 m-0">
                                                                        4.勞動部勞工保險局受理事業最近12個月平均月投保人數
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
    @endsection

    @section('script')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.form-check-input').change(function() {
                    var checkboxId = $(this).attr('id');
                    var isChecked = $(this).is(':checked') ? 1 : 0;

                    $.ajax({
                        url: '{{ route('appendix-status') }}', // Laravel 路由 URL
                        type: 'POST',
                        data: {
                            id: checkboxId,
                            status: isChecked,
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

                var checkboxesStatus = {!! $checkboxesStatus !!}; // 轉換為 JavaScript 變數

                $.each(checkboxesStatus, function(key, value) {
                    if (value === "1") {
                        $('#' + key).prop('checked', true);
                    } else {
                        $('#' + key).prop('checked', false);
                    }
                });
            });
        </script>
    @endsection
