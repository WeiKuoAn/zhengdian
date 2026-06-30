@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('css')
    <style>
        .plan-toolbar {
            background: #f8f9fc;
            border: 1px solid #e6eaf0;
            border-radius: 10px;
            padding: 12px 14px;
        }

        .plan-grid-head {
            font-size: 13px;
            color: #6b7280;
            font-weight: 600;
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }

        .plan-milestone-row {
            background: #fff;
            border: 1px solid #edf1f6;
            border-radius: 10px;
            padding: 10px 8px;
            margin-bottom: 10px;
        }

        .plan-milestone-row.is-completed {
            background: #f3f4f6;
            border-color: #e5e7eb;
        }

        .plan-milestone-row.is-completed .plan-task-label,
        .plan-milestone-row.is-completed .plan-task-desc,
        .plan-milestone-row.is-completed .plan-gap-tag,
        .plan-milestone-row.is-completed .form-label,
        .plan-milestone-row.is-completed .plan-dispatch-btn-text {
            color: #9ca3af !important;
        }

        .plan-task-label {
            font-weight: 600;
            color: #344054;
            font-size: 15px;
            line-height: 1.4;
        }

        .plan-gap-tag {
            display: inline-block;
            margin-top: 4px;
            font-size: 12px;
            color: #475467;
            background: #f2f4f7;
            border-radius: 999px;
            padding: 2px 8px;
        }

        .plan-task-desc {
            margin-top: 4px;
            font-size: 13px;
            color: #667085;
            line-height: 1.35;
            display: inline-block;
            cursor: help;
            border-bottom: 1px dashed #98a2b3;
        }

        .plan-meta-row {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
            margin-top: 4px;
        }

        .plan-executor-summary {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            border: 1px dashed #d0d5dd;
            border-radius: 8px;
            padding: 6px 8px;
            background: #fcfcfd;
            margin-bottom: 6px;
        }

        .plan-executor-summary small {
            color: #667085;
            max-width: 72%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 13px;
        }

        .plan-assignee-status-trigger {
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
        }

        .plan-milestone-row .form-control-sm,
        .plan-milestone-row .form-select-sm {
            font-size: 14px;
            min-height: 34px;
        }

        .plan-date-col {
            max-width: 150px;
            flex: 0 0 150px;
        }

        .plan-order-col {
            max-width: 150px;
            flex: 0 0 150px;
        }

        .plan-status-col {
            max-width: 90px;
            flex: 0 0 90px;
        }

        .plan-status-badge {
            display: inline-block;
            max-width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.2;
        }

        .plan-project-col {
            max-width: 230px;
            flex: 0 0 230px;
        }

        .plan-equal-col {
            max-width: 150px;
            flex: 0 0 150px;
        }

        .plan-dispatch-btn {
            width: 100%;
            text-align: left;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            min-height: 36px;
        }

        .dispatch-modal-dialog {
            max-width: 820px;
        }

        .dispatch-modal .modal-title {
            font-size: 14px;
            font-weight: 700;
        }

        .dispatch-modal .modal-body {
            padding: 0.9rem 1rem;
        }

        .dispatch-modal .dispatch-editor-entry {
            margin-bottom: 0.75rem;
        }

        .dispatch-modal .dispatch-editor-user,
        .dispatch-modal .dispatch-editor-context,
        .dispatch-modal .dispatch-editor-comments {
            font-size: 14px;
        }

        .dispatch-modal .dispatch-editor-context,
        .dispatch-modal .dispatch-editor-comments {
            min-height: 96px;
            resize: vertical;
        }

        .dispatch-modal .remove-dispatch-editor-row {
            min-width: 36px;
        }

        .dispatch-modal #addDispatchEditorRow {
            font-size: 14px;
            font-weight: 600;
        }

        .dispatch-modal .dispatch-modal-schedule-foot .form-control[readonly] {
            background-color: #fff;
            color: #344054;
        }

        .dispatch-modal .modal-footer .btn {
            font-size: 14px;
        }

        @media (max-width: 991.98px) {
            .plan-date-col,
            .plan-order-col,
            .plan-status-col,
            .plan-project-col,
            .plan-equal-col {
                max-width: 100%;
                flex: 0 0 100%;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', [
            'title' => $data->user_data->name . '專案管理',
            'subtitle' => '專案管理',
        ])

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start mb-3">
                            <div class="w-100 ">
                                <h3 class="mt-1 mb-0">{{ $data->name }}</h3>
                                <p class="mb-1 mt-1 text-muted">計畫登入帳號：ＸＸＸ　計畫登入密碼：ＸＸＸ</p>
                            </div>
                        </div>
                        <ul class="nav nav-tabs nav-bordered nav-justified">
                            <li class="nav-item">
                                <a href="{{ route('project.edit', $data->id) }}" aria-expanded="true"
                                    class="nav-link">
                                    專案基本設定
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.plan', $data->id) }}" aria-expanded="false"
                                    class="nav-link active">
                                    派工排程作業
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.background', $data->id) }}" aria-expanded="false" class="nav-link ">
                                    專案背景調查
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.write', $data->id) }}" aria-expanded="false"
                                    class="nav-link">
                                    人事/帶動企業
                                </a>
                            </li>
                            @if($data->type == '3')
                            <li class="nav-item">
                                <a href="{{ route('project.sbir01', $data->id) }}" aria-expanded="false"
                                    class="nav-link">
                                    SBIR內容撰寫
                                </a>
                            </li>
                            @endif
                            <li class="nav-item">
                                <a href="{{ route('project.send', $data->id) }}" aria-expanded="false" class="nav-link">
                                    送件作業
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.midterm', $data->id) }}" aria-expanded="false" class="nav-link">
                                    期中報告/檢核
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.final', $data->id) }}" aria-expanded="false" class="nav-link">
                                    期末報告/結案
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.accounting', $data->id) }}" aria-expanded="false" class="nav-link">
                                    經費報表
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a href="{{ route('projectMilestones.calendar', ['project_id' => $data->id]) }}" aria-expanded="false" class="nav-link">
                                    專案行事曆
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.meet', $data->id) }}" aria-expanded="false" class="nav-link">
                                    會議瀏覽
                                </a>
                            </li>
                        </ul>

                        @php
                            $isLevelTwo = $is_level_two ?? false;
                        @endphp

                        @if (session('success'))
                            <div class="alert alert-success mt-2">{{ session('success') }}</div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger mt-2">{{ session('error') }}</div>
                        @endif

                        <form action="{{ route('project.plan.data', $data->id) }}" method="POST" id="plan-form">
                            @csrf
                            <div class="row mt-3">
                                <div class="mb-3">
                                    <label class="form-label">排程日期<span class="text-danger">*</span></label>
                                    <p class="text-muted small mb-2">變更「表訂時間」時，可依專案階段設定的<b>表訂連動天數</b>自動推移後續階段；改第一筆會重算全部，改中間列僅影響該列以下。</p>
                                    <div class="plan-toolbar mb-2">
                                        <div class="row mb-1 d-none d-lg-flex plan-grid-head">
                                            <div class="col-lg-4 mb-1">專案派工</div>
                                            <div class="col-lg-1 mb-1">狀態</div>
                                            <div class="col-lg-2 mb-1">表訂時間</div>
                                            <div class="col-lg-3 mb-1">派工與負責執行人員</div>
                                            <div class="col-lg-2 mb-1">實際完成時間</div>
                                        </div>
                                    </div>
                                    @foreach ($task_datas as $key => $task_data)
                                        <div class="row align-items-start plan-milestone-row {{ ((string) ($task_data->dispatch_status_value ?? '') === '9') ? 'is-completed' : '' }}"
                                            data-row-index="{{ $key }}">
                                            <div class="col-lg-4 mb-2 mb-lg-0 plan-project-col">
                                                <label class="d-lg-none small text-muted">專案派工</label>
                                                <div class="plan-task-label">【{{ optional($task_data->check_status_data)->name }}】{{ $task_data->name }}</div>
                                                <div class="plan-meta-row">
                                                    @if (!empty($task_data->description))
                                                        <div class="plan-task-desc"
                                                            title="{{ $task_data->description }}">
                                                            任務說明
                                                        </div>
                                                    @endif
                                                    @php
                                                        $durationHours = max(0, (float) ($task_data->duration_hours ?? 0));
                                                        $durationRemainder = fmod($durationHours, 8.0);
                                                        $isWholeDays = $durationHours > 0
                                                            && (abs($durationRemainder) < 0.00001 || abs($durationRemainder - 8.0) < 0.00001);
                                                        $durationHoursText = rtrim(rtrim(number_format($durationHours, 2, '.', ''), '0'), '.');
                                                    @endphp
                                                    <span class="plan-gap-tag">
                                                        @if ($isWholeDays)
                                                            執行天數：{{ (int) round($durationHours / 8) }} 天
                                                        @else
                                                            執行時數：{{ $durationHoursText }} 小時
                                                        @endif
                                                    </span>
                                                </div>
                                                <input type="hidden" name="milestone_types[]"
                                                    value="{{ $task_data->id }}">
                                                <input type="hidden" name="linked_task_ids[]"
                                                    value="{{ $task_data->linked_task_id ?? '' }}">
                                            </div>
                                            <div class="col-lg-1 mb-2 mb-lg-0 plan-status-col">
                                                <label class="d-lg-none small text-muted">狀態</label>
                                                @php
                                                    $statusShortText = match ((string) ($task_data->dispatch_status_value ?? '')) {
                                                        '1' => '送出派工',
                                                        '2' => '已接收',
                                                        '3' => '執行中',
                                                        '8' => '待確認',
                                                        '9' => '已完成',
                                                        default => '未派工',
                                                    };
                                                    $statusBadgeClass = match ((string) ($task_data->dispatch_status_value ?? '')) {
                                                        '1' => 'bg-primary',   // 送出派工
                                                        '2' => 'bg-info',      // 已接收
                                                        '8' => 'bg-warning',   // 待確認
                                                        '9' => 'bg-success',   // 已完成
                                                        default => 'bg-secondary',
                                                    };
                                                @endphp
                                                <span class="badge plan-status-badge {{ $statusBadgeClass }}"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    title="{{ $task_data->dispatch_status_text }}">
                                                    {{ $statusShortText }}
                                                </span>
                                            </div>
                                            <div class="col-lg-2 mb-2 mb-lg-0 plan-order-col plan-equal-col">
                                                <label class="d-lg-none small text-muted">表訂時間</label>
                                                <input type="date"
                                                    class="form-control form-control-sm plan-order-date"
                                                    name="order_dates[]"
                                                    value="{{ $task_data->order_date }}"
                                                    data-row="{{ $key }}"
                                                    data-link-days="{{ (int) ($task_data->link_days ?? 0) }}"
                                                    data-duration-minutes="{{ (int) ($task_data->duration_minutes ?? 0) }}"
                                                    @if ($isLevelTwo) readonly @endif>
                                                <div class="small text-muted mt-1 plan-dispatch-estimated-end">
                                                    派工表訂完成：
                                                    {{ $task_data->dispatch_estimated_end ?? '尚未建立' }}
                                                </div>
                                            </div>
                                            <div class="col-lg-3 mb-2 mb-lg-0 plan-executor-col plan-equal-col">
                                                <label class="d-lg-none small text-muted">派工與負責執行人員</label>
                                                @php
                                                    $assigneeStatusRows = collect($task_data->executor_rows)
                                                        ->filter(fn($r) => !empty($r['user_id']))
                                                        ->map(function ($r) {
                                                            $name = $r['user_name'] ?? '未指定';
                                                            $status = $r['status_text'] ?? '未派工';
                                                            return e($name . '：' . $status);
                                                        })
                                                        ->values()
                                                        ->all();
                                                    $assigneeStatusHtml = !empty($assigneeStatusRows)
                                                        ? implode('<br>', $assigneeStatusRows)
                                                        : '尚未派工給執行人員';
                                                    $assignedNames = collect($task_data->executor_rows)
                                                        ->filter(fn($r) => !empty($r['user_id']) && !empty($r['user_name']))
                                                        ->pluck('user_name')
                                                        ->unique()
                                                        ->values();
                                                    $assignedSummary = $assignedNames->isNotEmpty()
                                                        ? ('已派工：' . $assignedNames->take(2)->implode('、'))
                                                        : '尚未派工';
                                                @endphp
                                                @if (!$isLevelTwo)
                                                    @if ((string) ($task_data->dispatch_status_value ?? '') === '8' && !empty($task_data->linked_task_id))
                                                        <button type="button"
                                                            class="btn btn-outline-warning btn-sm plan-dispatch-btn open-confirm-dispatch-modal"
                                                            data-task-id="{{ $task_data->linked_task_id }}"
                                                            data-stage-label="【{{ optional($task_data->check_status_data)->name }}】{{ $task_data->name }}"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-html="true"
                                                            data-bs-placement="top"
                                                            title="{!! $assigneeStatusHtml !!}">
                                                            <span class="plan-dispatch-btn-text">{{ $assignedSummary }}</span>
                                                        </button>
                                                    @else
                                                        <button type="button"
                                                            class="btn btn-outline-primary btn-sm plan-dispatch-btn open-dispatch-modal"
                                                            data-row-key="{{ $key }}"
                                                            data-stage-label="【{{ optional($task_data->check_status_data)->name }}】{{ $task_data->name }}"
                                                            data-task-name="{{ $task_data->name }}"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-html="true"
                                                            data-bs-placement="top"
                                                            title="{!! $assigneeStatusHtml !!}">
                                                            <span class="plan-dispatch-btn-text">{{ $assignedSummary }}</span>
                                                        </button>
                                                    @endif
                                                @elseif ($task_data->can_report_completion)
                                                    <button type="button" class="btn btn-outline-success btn-sm plan-dispatch-btn"
                                                        onclick="openCompletionModal({{ $task_data->my_task_item_id }}, @js($task_data->dispatch_comments))"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-html="true"
                                                        data-bs-placement="top"
                                                        title="{!! $assigneeStatusHtml !!}">
                                                        <span>回報派工進度</span>
                                                    </button>
                                                @else
                                                    <button type="button"
                                                        class="btn btn-outline-secondary btn-sm plan-dispatch-btn"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-html="true"
                                                        data-bs-placement="top"
                                                        title="{!! $assigneeStatusHtml !!}" disabled>
                                                        <span>{{ $assignedSummary }}</span>
                                                    </button>
                                                @endif
                                                <div class="plan-executor-hidden-inputs" data-row-key="{{ $key }}">
                                                    <input type="hidden" name="executor_task_comments[{{ $key }}]"
                                                        value="{{ $task_data->dispatch_task_comments ?? '' }}">
                                                    @foreach ($task_data->executor_rows as $er)
                                                        <input type="hidden" name="executor_user_ids[{{ $key }}][]"
                                                            value="{{ $er['user_id'] ?? '' }}">
                                                        <input type="hidden" name="executor_contexts[{{ $key }}][]"
                                                            value="{{ $er['context'] ?? '' }}">
                                                    @endforeach
                                                </div>
                                            </div>
                                            <input type="hidden" name="milestone_dates[]"
                                                value="{{ $task_data->milestone_date }}">
                                            <input type="hidden" name="dispatch_estimated_end_datetimes[]"
                                                value="{{ $task_data->linked_task_estimated_end ?? '' }}">
                                            <div class="col-lg-2 mb-2 mb-lg-0 plan-date-col plan-equal-col">
                                                <label class="d-lg-none small text-muted">實際完成時間</label>
                                                <input type="date" class="form-control form-control-sm"
                                                    name="formal_dates[]"
                                                    value="{{ $task_data->formal_date }}"
                                                    placeholder="正式時間" @if ($isLevelTwo) readonly @endif>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div> <!-- end col-->
                    </div> <!-- end col-->
                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            @if (!$isLevelTwo)
                                <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                        class="fe-check-circle me-1"></i>儲存</button>
                            @endif
                            <button type="reset" class="btn btn-secondary waves-effect waves-light m-1"
                                onclick="history.go(-1)"><i class="fe-x me-1"></i>回上一頁</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            </form>
        </div> <!-- end card-body -->
    </div> <!-- end card-->
    <!-- end row -->

    </div> <!-- container -->

    <div id="dispatchModal" class="modal fade dispatch-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable dispatch-modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">派工設定 <span id="dispatchStageTitle" class="text-muted"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="dispatchScheduleSection" class="dispatch-modal-schedule-foot border rounded p-3 mb-2 bg-light">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="d-block small text-muted mb-1">預計完成時間</label>
                                <input type="text" class="form-control form-control-sm" id="dispatchEstimatedEndDisplay"
                                    readonly placeholder="尚未建立">
                            </div>
                            <div class="col-md-6">
                                <label class="d-block small text-muted mb-1">時長（小時）</label>
                                <input type="text" class="form-control form-control-sm" id="dispatchDurationDisplay"
                                    readonly placeholder="—">
                            </div>
                        </div>
                    </div>
                    <p class="form-text mb-3" id="dispatchScheduleNote">依表訂時間與執行時數自動計算。</p>
                    <div id="dispatchEditorRows"></div>
                    <button type="button" class="btn btn-link p-0 mt-1" id="addDispatchEditorRow">+ 新增執行人員</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" id="saveDispatchEditor">儲存派工</button>
                </div>
            </div>
        </div>
    </div>

    <div id="confirmDispatchModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">派工確認 <span id="confirmDispatchStageTitle" class="text-muted"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="confirmDispatchRows" class="list-group"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
                </div>
            </div>
        </div>
    </div>

    <div id="completionModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">任務詳情</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="completionForm">
                        <div class="mb-3">
                            <label for="completionStatus" class="form-label">變更狀態</label>
                            <select id="completionStatus" class="form-select" onchange="handleCompletionStatus(this.value)">
                                <option value="not-started">已被指派，待確認</option>
                                <option value="in-progress">已接收</option>
                                <option value="implement">執行中</option>
                                <option value="completed">已完成</option>
                            </select>
                        </div>
                        <div class="mb-3" id="completionFields" style="display: none;">
                            <label class="form-label">實際完成日期：<span class="text-danger">*</span></label>
                            <div class="input-group mb-2">
                                <input type="date" class="form-control" id="completionEndDate" required>
                                <input type="time" class="form-control" id="completionEndTime" required>
                            </div>
                            <label for="completionExecutionTime" class="form-label">執行時間 (小時)</label>
                            <input type="text" id="completionExecutionTime" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">派工描述</label>
                            <textarea class="form-control" id="completionComments" rows="4" readonly></textarea>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="submitCompletion()">保存</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        (function() {
            const isLevelTwo = @json($isLevelTwo);
            let currentTaskItemId = null;
            let currentDispatchRowKey = null;
            let currentDispatchTaskName = '';
            let currentDispatchTaskDescription = '';
            let currentConfirmTaskId = null;
            const userNameMap = @json($users->pluck('name', 'id')->toArray());
            const planTaskMetaByRow = @json($planTaskMetaByRow);

            function formatIsoDate(d) {
                const y = d.getFullYear();
                const m = String(d.getMonth() + 1).padStart(2, '0');
                const day = String(d.getDate()).padStart(2, '0');
                return y + '-' + m + '-' + day;
            }

            function formatIsoDateTime(d) {
                const hh = String(d.getHours()).padStart(2, '0');
                const mm = String(d.getMinutes()).padStart(2, '0');
                return formatIsoDate(d) + ' ' + hh + ':' + mm + ':00';
            }

            function isWeekend(d) {
                const day = d.getDay();
                return day === 0 || day === 6;
            }

            // 以「執行天數」概念計算表訂：3 天代表起始日算第 1 天（先跳過週六日）。
            function addBusinessDaysInclusive(isoDateStr, days) {
                if (!isoDateStr || days === undefined || days === null) {
                    return isoDateStr;
                }
                const totalDays = parseInt(days, 10);
                if (isNaN(totalDays) || totalDays <= 0) {
                    return isoDateStr;
                }

                const d = new Date(isoDateStr + 'T12:00:00');
                if (isNaN(d.getTime())) {
                    return isoDateStr;
                }

                // 起始日若為週末，先移到下一個工作日再起算。
                while (isWeekend(d)) {
                    d.setDate(d.getDate() + 1);
                }

                let remaining = totalDays - 1; // 起始日算第 1 天
                while (remaining > 0) {
                    d.setDate(d.getDate() + 1);
                    if (isWeekend(d)) {
                        continue;
                    }
                    remaining--;
                }

                return formatIsoDate(d);
            }

            let syncPlanMilestoneDates = null;

            function bindOrderCascade() {
                const inputs = document.querySelectorAll('.plan-order-date');

                function toSlashDateTime(d) {
                    const y = d.getFullYear();
                    const m = String(d.getMonth() + 1).padStart(2, '0');
                    const day = String(d.getDate()).padStart(2, '0');
                    const hh = String(d.getHours()).padStart(2, '0');
                    const mm = String(d.getMinutes()).padStart(2, '0');
                    return `${y}/${m}/${day} ${hh}:${mm}`;
                }

                function addWorkingMinutesFromDateTime(startAt, minutes) {
                    if (!startAt || isNaN(startAt.getTime())) {
                        return null;
                    }
                    let remain = Number(minutes || 0);
                    if (!Number.isFinite(remain) || remain < 0) {
                        remain = 0;
                    }

                    let t = new Date(startAt.getTime());
                    while (remain > 0) {
                        const workStart = new Date(t.getFullYear(), t.getMonth(), t.getDate(), 9, 0, 0, 0);
                        const lunchStart = new Date(t.getFullYear(), t.getMonth(), t.getDate(), 12, 0, 0, 0);
                        const lunchEnd = new Date(t.getFullYear(), t.getMonth(), t.getDate(), 13, 0, 0, 0);
                        const workEnd = new Date(t.getFullYear(), t.getMonth(), t.getDate(), 18, 0, 0, 0);

                        if (t < workStart) {
                            t = workStart;
                            continue;
                        }
                        if (t >= lunchStart && t < lunchEnd) {
                            t = lunchEnd;
                            continue;
                        }
                        if (t >= workEnd) {
                            t = new Date(t.getFullYear(), t.getMonth(), t.getDate() + 1, 9, 0, 0, 0);
                            continue;
                        }

                        const segmentEnd = t < lunchStart ? lunchStart : workEnd;
                        const available = Math.max(0, Math.floor((segmentEnd - t) / 60000));
                        if (available <= 0) {
                            t = segmentEnd;
                            continue;
                        }

                        const consume = Math.min(remain, available);
                        t = new Date(t.getTime() + consume * 60000);
                        remain -= consume;
                    }

                    return t;
                }

                function addWorkingMinutesSkippingLunch(baseDateIso, minutes) {
                    if (!baseDateIso) {
                        return null;
                    }

                    const [y, m, d] = baseDateIso.split('-').map(v => parseInt(v, 10));
                    if (!y || !m || !d) {
                        return null;
                    }

                    // 第一階段：表訂日當天 09:00 起算。
                    const startAt = new Date(y, m - 1, d, 9, 0, 0, 0);
                    return addWorkingMinutesFromDateTime(startAt, minutes);
                }

                function isManualOrder(input) {
                    return input.getAttribute('data-manual-order') === '1';
                }

                function getEstimatedEndDateTime(input) {
                    const row = parseInt(input.getAttribute('data-row'), 10);
                    const orderDate = String(input.value || '').trim();
                    const durationMinutes = parseInt(input.getAttribute('data-duration-minutes') || '0', 10);

                    if (!orderDate) {
                        return null;
                    }

                    // 第一列，或使用者手動改表訂日：從該日 09:00 起算。
                    if (isNaN(row) || row <= 0 || isManualOrder(input)) {
                        return addWorkingMinutesSkippingLunch(orderDate, durationMinutes);
                    }

                    const prevInput = inputs[row - 1];
                    if (!prevInput) {
                        return addWorkingMinutesSkippingLunch(orderDate, durationMinutes);
                    }

                    const prevEnd = getEstimatedEndDateTime(prevInput);
                    if (!prevEnd) {
                        return addWorkingMinutesSkippingLunch(orderDate, durationMinutes);
                    }

                    // 第二列起：自前一段完成時刻累加本列執行時數。
                    return addWorkingMinutesFromDateTime(prevEnd, durationMinutes);
                }

                function refreshDispatchEstimatedEnd(input) {
                    const row = input.closest('.plan-order-col');
                    const label = row ? row.querySelector('.plan-dispatch-estimated-end') : null;
                    if (!label) {
                        return;
                    }

                    const orderDate = String(input.value || '').trim();
                    if (!orderDate) {
                        label.textContent = '派工表訂完成：尚未建立';
                        return;
                    }

                    const estimated = getEstimatedEndDateTime(input);
                    label.textContent = '派工表訂完成：' + (estimated ? toSlashDateTime(estimated) : '尚未建立');
                }

                // 第二筆起：表訂日對齊前一段完成日（＋專案階段表訂連動天數）。
                function computeNextOrderDateFromPrevious(prevInput, linkDays) {
                    const prevEnd = getEstimatedEndDateTime(prevInput);
                    if (!prevEnd) {
                        return '';
                    }

                    let d = new Date(prevEnd.getFullYear(), prevEnd.getMonth(), prevEnd.getDate(), 12, 0, 0);
                    while (isWeekend(d)) {
                        d.setDate(d.getDate() + 1);
                    }

                    let iso = formatIsoDate(d);
                    const link = parseInt(linkDays || 0, 10);
                    if (link > 1) {
                        iso = addBusinessDaysInclusive(iso, link);
                    }
                    return iso;
                }

                function refreshAllEstimatedEnds() {
                    inputs.forEach(function(input) {
                        refreshDispatchEstimatedEnd(input);
                    });
                }

                function cascadeFromRow(startRow) {
                    const n = inputs.length;
                    for (let j = Math.max(startRow + 1, 1); j < n; j++) {
                        const prevInput = inputs[j - 1];
                        if (!prevInput || !prevInput.value) {
                            continue;
                        }
                        inputs[j].removeAttribute('data-manual-order');
                        const linkDays = parseInt(inputs[j].getAttribute('data-link-days') || '0', 10);
                        inputs[j].value = computeNextOrderDateFromPrevious(prevInput, linkDays);
                    }
                    refreshAllEstimatedEnds();
                }

                syncPlanMilestoneDates = function() {
                    document.querySelectorAll('.plan-milestone-row').forEach(function(row) {
                        const orderInput = row.querySelector('.plan-order-date');
                        const milestoneInput = row.querySelector('input[name="milestone_dates[]"]');
                        const estimatedEndInput = row.querySelector('input[name="dispatch_estimated_end_datetimes[]"]');
                        if (!orderInput || !milestoneInput) {
                            return;
                        }
                        const estimated = getEstimatedEndDateTime(orderInput);
                        milestoneInput.value = estimated ? formatIsoDate(estimated) : (orderInput.value || '');
                        if (estimatedEndInput) {
                            estimatedEndInput.value = estimated ? formatIsoDateTime(estimated) : '';
                        }
                    });
                };

                inputs.forEach(function(input) {
                    refreshDispatchEstimatedEnd(input);
                    input.addEventListener('change', function() {
                        const row = parseInt(input.getAttribute('data-row'), 10);
                        const n = inputs.length;
                        if (isNaN(row) || n === 0) {
                            return;
                        }

                        if (row > 0) {
                            input.setAttribute('data-manual-order', '1');
                        } else {
                            input.removeAttribute('data-manual-order');
                        }

                        cascadeFromRow(row);
                    });
                });

                refreshAllEstimatedEnds();
                syncPlanMilestoneDates();

                const planForm = document.getElementById('plan-form');
                if (planForm) {
                    planForm.addEventListener('submit', function() {
                        syncPlanMilestoneDates();
                    });
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                if (!isLevelTwo) {
                    bindOrderCascade();
                }
            });

            function refreshExecutorSummary(scope) {
                const rows = (scope || document).querySelectorAll('.plan-milestone-row');
                rows.forEach(function(row) {
                    const names = [];
                    const rowKey = row.getAttribute('data-row-index');
                    const hiddenUsers = row.querySelectorAll(`input[name="executor_user_ids[${rowKey}][]"]`);
                    hiddenUsers.forEach(function(input) {
                        const userId = String(input.value || '').trim();
                        if (userId && userNameMap[userId]) {
                            names.push(userNameMap[userId]);
                        }
                    });
                    const dispatchBtn = row.querySelector('.open-dispatch-modal');
                    if (!dispatchBtn) return;
                    const summaryText = dispatchBtn.querySelector('.plan-dispatch-btn-text');
                    const uniqueNames = Array.from(new Set(names));
                    if (summaryText) {
                        summaryText.textContent = uniqueNames.length === 0 ?
                            '尚未派工' :
                            `已派工：${uniqueNames.slice(0, 2).join('、')}`;
                    }
                });
            }

            function formatDurationNumber(hours) {
                const n = Number(hours);
                if (!Number.isFinite(n)) {
                    return '—';
                }
                return parseFloat(n.toFixed(2)).toString();
            }

            function getRowDispatchScheduleInfo(rowKey) {
                const row = document.querySelector(`.plan-milestone-row[data-row-index="${rowKey}"]`);
                const meta = planTaskMetaByRow[rowKey] || {};
                let estimatedEnd = meta.dispatchEstimatedEnd || '尚未建立';
                let duration = formatDurationNumber(meta.durationHours);

                if (row) {
                    const estimatedLabel = row.querySelector('.plan-dispatch-estimated-end');
                    if (estimatedLabel) {
                        const text = estimatedLabel.textContent.replace(/^派工表訂完成：\s*/, '').trim();
                        if (text && text !== '尚未建立') {
                            estimatedEnd = text;
                        }
                    }
                }

                return {
                    estimatedEnd: estimatedEnd || '尚未建立',
                    duration: duration || '—',
                };
            }

            function createDispatchEditorEntry(userId, context, comments) {
                const options = ['<option value="">請選擇</option>'];
                Object.keys(userNameMap).forEach(function(id) {
                    const selected = String(userId || '') === String(id) ? ' selected' : '';
                    options.push(`<option value="${id}"${selected}>${userNameMap[id]}</option>`);
                });
                const safeContext = $('<div/>').text(context || '').html();
                const safeComments = $('<div/>').text(comments || '').html();
                return `
                    <div class="dispatch-editor-entry border rounded p-3 mb-3 bg-light">
                        <div class="d-flex justify-content-end mb-2">
                            <button type="button" class="btn btn-danger btn-sm remove-dispatch-editor-row" tabindex="-1" aria-label="移除執行人員">
                                <i class="mdi mdi-trash-can-outline"></i>
                            </button>
                        </div>
                        <div class="mb-3">
                            <label class="d-block small text-muted mb-1">執行人員</label>
                            <select class="form-select w-100 dispatch-editor-user">${options.join('')}</select>
                        </div>
                        <div class="mb-3">
                            <label class="d-block small text-muted mb-1">派工項目</label>
                            <textarea class="form-control w-100 dispatch-editor-context" rows="4" placeholder="派工項目（自動帶入項目名稱，可修改）">${safeContext}</textarea>
                        </div>
                        <div class="mb-0">
                            <label class="d-block small text-muted mb-1">派工描述</label>
                            <textarea class="form-control w-100 dispatch-editor-comments" rows="4" placeholder="派工描述（自動帶入項目說明，可修改）">${safeComments}</textarea>
                        </div>
                    </div>
                `;
            }

            function openDispatchModal(rowKey, stageLabel, taskName, taskDescription) {
                currentDispatchRowKey = rowKey;
                currentDispatchTaskName = taskName || '';
                currentDispatchTaskDescription = taskDescription || '';
                const modal = new bootstrap.Modal(document.getElementById('dispatchModal'));
                const editor = document.getElementById('dispatchEditorRows');
                const stageTitle = document.getElementById('dispatchStageTitle');
                const hiddenWrap = document.querySelector(`.plan-executor-hidden-inputs[data-row-key="${rowKey}"]`);
                const userInputs = hiddenWrap ? hiddenWrap.querySelectorAll(`input[name="executor_user_ids[${rowKey}][]"]`) : [];
                const contextInputs = hiddenWrap ? hiddenWrap.querySelectorAll(`input[name="executor_contexts[${rowKey}][]"]`) : [];
                const commentsInput = hiddenWrap ? hiddenWrap.querySelector(`input[name="executor_task_comments[${rowKey}]"]`) : null;
                let taskComments = commentsInput ? commentsInput.value : '';
                if (!String(taskComments || '').trim() && currentDispatchTaskDescription) {
                    taskComments = currentDispatchTaskDescription;
                }

                if (stageTitle) {
                    stageTitle.textContent = stageLabel ? `－ ${stageLabel}` : '';
                }

                const scheduleInfo = getRowDispatchScheduleInfo(rowKey);
                const estimatedEndDisplay = document.getElementById('dispatchEstimatedEndDisplay');
                const durationDisplay = document.getElementById('dispatchDurationDisplay');
                if (estimatedEndDisplay) {
                    estimatedEndDisplay.value = scheduleInfo.estimatedEnd;
                }
                if (durationDisplay) {
                    durationDisplay.value = scheduleInfo.duration;
                }

                editor.innerHTML = '';
                const length = Math.max(userInputs.length, contextInputs.length, 1);
                for (let i = 0; i < length; i++) {
                    const userId = userInputs[i] ? userInputs[i].value : '';
                    let context = contextInputs[i] ? contextInputs[i].value : '';
                    if (!String(context || '').trim() && currentDispatchTaskName) {
                        context = currentDispatchTaskName;
                    }
                    editor.insertAdjacentHTML('beforeend', createDispatchEditorEntry(userId, context, taskComments));
                }

                modal.show();
            }

            function slashDateTimeToIso(value) {
                const text = String(value || '').trim();
                if (!text || text === '尚未建立') {
                    return '';
                }
                const normalized = text.replace(/\//g, '-');
                const match = normalized.match(/^(\d{4}-\d{2}-\d{2})\s+(\d{2}:\d{2})(?::\d{2})?$/);
                if (!match) {
                    return '';
                }
                return match[1] + ' ' + match[2] + ':00';
            }

            function syncCurrentRowEstimatedEndHidden(rowKey) {
                const row = document.querySelector(`.plan-milestone-row[data-row-index="${rowKey}"]`);
                if (!row) {
                    return;
                }
                const estimatedEndInput = row.querySelector('input[name="dispatch_estimated_end_datetimes[]"]');
                if (!estimatedEndInput) {
                    return;
                }
                const scheduleInfo = getRowDispatchScheduleInfo(rowKey);
                const isoEnd = slashDateTimeToIso(scheduleInfo.estimatedEnd);
                if (isoEnd) {
                    estimatedEndInput.value = isoEnd;
                }
            }

            function saveDispatchModal() {
                if (currentDispatchRowKey === null) {
                    return;
                }

                const rowKey = currentDispatchRowKey;
                const rows = document.querySelectorAll('#dispatchEditorRows .dispatch-editor-entry');
                const selectedUserIds = Array.from(rows).map(function(entry) {
                    return String(entry.querySelector('.dispatch-editor-user')?.value || '').trim();
                }).filter(Boolean);

                if (selectedUserIds.length === 0) {
                    alert('必須要有選執行人員，才可以進行儲存');
                    const firstUserSelect = document.querySelector('#dispatchEditorRows .dispatch-editor-user');
                    if (firstUserSelect) {
                        firstUserSelect.focus();
                    }
                    return;
                }

                const hiddenWrap = document.querySelector(`.plan-executor-hidden-inputs[data-row-key="${rowKey}"]`);
                if (!hiddenWrap) {
                    return;
                }

                hiddenWrap.innerHTML = '';
                let taskComments = '';
                rows.forEach(function(entry) {
                    const userId = entry.querySelector('.dispatch-editor-user').value || '';
                    const context = entry.querySelector('.dispatch-editor-context').value || '';
                    const commentsEl = entry.querySelector('.dispatch-editor-comments');
                    const commentsVal = commentsEl ? String(commentsEl.value || '').trim() : '';
                    if (commentsVal && !taskComments) {
                        taskComments = commentsEl.value;
                    }

                    const userInput = document.createElement('input');
                    userInput.type = 'hidden';
                    userInput.name = `executor_user_ids[${rowKey}][]`;
                    userInput.value = userId;
                    hiddenWrap.appendChild(userInput);

                    const contextInput = document.createElement('input');
                    contextInput.type = 'hidden';
                    contextInput.name = `executor_contexts[${rowKey}][]`;
                    contextInput.value = context;
                    hiddenWrap.appendChild(contextInput);
                });

                const commentsInput = document.createElement('input');
                commentsInput.type = 'hidden';
                commentsInput.name = `executor_task_comments[${rowKey}]`;
                commentsInput.value = taskComments;
                hiddenWrap.appendChild(commentsInput);

                if (hiddenWrap.querySelectorAll(`input[name="executor_user_ids[${rowKey}][]"]`).length === 0) {
                    const userInput = document.createElement('input');
                    userInput.type = 'hidden';
                    userInput.name = `executor_user_ids[${rowKey}][]`;
                    userInput.value = '';
                    hiddenWrap.appendChild(userInput);

                    const contextInput = document.createElement('input');
                    contextInput.type = 'hidden';
                    contextInput.name = `executor_contexts[${rowKey}][]`;
                    contextInput.value = '';
                    hiddenWrap.appendChild(contextInput);
                }

                const modalEl = document.getElementById('dispatchModal');
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) {
                    modal.hide();
                }
                refreshExecutorSummary(document);

                const planForm = document.getElementById('plan-form');
                if (planForm) {
                    syncCurrentRowEstimatedEndHidden(rowKey);
                    if (typeof syncPlanMilestoneDates === 'function') {
                        syncPlanMilestoneDates();
                    }
                    const saveBtn = document.getElementById('saveDispatchEditor');
                    if (saveBtn) {
                        saveBtn.disabled = true;
                        saveBtn.textContent = '儲存中...';
                    }
                    const formData = new FormData(planForm);
                    fetch(planForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    }).then(async function(response) {
                        if (response.ok) {
                            location.reload();
                            return;
                        }
                        let message = '派工儲存失敗，請稍後再試。';
                        try {
                            const data = await response.json();
                            if (data && data.message) {
                                message = data.message;
                            }
                        } catch (e) {
                            // ignore parse error
                        }
                        throw new Error(message);
                    }).catch(function(err) {
                        alert(err && err.message ? err.message : '派工儲存失敗，請稍後再試。');
                        if (saveBtn) {
                            saveBtn.disabled = false;
                            saveBtn.textContent = '儲存派工';
                        }
                    });
                }
            }

            function getTaskItemStatusText(statusValue) {
                const mapping = {
                    0: '已發送，待確認',
                    1: '已接收',
                    2: '執行中',
                    8: '已完成，待確認',
                    9: '已確認完成'
                };
                return mapping[statusValue] || '未知狀態';
            }

            function renderConfirmDispatchRows(items) {
                const container = document.getElementById('confirmDispatchRows');
                if (!container) return;
                container.innerHTML = '';
                if (!items || items.length === 0) {
                    container.innerHTML = '<div class="text-muted">目前沒有可確認的人員。</div>';
                    return;
                }

                items.forEach(function(item) {
                    const statusValue = Number(item.status || 0);
                    const canConfirm = statusValue === 8;
                    const rowHtml = `
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <div><strong>${item.user_name || '未指定'}</strong></div>
                                <small class="text-muted">${getTaskItemStatusText(statusValue)}</small>
                            </div>
                            <button type="button"
                                class="btn btn-sm ${canConfirm ? 'btn-success confirm-dispatch-item' : 'btn-secondary'}"
                                data-item-id="${item.id}"
                                ${canConfirm ? '' : 'disabled'}>
                                ${canConfirm ? '確認完成' : '已確認'}
                            </button>
                        </div>
                    `;
                    container.insertAdjacentHTML('beforeend', rowHtml);
                });
            }

            function openConfirmDispatchModal(taskId, stageLabel) {
                currentConfirmTaskId = taskId;
                const modal = new bootstrap.Modal(document.getElementById('confirmDispatchModal'));
                const stageTitle = document.getElementById('confirmDispatchStageTitle');
                if (stageTitle) {
                    stageTitle.textContent = stageLabel ? `－ ${stageLabel}` : '';
                }

                fetch(`/api/task/${taskId}`)
                    .then(response => response.json())
                    .then(data => {
                        renderConfirmDispatchRows(data.items || []);
                        modal.show();
                    })
                    .catch(() => {
                        alert('無法載入確認資料，請稍後再試。');
                    });
            }

            $(document).on('click', '.open-dispatch-modal', function() {
                const rowKey = $(this).data('row-key');
                const stageLabel = $(this).data('stage-label');
                const meta = planTaskMetaByRow[rowKey] || {};
                const taskName = meta.name || $(this).data('task-name') || '';
                const taskDescription = meta.description || '';
                openDispatchModal(rowKey, stageLabel, taskName, taskDescription);
            });

            $(document).on('click', '.open-confirm-dispatch-modal', function() {
                const taskId = $(this).data('task-id');
                const stageLabel = $(this).data('stage-label');
                openConfirmDispatchModal(taskId, stageLabel);
            });

            $(document).on('click', '#addDispatchEditorRow', function() {
                const hiddenWrap = currentDispatchRowKey !== null
                    ? document.querySelector(`.plan-executor-hidden-inputs[data-row-key="${currentDispatchRowKey}"]`)
                    : null;
                const commentsInput = hiddenWrap
                    ? hiddenWrap.querySelector(`input[name="executor_task_comments[${currentDispatchRowKey}]"]`)
                    : null;
                let taskComments = commentsInput ? commentsInput.value : '';
                if (!String(taskComments || '').trim()) {
                    const firstComments = document.querySelector('#dispatchEditorRows .dispatch-editor-comments');
                    taskComments = firstComments ? firstComments.value : currentDispatchTaskDescription;
                }
                $('#dispatchEditorRows').append(createDispatchEditorEntry('', currentDispatchTaskName, taskComments));
            });

            $(document).on('click', '.remove-dispatch-editor-row', function() {
                const rows = $('#dispatchEditorRows .dispatch-editor-entry');
                if (rows.length > 1) {
                    $(this).closest('.dispatch-editor-entry').remove();
                } else {
                    alert('至少保留一組執行人員欄位');
                }
            });

            $(document).on('click', '#saveDispatchEditor', saveDispatchModal);

            $(document).on('click', '.confirm-dispatch-item', function() {
                const taskItemId = $(this).data('item-id');
                fetch(`/tasks/${taskItemId}/update-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        status: 'confirmed'
                    })
                }).then(response => {
                    if (response.ok) {
                        if (currentConfirmTaskId) {
                            return fetch(`/api/task/${currentConfirmTaskId}`)
                                .then(r => r.json())
                                .then(data => {
                                    renderConfirmDispatchRows(data.items || []);
                                    const statuses = (data.items || []).map(i => Number(i.status || 0));
                                    if (statuses.length > 0 && statuses.every(s => s === 9)) {
                                        location.reload();
                                    }
                                });
                        }
                    } else {
                        alert('確認失敗，請稍後再試。');
                    }
                });
            });

            document.addEventListener('DOMContentLoaded', function() {
                refreshExecutorSummary(document);
                document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function(el) {
                    new bootstrap.Tooltip(el);
                });
            });

            window.openCompletionModal = function(taskItemId, comments) {
                currentTaskItemId = taskItemId;
                const modal = new bootstrap.Modal(document.getElementById('completionModal'));
                document.getElementById('completionComments').value = comments || '';

                fetch(`/person/task/edit/${taskItemId}`)
                    .then(response => response.json())
                    .then(data => {
                        const statusMap = {
                            0: 'not-started',
                            1: 'in-progress',
                            2: 'implement',
                            8: 'completed'
                        };
                        const mappedStatus = statusMap[data.status] || 'not-started';
                        document.getElementById('completionStatus').value = mappedStatus;
                        document.getElementById('completionEndDate').value = data.end_date || '';
                        document.getElementById('completionEndTime').value = data.end_time || '';
                        document.getElementById('completionExecutionTime').value = data.execution_time || '';
                        handleCompletionStatus(mappedStatus);
                        modal.show();
                    })
                    .catch(() => {
                        alert('無法載入任務詳情，請稍後再試。');
                    });
            };

            window.handleCompletionStatus = function(status) {
                const completionFields = document.getElementById('completionFields');
                completionFields.style.display = status === 'completed' ? 'block' : 'none';
            };

            window.submitCompletion = function() {
                if (!currentTaskItemId) {
                    return;
                }

                const status = document.getElementById('completionStatus').value;
                const endDate = document.getElementById('completionEndDate').value;
                const endTime = document.getElementById('completionEndTime').value;
                const executionTime = document.getElementById('completionExecutionTime').value;

                if (status === 'completed' && (!endDate || !endTime)) {
                    alert('狀態為「已完成」時，請填寫實際完成日期與時間。');
                    return;
                }

                fetch(`/tasks/${currentTaskItemId}/update-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        status: status,
                        end_date: endDate,
                        end_time: endTime,
                        execution_time: executionTime
                    })
                }).then(response => {
                    if (response.ok) {
                        location.reload();
                    } else {
                        alert('更新狀態失敗！');
                    }
                });
            };
        })();
    </script>
@endsection
