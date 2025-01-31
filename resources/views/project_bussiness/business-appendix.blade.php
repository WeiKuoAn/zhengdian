@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', [
            'title' => '商業業-資料',
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
                                                                    id="b_appendix01" name="b_appendix01">
                                                                <label class="form-check-label" for="b_appendix01">
                                                                    <h5 class="font-size-16 m-0">1.依法設立登記之證明</h5>
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 40px;">
                                                            <div class="form-check font-size-16">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="b_appendix02" name="b_appendix02">
                                                                <label class="form-check-label" for="b_appendix02">
                                                                    <h5 class="font-size-16 m-0">2.最新的投保單位被保險人名冊</h5>
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 40px;">
                                                            <div class="form-check font-size-16">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="b_appendix03" name="b_appendix03">
                                                                <label class="form-check-label" for="b_appendix03">
                                                                    <h5 class="font-size-16 m-0">3.最近一年度資產負債表</h5>
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 40px;">
                                                            <div class="form-check font-size-16">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="b_appendix04" name="b_appendix04">
                                                                <label class="form-check-label" for="b_appendix04">
                                                                    <h5 class="font-size-16 m-0">4.最近一年度損益表</h5>
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 40px;">
                                                            <div class="form-check font-size-16">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="b_appendix05" name="b_appendix05">
                                                                <label class="form-check-label" for="b_appendix05">
                                                                    <h5 class="font-size-16 m-0">5.最近一年度稅務申報書</h5>
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 40px;">
                                                            <div class="form-check font-size-16">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="b_appendix06" name="b_appendix06">
                                                                <label class="form-check-label" for="b_appendix06">
                                                                    <h5 class="font-size-16 m-0">6.地方稅為無違章欠稅</h5>
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 40px;">
                                                            <div class="form-check font-size-16">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="b_appendix07" name="b_appendix07">
                                                                <label class="form-check-label" for="b_appendix07">
                                                                    <h5 class="font-size-16 m-0">7.國稅為無違章欠稅</h5>
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
                                                                    id="b_two_appendix01" name="b_two_appendix01">
                                                                <label class="form-check-label" for="b_two_appendix01">
                                                                    <h5 class="font-size-16 m-0">
                                                                        1.切結聲明書
                                                                        <a href="{{ URL::asset('downloads/商業服務業_切結聲明書.pdf') }}"
                                                                            download="商業服務業_切結聲明書.pdf">
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
                                                                    id="b_two_appendix02" name="b_two_appendix02">
                                                                <label class="form-check-label" for="b_two_appendix02">
                                                                    <h5 class="text-truncate font-size-16 m-0">
                                                                        2.蒐集個人資料告知事項暨個人資料提供同意書<span
                                                                            class="text-danger">（一式兩份並正本簽名）</span>
                                                                        <a href="{{ URL::asset('downloads/商業服務業_個人資料提供同意書.pdf') }}"
                                                                            download="商業服務業_個人資料提供同意書.pdf">
                                                                            （請點擊我下載空白文件）
                                                                        </a>
                                                                    </h5>
                                                                    <h5 class="text-truncate font-size-16 m-0">
                                                                        備註：主提案商所有參與人員、被帶動企業負責人都要簽名</h5>
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
        <script src="{{ asset('assets/js/twzipcode-1.4.1-min.js') }}"></script>

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
