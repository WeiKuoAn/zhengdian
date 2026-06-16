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

        .task-template-table .col-actions {
            width: 7%;
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
                            @endif
                        </div>

                        <div class="table-responsive">
                            <table class="table table-centered table-striped task-template-table" id="products-datatable">
                                <thead>
                                    <tr>
                                        <th scope="col" class="col-no">No</th>
                                        <th scope="col" class="col-status">專案狀態</th>
                                        <th scope="col" class="col-stage">專案階段</th>
                                        <th scope="col" class="col-name">派工項目</th>
                                        <th scope="col" class="col-hours">執行時數</th>
                                        <th scope="col" class="col-actions">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $key => $data)
                                        <tr>
                                            <td class="col-no">{{ $key + 1 }}</td>
                                            <td class="col-status">{{ optional($data->check_status_parent_data)->name ?? '—' }}</td>
                                            <td class="col-stage">{{ optional($data->check_status_data)->name ?? '—' }}</td>
                                            <td class="col-name">{{ $data->name }}</td>
                                            <td class="col-hours">{{ $data->duration_hours !== null ? rtrim(rtrim(number_format((float) $data->duration_hours, 2, '.', ''), '0'), '.') . ' 小時' : '—' }}</td>
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
            if (!modalEl) {
                return;
            }

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
        });
    </script>
@endsection
