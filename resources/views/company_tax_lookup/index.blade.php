@extends('layouts.vertical', ['title' => '統編查詢'])

@section('content')
    <div class="container-fluid">
        @include('layouts.shared.page-title', ['title' => '統編查詢', 'subtitle' => '客戶管理'])

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <p class="text-muted mb-3">
                            資料來源：
                            <a href="https://data.gcis.nat.gov.tw/" target="_blank" rel="noopener">經濟部商工行政資料開放平臺</a>
                            （公司登記基本資料-應用一 → 商業登記基本資料-應用三）。免驗證碼；統編會自動補成 8 碼。
                        </p>

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <h5 class="mb-2">單筆查詢</h5>
                        <form method="get" action="{{ route('company.tax.lookup') }}" class="row g-2 align-items-end mb-4">
                            <div class="col-md-4">
                                <label for="tax_id" class="form-label">統一編號</label>
                                <input type="text"
                                       class="form-control"
                                       id="tax_id"
                                       name="tax_id"
                                       value="{{ old('tax_id', $taxId) }}"
                                       maxlength="12"
                                       inputmode="numeric"
                                       placeholder="例如 20828393 或 4525306"
                                       required
                                       autofocus>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                    <i class="mdi mdi-magnify me-1"></i> 查詢
                                </button>
                            </div>
                        </form>

                        <hr>

                        <h5 class="mb-2">Excel 批次查詢</h5>
                        <p class="text-muted small">
                            上傳 .xlsx，表頭需有「公司名稱」「統一編號」兩欄。每筆約間隔 0.3 秒，單次最多
                            {{ (int) config('gcis.batch_max_rows', 200) }} 筆。
                            （若只有 CSV，請先另存成 .xlsx）
                        </p>
                        <form method="post" action="{{ route('company.tax.lookup.batch') }}" enctype="multipart/form-data" class="row g-2 align-items-end mb-4">
                            @csrf
                            <div class="col-md-5">
                                <input type="file" name="file" class="form-control" accept=".xlsx" required>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-success waves-effect waves-light">
                                    <i class="mdi mdi-upload me-1"></i> 上傳並查詢
                                </button>
                                <a href="{{ route('company.tax.lookup.template') }}" class="btn btn-outline-secondary">
                                    下載欄位範例 CSV
                                </a>
                            </div>
                        </form>

                        @if (!empty($batch['rows']))
                            <h5 class="mb-2">批次結果</h5>
                            @foreach ($batch['errors'] ?? [] as $batchError)
                                <div class="alert alert-warning">{{ $batchError }}</div>
                            @endforeach
                            <div class="table-responsive mb-4">
                                <table class="table table-sm table-striped table-bordered table-centered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>列</th>
                                            <th>輸入統編</th>
                                            <th>補零後</th>
                                            <th>輸入名稱</th>
                                            <th>官方名稱</th>
                                            <th>名稱比對</th>
                                            <th>類型</th>
                                            <th>狀態</th>
                                            <th>負責人</th>
                                            <th>地址</th>
                                            <th>結果</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($batch['rows'] as $row)
                                            <tr>
                                                <td>{{ $row['line'] }}</td>
                                                <td>{{ $row['input_tax_id'] }}</td>
                                                <td>{{ $row['tax_id'] }}</td>
                                                <td>{{ $row['input_name'] }}</td>
                                                <td>{{ $row['official_name'] }}</td>
                                                <td>
                                                    @if ($row['name_match'] === true)
                                                        <span class="badge bg-success">相符</span>
                                                    @elseif ($row['name_match'] === false)
                                                        <span class="badge bg-warning text-dark">不一致</span>
                                                    @else
                                                        —
                                                    @endif
                                                </td>
                                                <td>{{ $row['registry_type'] ?: '—' }}</td>
                                                <td>{{ $row['company_status'] }}</td>
                                                <td>{{ $row['responsible'] }}</td>
                                                <td class="text-start">{{ $row['address'] }}</td>
                                                <td>{{ $row['status'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                        @if ($result !== null)
                            @if (!empty($result['source_note']))
                                <div class="alert alert-secondary">
                                    {{ $result['source_note'] }}
                                    @if (!empty($result['registry_type']))
                                        ・本次命中：<strong>{{ $result['registry_type'] }}登記</strong>
                                    @endif
                                    <div class="mt-1">
                                        <a href="https://findbiz.nat.gov.tw/fts/query/QueryBar/queryInit.do" target="_blank" rel="noopener">官方商工公示查詢</a>
                                    </div>
                                </div>
                            @endif

                            @foreach ($result['errors'] ?? [] as $error)
                                <div class="alert alert-warning">{{ $error }}</div>
                            @endforeach

                            @if ($localCustomer)
                                <div class="alert alert-info">
                                    本系統客戶資料已有此統編：
                                    <strong>{{ optional($localCustomer->user_data)->name ?? '（未設定名稱）' }}</strong>
                                    （客戶 user_id：{{ $localCustomer->user_id }}）
                                </div>
                            @endif

                            @if (!empty($result['company']))
                                @php $company = $result['company']; @endphp
                                <h5 class="mb-2">公司登記基本資料</h5>
                                <div class="table-responsive mb-4">
                                    <table class="table table-bordered table-centered mb-0">
                                        <tbody>
                                            <tr>
                                                <th style="width: 180px;" class="table-light">統一編號</th>
                                                <td>{{ $company['tax_id'] }}</td>
                                            </tr>
                                            <tr>
                                                <th class="table-light">公司名稱</th>
                                                <td>{{ $company['name'] }}</td>
                                            </tr>
                                            <tr>
                                                <th class="table-light">公司狀態</th>
                                                <td>{{ $company['status'] }}</td>
                                            </tr>
                                            <tr>
                                                <th class="table-light">案件狀態</th>
                                                <td>{{ $company['case_status'] ?: '—' }}</td>
                                            </tr>
                                            <tr>
                                                <th class="table-light">負責人</th>
                                                <td>{{ $company['responsible_name'] }}</td>
                                            </tr>
                                            <tr>
                                                <th class="table-light">公司地址</th>
                                                <td>{{ $company['location'] }}</td>
                                            </tr>
                                            <tr>
                                                <th class="table-light">資本額</th>
                                                <td>{{ $company['capital'] }}</td>
                                            </tr>
                                            <tr>
                                                <th class="table-light">實收資本額</th>
                                                <td>{{ $company['paid_in_capital'] }}</td>
                                            </tr>
                                            <tr>
                                                <th class="table-light">登記機關</th>
                                                <td>{{ $company['register_org'] }}</td>
                                            </tr>
                                            <tr>
                                                <th class="table-light">核准設立日期</th>
                                                <td>{{ $company['setup_date'] }}</td>
                                            </tr>
                                            <tr>
                                                <th class="table-light">最後核准變更日期</th>
                                                <td>{{ $company['change_date'] }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                            @if (!empty($result['business']))
                                @php $business = $result['business']; @endphp
                                <h5 class="mb-2">商業登記基本資料</h5>
                                <div class="table-responsive mb-4">
                                    <table class="table table-bordered table-centered mb-0">
                                        <tbody>
                                            <tr>
                                                <th style="width: 180px;" class="table-light">統一編號</th>
                                                <td>{{ $business['tax_id'] }}</td>
                                            </tr>
                                            <tr>
                                                <th class="table-light">商號名稱</th>
                                                <td>{{ $business['name'] }}</td>
                                            </tr>
                                            <tr>
                                                <th class="table-light">營業狀態</th>
                                                <td>{{ $business['status'] }}</td>
                                            </tr>
                                            <tr>
                                                <th class="table-light">組織類型</th>
                                                <td>{{ $business['org_type'] ?: '—' }}</td>
                                            </tr>
                                            <tr>
                                                <th class="table-light">登記機關</th>
                                                <td>{{ $business['agency'] }}</td>
                                            </tr>
                                            <tr>
                                                <th class="table-light">地址</th>
                                                <td>{{ $business['address'] }}</td>
                                            </tr>
                                            <tr>
                                                <th class="table-light">核准設立日期</th>
                                                <td>{{ $business['setup_date'] }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                @if (!empty($business['items']))
                                    <h6 class="mb-2">營業項目</h6>
                                    <div class="table-responsive mb-4">
                                        <table class="table table-sm table-striped table-bordered mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th style="width: 140px;">代碼</th>
                                                    <th>說明</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($business['items'] as $item)
                                                    <tr>
                                                        <td>{{ $item['Business_Item'] ?? '' }}</td>
                                                        <td>{{ $item['Business_Item_Desc'] ?? '' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
