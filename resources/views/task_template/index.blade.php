@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('css')
    <style>
        .task-template-table th,
        .task-template-table td {
            white-space: normal;
            word-break: break-word;
            overflow-wrap: anywhere;
            vertical-align: top;
        }

        .task-template-table .col-no {
            width: 4%;
        }

        .task-template-table .col-status,
        .task-template-table .col-stage {
            width: 11%;
            min-width: 88px;
        }

        .task-template-table .col-name {
            min-width: 240px;
        }

        .task-template-table .col-hours,
        .task-template-table .col-actions {
            white-space: nowrap;
            width: 9%;
        }

        .task-template-table .col-check {
            width: 40px;
            white-space: nowrap;
            text-align: center;
        }

        .task-template-table .col-list-status {
            width: 72px;
            white-space: nowrap;
        }

        .task-template-table .col-seq {
            width: 88px;
            white-space: nowrap;
        }

        .task-template-table .seq-input {
            width: 72px;
            min-width: 72px;
        }

        .task-template-table tr.is-down td {
            opacity: 0.72;
        }
    </style>
@endsection

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', ['title' => '派工項目設定', 'subtitle' => '設定管理'])

        <div class="row">
            <div class="col-12">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if (session('import_errors'))
                    <div class="alert alert-warning mb-0">
                        <div class="fw-semibold mb-1">匯入問題摘要</div>
                        <ul class="mb-0 ps-3">
                            @foreach (session('import_errors') as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2 align-items-center g-2">
                            <div class="col-sm-auto">
                                <form method="GET" action="{{ route('TaskTemplate') }}"
                                    class="d-inline-flex align-items-center flex-nowrap">
                                    <label for="status_filter" class="me-2 mb-0 text-nowrap">上架狀態</label>
                                    <select id="status_filter" name="status_filter" class="form-select form-select-sm"
                                        style="min-width: 90px;" onchange="this.form.submit()">
                                        <option value="all" {{ ($statusFilter ?? 'all') === 'all' ? 'selected' : '' }}>全部
                                        </option>
                                        <option value="up" {{ ($statusFilter ?? 'all') === 'up' ? 'selected' : '' }}>上架
                                        </option>
                                        <option value="down" {{ ($statusFilter ?? 'all') === 'down' ? 'selected' : '' }}>下架
                                        </option>
                                    </select>
                                </form>
                            </div>
                            <div class="col-sm-auto">
                                <a href="{{ route('TaskTemplate.create') }}">
                                    <button type="button" class="btn btn-danger waves-effect waves-light"><i
                                            class="mdi mdi-plus-circle me-1"></i> 新增派工項目</button>
                                </a>
                            </div>
                            @if ((int) (Auth::user()->level ?? 2) !== 2)
                                <div class="col-sm-auto">
                                    <button type="button" class="btn btn-primary waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target="#importTaskTemplateModal">
                                        <i class="mdi mdi-upload me-1"></i> 匯入 Excel
                                    </button>
                                </div>
                                <div class="col-sm-auto">
                                    <button type="submit" form="batchTakeDownForm" id="batchTakeDownBtn"
                                        class="btn btn-warning waves-effect waves-light" disabled>
                                        <i class="mdi mdi-arrow-down-bold-box-outline me-1"></i> 批次下架
                                    </button>
                                </div>
                                <div class="col-sm-auto">
                                    <button type="submit" form="sortTaskTemplateForm"
                                        class="btn btn-outline-primary waves-effect waves-light">
                                        <i class="mdi mdi-sort me-1"></i> 儲存排序
                                    </button>
                                </div>
                            @endif
                        </div>

                        <p class="text-muted small mb-2">
                            排序數字愈小愈前面；同專案階段內依排序顯示。可支援 1、1-2、1-10 這類自然排序。
                        </p>

                        <form method="POST" action="{{ route('TaskTemplate.batch.down') }}" id="batchTakeDownForm">
                            @csrf
                            <input type="hidden" name="status_filter" value="{{ $statusFilter ?? 'all' }}">
                        </form>
                        <form method="POST" action="{{ route('TaskTemplate.sort') }}" id="sortTaskTemplateForm">
                            @csrf
                            <input type="hidden" name="status_filter" value="{{ $statusFilter ?? 'all' }}">
                        </form>
                        <div class="table-responsive">
                            <table class="table table-centered table-striped task-template-table" id="products-datatable">
                                <thead>
                                    <tr>
                                        @if ((int) (Auth::user()->level ?? 2) !== 2)
                                            <th scope="col" class="col-check">
                                                <input type="checkbox" class="form-check-input" id="selectAllTaskTemplates"
                                                    title="全選">
                                            </th>
                                        @endif
                                        <th scope="col" class="col-no">No</th>
                                        <th scope="col" class="col-status">專案狀態</th>
                                        <th scope="col" class="col-stage">專案階段</th>
                                        <th scope="col" class="col-name">派工項目</th>
                                        <th scope="col" class="col-hours">執行時數</th>
                                        <th scope="col" class="col-seq">排序</th>
                                        <th scope="col" class="col-list-status">狀態</th>
                                        <th scope="col" class="col-actions">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $key => $data)
                                        <tr class="{{ ($data->status ?? 'up') === 'down' ? 'is-down' : '' }}">
                                            @if ((int) (Auth::user()->level ?? 2) !== 2)
                                                <td class="col-check">
                                                    <input type="checkbox" class="form-check-input task-template-check"
                                                        form="batchTakeDownForm" name="ids[]" value="{{ $data->id }}"
                                                        {{ ($data->status ?? 'up') === 'down' ? 'disabled' : '' }}>
                                                </td>
                                            @endif
                                            <td class="col-no">{{ $key + 1 }}</td>
                                            <td class="col-status">{{ optional($data->check_status_parent_data)->name ?? '—' }}</td>
                                            <td class="col-stage">{{ optional($data->check_status_data)->name ?? '—' }}</td>
                                            <td class="col-name">{{ $data->name }}</td>
                                            <td class="col-hours">{{ $data->duration_hours !== null ? rtrim(rtrim(number_format((float) $data->duration_hours, 2, '.', ''), '0'), '.') . ' 小時' : '—' }}</td>
                                            <td class="col-seq">
                                                @if ((int) (Auth::user()->level ?? 2) !== 2)
                                                    <input type="text" form="sortTaskTemplateForm"
                                                        name="seq[{{ $data->id }}]"
                                                        value="{{ $data->seq ?? '0' }}"
                                                        class="form-control form-control-sm seq-input">
                                                @else
                                                    {{ $data->seq ?? '0' }}
                                                @endif
                                            </td>
                                            <td class="col-list-status">
                                                @if (($data->status ?? 'up') === 'down')
                                                    <span class="badge bg-secondary">下架</span>
                                                @else
                                                    <span class="badge bg-success">上架</span>
                                                @endif
                                            </td>
                                            <td class="col-actions">
                                                <a href="{{ route('TaskTemplate.edit', $data->id) }}" class="action-icon"> <i
                                                        class="mdi mdi-square-edit-outline"></i></a>
                                                @if ((int) (Auth::user()->level ?? 2) !== 2)
                                                    <a href="{{ route('TaskTemplate.del', $data->id) }}" class="action-icon"> <i class="mdi mdi-trash-can-outline"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->

        @if ((int) (Auth::user()->level ?? 2) !== 2)
            <div id="importTaskTemplateModal" class="modal fade" tabindex="-1" role="dialog"
                aria-labelledby="importTaskTemplateModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('TaskTemplate.import') }}" enctype="multipart/form-data"
                            id="importTaskTemplateForm">
                            @csrf
                            <div class="modal-header">
                                <h4 class="modal-title" id="importTaskTemplateModalLabel">匯入派工項目</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-muted small mb-3">
                                    請上傳 Excel（.xlsx）。欄位：派工項目名稱、專案狀態、專案階段、描述、執行時數。
                                    專案狀態／專案階段須與系統設定一致；<strong>派工項目名稱相同則覆蓋更新</strong>（含狀態、階段、描述、時數）。
                                </p>
                                <div class="mb-3">
                                    <a href="{{ route('TaskTemplate.import.template') }}"
                                        class="btn btn-outline-secondary btn-sm">
                                        <i class="mdi mdi-download me-1"></i> 下載匯入範本
                                    </a>
                                </div>
                                <div class="mb-0">
                                    <label for="importTaskTemplateFile" class="form-label">選擇檔案<span
                                            class="text-danger">*</span></label>
                                    <input type="file" id="importTaskTemplateFile" name="file" class="form-control"
                                        accept=".xlsx" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="mdi mdi-upload me-1"></i> 開始匯入
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

    </div> <!-- container -->
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modalEl = document.getElementById('importTaskTemplateModal');
            if (modalEl) {
                modalEl.addEventListener('hidden.bs.modal', function () {
                    const form = document.getElementById('importTaskTemplateForm');
                    const fileInput = document.getElementById('importTaskTemplateFile');
                    if (form) {
                        form.reset();
                    }
                    if (fileInput) {
                        fileInput.value = '';
                    }
                });
            }

            const selectAll = document.getElementById('selectAllTaskTemplates');
            const batchBtn = document.getElementById('batchTakeDownBtn');
            const batchForm = document.getElementById('batchTakeDownForm');

            function getSelectableChecks() {
                return Array.from(document.querySelectorAll('.task-template-check:not(:disabled)'));
            }

            function syncBatchControls() {
                const checks = getSelectableChecks();
                const checked = checks.filter((el) => el.checked);
                if (batchBtn) {
                    batchBtn.disabled = checked.length === 0;
                }
                if (selectAll) {
                    selectAll.checked = checks.length > 0 && checked.length === checks.length;
                    selectAll.indeterminate = checked.length > 0 && checked.length < checks.length;
                }
            }

            if (selectAll) {
                selectAll.addEventListener('change', function () {
                    getSelectableChecks().forEach((el) => {
                        el.checked = selectAll.checked;
                    });
                    syncBatchControls();
                });
            }

            document.querySelectorAll('.task-template-check').forEach((el) => {
                el.addEventListener('change', syncBatchControls);
            });

            if (batchForm) {
                batchForm.addEventListener('submit', function (event) {
                    const count = getSelectableChecks().filter((el) => el.checked).length;
                    if (count === 0) {
                        event.preventDefault();
                        return;
                    }
                    if (!confirm('確定要下架所選的 ' + count + ' 筆派工項目嗎？')) {
                        event.preventDefault();
                    }
                });
            }

            syncBatchControls();
        });
    </script>
@endsection
