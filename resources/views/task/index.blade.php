@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('css')
    @vite('node_modules/tippy.js/dist/tippy.css')
    <style>
        .task-filter-card .form-label {
            font-size: 13px;
            margin-bottom: 6px;
            color: #6c757d;
        }

        .task-list-table {
            table-layout: fixed;
        }

        .task-list-table thead th {
            font-size: 13px;
            font-weight: 600;
            color: #495057;
            background-color: #f8f9fa;
            border-bottom-width: 1px;
        }

        .task-list-table th,
        .task-list-table td {
            white-space: normal;
            word-break: break-word;
            overflow-wrap: anywhere;
            vertical-align: top;
            padding: 0.75rem 0.65rem;
        }

        .task-list-table .col-no {
            width: 48px;
        }

        .task-list-table .col-project {
            width: 18%;
            min-width: 160px;
        }

        .task-list-table .col-template {
            width: 22%;
            min-width: 180px;
        }

        .task-list-table .col-priority {
            width: 72px;
            text-align: center;
        }

        .task-list-table .col-executors {
            width: 14%;
            min-width: 120px;
        }

        .task-list-table .col-progress {
            width: 110px;
        }

        .task-list-table .col-deadline {
            width: 108px;
        }

        .task-list-table .col-actions {
            width: 88px;
            white-space: nowrap;
        }

        .task-list-table .col-priority,
        .task-list-table .col-deadline,
        .task-list-table .col-actions {
            white-space: nowrap;
        }

        .task-project-customer {
            display: block;
            color: #6c757d;
            font-size: 0.8125rem;
            margin-bottom: 0.2rem;
            line-height: 1.35;
        }

        .task-project-name,
        .task-template-name {
            display: block;
            line-height: 1.4;
            font-size: 0.9375rem;
        }

        .task-executor-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.35rem;
        }

        .task-executor-list .badge {
            font-weight: 500;
            line-height: 1.3;
            white-space: normal;
            text-align: left;
        }

        .task-status-badge {
            display: inline-block;
            max-width: 100%;
            font-size: 12px;
            font-weight: 500;
            line-height: 1.35;
            white-space: normal;
            text-align: center;
            padding: 0.4rem 0.5rem;
        }

        .task-deadline-date,
        .task-deadline-time {
            display: block;
            line-height: 1.35;
        }

        .task-deadline-date {
            font-weight: 500;
        }

        .task-deadline-time {
            color: #6c757d;
            font-size: 0.8125rem;
        }

        .task-list-table .pagination {
            margin-bottom: 0;
        }

        .task-list-table ~ .row .pagination .page-link {
            border-radius: 6px;
            margin: 0 2px;
        }

        @media (max-width: 768px) {
            .task-list-table {
                table-layout: auto;
                min-width: 960px;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', ['title' => '派工列表', 'subtitle' => '派工管理'])

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="GET" action="{{ route('task') }}" class="task-filter-card mb-3">
                            <div class="row g-2 align-items-end">
                                <div class="col-md-3 col-lg-3">
                                    <label class="form-label" for="task-filter-project-name">專案名稱</label>
                                    <input type="search" class="form-control" id="task-filter-project-name"
                                        placeholder="請輸入專案名稱" name="project_name"
                                        value="{{ $request->project_name }}">
                                </div>
                                <div class="col-md-3 col-lg-3">
                                    <label class="form-label" for="task-filter-template">派工項目</label>
                                    <select class="form-control" id="task-filter-template" data-toggle="select2"
                                        data-width="100%" name="task_template_id" onchange="this.form.submit()">
                                        <option value="" selected>請選擇</option>
                                        @foreach ($task_templates as $task_template)
                                            <option value="{{ $task_template->id }}"
                                                title="{{ $task_template->name }}"
                                                {{ $request->task_template_id == $task_template->id ? 'selected' : '' }}>
                                                {{ $task_template->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 col-lg-2">
                                    <label class="form-label" for="task-filter-status">派工進度</label>
                                    <select class="form-control" id="task-filter-status" data-toggle="select2"
                                        data-width="100%" name="status" onchange="this.form.submit()">
                                        <option value="" selected>請選擇</option>
                                        <option value="1" {{ $request->status == 1 ? 'selected' : '' }}>送出派工</option>
                                        <option value="2" {{ $request->status == 2 ? 'selected' : '' }}>接收派工</option>
                                        <option value="3" {{ $request->status == 3 ? 'selected' : '' }}>進行中</option>
                                        <option value="4" {{ $request->status == 4 ? 'selected' : '' }}>移轉</option>
                                        <option value="8" {{ $request->status == 8 ? 'selected' : '' }}>人員已完成，待確認</option>
                                        <option value="9" {{ $request->status == 9 ? 'selected' : '' }}>完成</option>
                                    </select>
                                </div>
                                <div class="col-md-2 col-lg-2">
                                    <label class="form-label" for="task-filter-user">執行人員</label>
                                    <select class="form-control" id="task-filter-user" data-toggle="select2"
                                        data-width="100%" name="user_id" onchange="this.form.submit()">
                                        <option value="" selected>請選擇</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ $request->user_id == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 col-lg-2">
                                    <div class="d-flex flex-wrap gap-2">
                                        <button type="submit" class="btn btn-success waves-effect waves-light">
                                            <i class="mdi mdi-magnify me-1"></i> 搜尋
                                        </button>
                                        <a href="{{ route('task') }}" class="btn btn-secondary waves-effect waves-light">
                                            <i class="mdi mdi-refresh me-1"></i> 重置
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="row mb-3 align-items-center">
                            <div class="col-sm-6">
                                <span class="text-muted">共 {{ $datas->total() }} 筆資料</span>
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end mt-2 mt-sm-0">
                                    <a href="{{ route('task.create') }}">
                                        <button type="button" class="btn btn-danger waves-effect waves-light">
                                            <i class="mdi mdi-plus-circle me-1"></i> 新增派工
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-centered table-striped task-list-table" id="products-datatable">
                                <thead>
                                    <tr>
                                        <th scope="col" class="col-no">No</th>
                                        <th scope="col" class="col-project">專案名稱</th>
                                        <th scope="col" class="col-template">派工項目</th>
                                        <th scope="col" class="col-priority">優先序</th>
                                        <th scope="col" class="col-executors">負責執行人員</th>
                                        <th scope="col" class="col-progress">派工進度</th>
                                        <th scope="col" class="col-deadline">預計完成時間</th>
                                        {{-- <th scope="col">派工主管</th> --}}
                                        <th scope="col" class="col-actions">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $key => $data)
                                        <tr>
                                            <td class="col-no">{{ $datas->firstItem() + $key }} </td>
                                            <td class="col-project">
                                                @if (isset($data->project_data))
                                                    @if (optional($data->project_data->user_data)->name)
                                                        <span class="task-project-customer">{{ optional($data->project_data->user_data)->name }}</span>
                                                    @endif
                                                    <span class="task-project-name">{{ $data->project_data->name }}</span>
                                                @elseif(!empty($data->name))
                                                    <span class="task-project-name">{{ $data->name }}</span>
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td class="col-template">
                                                @if (isset($data->task_template_data))
                                                    <span class="task-template-name">{{ $data->task_template_data->name }}</span>
                                                @elseif(!empty($data->name))
                                                    <span class="task-template-name">{{ $data->name }}</span>
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            <td class="col-priority text-center">
                                                @if ($data->priority == 0)
                                                    <span class="badge bg-danger">緊急</span>
                                                @elseif($data->priority == 1)
                                                    <span class="badge bg-primary">高</span>
                                                @elseif($data->priority == 2)
                                                    <span class="badge bg-warning text-dark">中</span>
                                                @else
                                                    <span class="badge bg-success">低</span>
                                                @endif
                                            </td>
                                            <td class="col-executors">
                                                <div class="task-executor-list">
                                                    @forelse ($data->items as $item)
                                                        <span class="badge bg-primary">
                                                            {{ optional($item->user_data)->name ?? '未指定' }}@if (filled($item->context))（{{ $item->context }}）@endif
                                                        </span>
                                                    @empty
                                                        —
                                                    @endforelse
                                                </div>
                                            </td>
                                            <td class="col-progress">
                                                <span class="badge bg-light text-dark border task-status-badge"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="@foreach ($data->items as $item) {{ optional($item->user_data)->name }}（{{ $item->status() }}）@if (!$loop->last)、@endif @endforeach">
                                                    {{ $data->status() }}
                                                </span>
                                            </td>
                                            <td class="col-deadline">
                                                @if ($data->estimated_end)
                                                    @php
                                                        $deadlineParts = explode(' ', (string) $data->estimated_end, 2);
                                                    @endphp
                                                    <span class="task-deadline-date">{{ $deadlineParts[0] ?? '—' }}</span>
                                                    @if (!empty($deadlineParts[1]))
                                                        <span class="task-deadline-time">{{ substr($deadlineParts[1], 0, 5) }}</span>
                                                    @endif
                                                @else
                                                    —
                                                @endif
                                            </td>
                                            {{-- <td>{{ $data->user_data->name }}</td> --}}
                                            <td class="col-actions">
                                                @if (Auth::user()->id == $data->created_by)
                                                    <a href="{{ route('task.edit', $data->id) }}" class="action-icon">
                                                        <i class="mdi mdi-square-edit-outline"></i></a>
                                                    @if ((int) (Auth::user()->level ?? 2) !== 2)
                                                        <a href="{{ route('task.del', $data->id) }}" class="action-icon"> <i
                                                                class="mdi mdi-trash-can-outline"></i></a>
                                                    @endif
                                                @endif
                                                <a href="{{ route('task.copy', $data->id) }}" class="action-icon">
                                                    <i class="mdi mdi-content-copy"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- 分頁連結 -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-muted">
                                        <i class="mdi mdi-information-outline me-1"></i>
                                        顯示第 {{ $datas->firstItem() ?? 0 }} 到 {{ $datas->lastItem() ?? 0 }} 筆，共 {{ $datas->total() }} 筆資料
                                    </div>
                                    <nav aria-label="分頁導航">
                                        {{ $datas->appends(request()->query())->links('pagination::custom-bootstrap-5') }}
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>

    </div> <!-- container -->
@endsection
@section('script')
    @vite(['resources/js/pages/foo-tables.init.js'])
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (el) {
                new bootstrap.Tooltip(el);
            });
        });
    </script>
@endsection