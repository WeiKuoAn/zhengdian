@extends('layouts.vertical', ['title' => '派工項目確認'])
@section('css')
    @vite(['node_modules/spectrum-colorpicker2/dist/spectrum.min.css', 'node_modules/flatpickr/dist/flatpickr.min.css', 'node_modules/clockpicker/dist/bootstrap-clockpicker.min.css', 'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css'])
@endsection
@section('content')
    <div class="container-fluid">

        @include('layouts.shared.page-title', [
            'title' => '派工項目確認',
            'subtitle' => '派工項目確認',
        ])

        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('task.check.data', $data->id) }}" method="POST" id="checkForm">
                            @csrf
                            <div class="row">
                                <div class="mb-3">
                                    <label class="col-form-label">專案名稱：</label>
                                    <select class="form-control" data-width="100%" name="project_id" disabled>
                                        <option value="">請選擇</option>
                                        @foreach ($cust_projects as $cust_project)
                                            <option value="{{ $cust_project->id }}"
                                                {{ $data->project_id == $cust_project->id ? 'selected' : '' }}>
                                                【{{ optional($cust_project->user_data)->name }}】{{ $cust_project->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">專案執行階段：</label>
                                    <select class="form-control" data-width="100%" name="check_status_id" disabled>
                                        <option value="">請選擇</option>
                                        @foreach ($check_statuss as $check_status)
                                            <optgroup label="{{ $check_status->name }}">
                                                @foreach ($check_status->check_childrens as $check_children)
                                                    <option value="{{ $check_children->id }}"
                                                        {{ $data->check_status_id == $check_children->id ? 'selected' : '' }}>
                                                        {{ $check_children->name }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">任務項目</label>
                                    <select class="form-control" data-width="100%" name="template_id" disabled>
                                        @foreach ($task_templates as $task_template)
                                            <option value="{{ $task_template->id }}"
                                                {{ $data->template_id == $task_template->id ? 'selected' : '' }}>
                                                {{ $task_template->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    負責執行人員 / 執行內容 / 人員花費時間(hr) / 實際完成時間
                                </label>
                                @foreach ($data->items as $item)
                                    <div class="border rounded p-3 mb-3 bg-light">
                                        <div class="row g-2 mb-2 align-items-center">
                                            <div class="col-md-4">
                                                <select class="form-control" name="user_ids[]" disabled>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                            {{ $item->user_id == $user->id ? 'selected' : '' }}>
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" value="{{ $item->context }}" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" class="form-control"
                                                    value="{{ $item->done_time ? $item->done_time.' hr' : '' }}" readonly>
                                            </div>
                                        </div>
                                        <div class="row g-2">
                                            <div class="col-md-6">
                                                <input type="date" class="form-control"
                                                    value="{{ $item->end_time ? substr($item->end_time, 0, 10) : '' }}" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="time" class="form-control"
                                                    value="{{ $item->end_time ? substr($item->end_time, 11, 5) : '' }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mb-3">
                                <label class="form-label">原派工表訂完成時間（不變）</label>
                                <div class="input-group mb-2">
                                    <input type="date" class="form-control"
                                        value="{{ $data->estimated_end ? substr($data->estimated_end, 0, 10) : '' }}" disabled>
                                    <input type="time" class="form-control"
                                        value="{{ $data->estimated_end ? substr($data->estimated_end, 11, 5) : '' }}" disabled>
                                </div>
                            </div>

                            @if (!empty($data->adjusted_estimated_end))
                                <div class="mb-3">
                                    <label class="form-label">目前調整後預計完成時間</label>
                                    <div class="input-group mb-2">
                                        <input type="date" class="form-control"
                                            value="{{ substr($data->adjusted_estimated_end, 0, 10) }}" disabled>
                                        <input type="time" class="form-control"
                                            value="{{ substr($data->adjusted_estimated_end, 11, 5) }}" disabled>
                                    </div>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label class="form-label">優先序</label>
                                <select class="form-control" name="priority" disabled>
                                    <option value="0" {{ $data->priority == 0 ? 'selected' : '' }}>緊急</option>
                                    <option value="1" {{ $data->priority == 1 ? 'selected' : '' }}>高</option>
                                    <option value="2" {{ $data->priority == 2 ? 'selected' : '' }}>中</option>
                                    <option value="3" {{ $data->priority == 3 ? 'selected' : '' }}>低</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">任務項目描述</label>
                                <textarea class="form-control" rows="3" readonly>{{ $data->comments }}</textarea>
                            </div>

                            @if ((int) $data->status !== 9)
                                <div class="mb-3">
                                    <label class="form-label">確認結果<span class="text-danger">*</span></label>
                                    <select class="form-select" name="confirm_action" id="confirmAction" required>
                                        <option value="confirm">確認完成</option>
                                        <option value="adjust">需調整</option>
                                    </select>
                                </div>

                                <div id="adjustFields" class="border rounded p-3 mb-3 bg-warning-subtle" style="display:none;">
                                    <div class="mb-3">
                                        <label class="form-label">須調整完的預計時間<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="date" class="form-control" name="adjusted_estimated_end_date"
                                                id="adjustedEstimatedEndDate"
                                                value="{{ $data->adjusted_estimated_end ? substr($data->adjusted_estimated_end, 0, 10) : ($data->estimated_end ? substr($data->estimated_end, 0, 10) : '') }}">
                                            <input type="time" class="form-control" name="adjusted_estimated_end_time"
                                                id="adjustedEstimatedEndTime"
                                                value="{{ $data->adjusted_estimated_end ? substr($data->adjusted_estimated_end, 11, 5) : ($data->estimated_end ? substr($data->estimated_end, 11, 5) : '') }}">
                                        </div>
                                        <div class="form-text">此時間不會覆蓋原派工表訂完成時間，僅作為調整後期限。</div>
                                    </div>
                                    <div class="mb-0">
                                        <label class="form-label">調整說明<span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="adjustment_note" id="adjustmentNote" rows="3"
                                            placeholder="例如：資料不完整，請補齊後再回報" required></textarea>
                                    </div>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label class="form-label">調整紀錄</label>
                                @php $adjustments = $data->estimated_end_adjustments ?? collect(); @endphp
                                @if ($adjustments->isEmpty())
                                    <p class="text-muted mb-0">尚無調整紀錄</p>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>次序</th>
                                                    <th>調整時間</th>
                                                    <th>調整後預計完成</th>
                                                    <th>操作人</th>
                                                    <th>說明</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($adjustments as $row)
                                                    <tr>
                                                        <td>第{{ $loop->iteration }}次</td>
                                                        <td>{{ optional($row->created_at)->format('Y-m-d H:i') }}</td>
                                                        <td>{{ optional($row->adjusted_estimated_end)->format('Y-m-d H:i') }}</td>
                                                        <td>{{ optional($row->creator)->name ?? '—' }}</td>
                                                        <td>{{ $row->note ?: '—' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>

                            <div class="row mb-1">
                                <div class="col-12 text-center">
                                    @if ((int) $data->status !== 9)
                                        <button type="submit" class="btn btn-success waves-effect waves-light m-1" id="checkSubmitBtn">
                                            <i class="fe-check-circle me-1"></i>儲存變更
                                        </button>
                                    @endif
                                    <button type="button" class="btn btn-secondary waves-effect waves-light m-1"
                                        onclick="history.go(-1)">
                                        <i class="fe-x me-1"></i>回上一頁
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @vite(['resources/js/pages/form-pickers.init.js'])
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const actionEl = document.getElementById('confirmAction');
            const adjustFields = document.getElementById('adjustFields');
            const form = document.getElementById('checkForm');
            const submitBtn = document.getElementById('checkSubmitBtn');

            function syncAdjustUi() {
                if (!actionEl || !adjustFields) {
                    return;
                }
                const isAdjust = actionEl.value === 'adjust';
                adjustFields.style.display = isAdjust ? 'block' : 'none';
                const dateEl = document.getElementById('adjustedEstimatedEndDate');
                const timeEl = document.getElementById('adjustedEstimatedEndTime');
                const noteEl = document.getElementById('adjustmentNote');
                if (dateEl) dateEl.required = isAdjust;
                if (timeEl) timeEl.required = isAdjust;
                if (noteEl) noteEl.required = isAdjust;
                if (submitBtn) {
                    submitBtn.innerHTML = isAdjust
                        ? '<i class="fe-alert-triangle me-1"></i>設為需調整'
                        : '<i class="fe-check-circle me-1"></i>確認完成';
                    submitBtn.classList.toggle('btn-warning', isAdjust);
                    submitBtn.classList.toggle('btn-success', !isAdjust);
                }
            }

            if (actionEl) {
                actionEl.addEventListener('change', syncAdjustUi);
                syncAdjustUi();
            }

            if (form) {
                form.addEventListener('submit', function(e) {
                    const action = actionEl ? actionEl.value : 'confirm';
                    if (action === 'adjust') {
                        const dateEl = document.getElementById('adjustedEstimatedEndDate');
                        const timeEl = document.getElementById('adjustedEstimatedEndTime');
                        const noteEl = document.getElementById('adjustmentNote');
                        if (!dateEl?.value || !timeEl?.value) {
                            e.preventDefault();
                            alert('狀態為「需調整」時，請填寫須調整完的預計日期與時間。');
                            return;
                        }
                        if (!String(noteEl?.value || '').trim()) {
                            e.preventDefault();
                            alert('狀態為「需調整」時，請填寫調整說明。');
                            return;
                        }
                        if (!confirm('確定設為需調整？')) {
                            e.preventDefault();
                        }
                        return;
                    }
                    if (!confirm('是否已確定派工無誤？')) {
                        e.preventDefault();
                    }
                });
            }
        });
    </script>
@endsection
