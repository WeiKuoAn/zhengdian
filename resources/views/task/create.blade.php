@extends('layouts.vertical', ['title' => 'CRM Customers'])
@section('css')
    @vite(['node_modules/spectrum-colorpicker2/dist/spectrum.min.css', 'node_modules/flatpickr/dist/flatpickr.min.css', 'node_modules/clockpicker/dist/bootstrap-clockpicker.min.css', 'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css'])
    @vite(['node_modules/selectize/dist/css/selectize.bootstrap3.css', 'node_modules/mohithg-switchery/dist/switchery.min.css', 'node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css', 'node_modules/select2/dist/css/select2.min.css', 'node_modules/multiselect/css/multi-select.css'])
@endsection

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', [
            'title' => '派工新增',
            'subtitle' => '派工管理',
        ])

        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('task.create.data') }}" method="POST">
                            @csrf
                            @include('task.partials.list-filter-hiddens')
                            <div class="row">
                                <div class="mb-3">
                                    <label for="inputEmail3" class="col-4 col-xl-3 col-form-label">專案名稱：<span class="text-danger">*</span></label>
                                    <select class="form-control" data-toggle="select2" data-width="100%" name="project_id"
                                        required>
                                        <option value="" selected>請選擇</option>
                                        @foreach ($cust_projects as $key => $cust_project)
                                            <option value="{{ $cust_project->id }}">
                                                【{{ $cust_project->user_data->name }}】{{ $cust_project->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">專案執行階段：<span class="text-danger">*</span></label>
                                    <select class="form-control" data-toggle="select2" data-width="100%"
                                        name="check_status_id" required>
                                        <option value="" selected>請選擇</option>
                                        @foreach ($check_statuss as $key => $check_status)
                                            <optgroup label="{{ $check_status->name }}">
                                                @foreach ($check_status->check_childrens as $num => $check_children)
                                                    <option value="{{ $check_children->id }}">{{ $check_children->name }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="project-priority" class="form-label">派工項目<span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" data-toggle="select2" data-width="100%" name="template_id"
                                        required disabled>
                                        <option value="">請先選擇專案執行階段</option>
                                    </select>
                                    <div class="form-text">請先選擇專案執行階段，再從清單中挑選派工項目。</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">負責執行人員：<span class="text-danger">*</span></label>
                                    <div id="executor-container">
                                        @include('task.partials.executor-entry', ['users' => $users])
                                    </div>
                                    <button type="button" class="btn btn-link" id="add-executor">+ 新增更多人員或執行內容</button>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">預計完成日期：<span class="text-danger">*</span></label>
                                    <div class="mb-2">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="date_mode" id="date_mode_single" value="single"
                                                {{ old('date_mode', 'single') === 'single' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="date_mode_single">單一日期</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="date_mode" id="date_mode_recurring" value="recurring"
                                                {{ old('date_mode') === 'recurring' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="date_mode_recurring">週期（區間內每週固定星期）</label>
                                        </div>
                                    </div>

                                    <div id="single-date-panel" class="mb-2">
                                        <input type="date" class="form-control" id="end_date" name="estimated_end_date" value="{{ old('estimated_end_date') }}">
                                    </div>

                                    <div id="recurring-date-panel" class="border rounded p-2 mb-2" style="display: none;">
                                        <div class="input-group mb-2">
                                            <span class="input-group-text">從</span>
                                            <input type="date" class="form-control" id="recurring_start_date" name="recurring_start_date" value="{{ old('recurring_start_date') }}">
                                            <span class="input-group-text">到</span>
                                            <input type="date" class="form-control" id="recurring_end_date" name="recurring_end_date" value="{{ old('recurring_end_date') }}">
                                        </div>
                                        <div class="mb-1">
                                            @foreach ([1 => '一', 2 => '二', 3 => '三', 4 => '四', 5 => '五', 6 => '六', 0 => '日'] as $dow => $label)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input recurring-weekday" type="checkbox" name="recurring_weekdays[]"
                                                        id="weekday_{{ $dow }}" value="{{ $dow }}"
                                                        {{ in_array((string) $dow, array_map('strval', (array) old('recurring_weekdays', [])), true) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="weekday_{{ $dow }}">週{{ $label }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="form-text" id="recurring-preview">請選擇日期區間並勾選星期。</div>
                                    </div>

                                    <input type="time" class="form-control" id="end_time" placeholder="時間" required name="estimated_end_time" value="{{ old('estimated_end_time') }}">
                                </div>
                                <div class="mb-3">
                                    <label for="project-priority" class="form-label">優先序<span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" data-toggle="select" data-width="100%" name="priority">
                                        <option value="0">緊急</option>
                                        <option value="1">高</option>
                                        <option value="2">中</option>
                                        <option value="3">低</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">派工描述</label>
                                    <textarea class="form-control" id="floatingTextarea" name="comments" rows="3"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="project-priority" class="form-label">狀態<span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" data-toggle="select" data-width="100%" name="status">
                                        <option value="1">送出派工</option>
                                        <option value="2">接收派工</option>
                                        <option value="3">進行中</option>
                                        <option value="4">移轉</option>
                                        <option value="8">人員已完成，待確認</option>
                                        <option value="9">完成</option>
                                    </select>
                                </div>
                            </div> <!-- end col-->
                    </div>
                    <!-- end row -->
                    <div class="row mb-3">
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                    class="fe-check-circle me-1"></i>新增</button>
                            <a href="{{ route('task', $listQuery ?? []) }}" class="btn btn-secondary waves-effect waves-light m-1">
                                <i class="fe-x me-1"></i>回上一頁
                            </a>
                        </div>
                    </div>
                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col-->
        <!-- end row -->

    </div> <!-- container -->
@endsection
@section('script')
    @vite(['resources/js/pages/form-pickers.init.js'])
    @vite(['resources/js/pages/form-advanced.init.js'])
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @include('task.partials.template-by-stage-script')
    @include('task.partials.executor-fields-script')
    <script>
        $(document).ready(function() {
            bindExecutorFields();

            const RECURRING_MAX = 60;

            function isRecurringMode() {
                return $('input[name="date_mode"]:checked').val() === 'recurring';
            }

            function recurringDates() {
                const start = $('#recurring_start_date').val();
                const end = $('#recurring_end_date').val();
                const weekdays = $('.recurring-weekday:checked').map(function() {
                    return parseInt(this.value, 10);
                }).get();
                if (!start || !end || weekdays.length === 0) {
                    return null;
                }

                const dates = [];
                const cursor = new Date(start + 'T00:00:00');
                const last = new Date(end + 'T00:00:00');
                while (cursor <= last && dates.length <= RECURRING_MAX) {
                    if (weekdays.includes(cursor.getDay())) {
                        dates.push(new Date(cursor));
                    }
                    cursor.setDate(cursor.getDate() + 1);
                }
                return dates;
            }

            function renderRecurringPreview() {
                const $preview = $('#recurring-preview');
                const dates = recurringDates();
                if (dates === null) {
                    $preview.removeClass('text-danger').text('請選擇日期區間並勾選星期。');
                    return;
                }
                if (dates.length === 0) {
                    $preview.addClass('text-danger').text('此區間內沒有符合勾選星期的日期。');
                    return;
                }
                if (dates.length > RECURRING_MAX) {
                    $preview.addClass('text-danger').text('超過 ' + RECURRING_MAX + ' 筆，請縮短日期區間。');
                    return;
                }
                const names = ['日', '一', '二', '三', '四', '五', '六'];
                const labels = dates.map(function(d) {
                    return (d.getMonth() + 1) + '/' + d.getDate() + '（' + names[d.getDay()] + '）';
                });
                $preview.removeClass('text-danger').text('將建立 ' + dates.length + ' 筆派工：' + labels.join('、'));
            }

            function syncDateMode() {
                const recurring = isRecurringMode();
                $('#single-date-panel').toggle(!recurring);
                $('#recurring-date-panel').toggle(recurring);
                $('#end_date').prop('required', !recurring);
                $('#recurring_start_date, #recurring_end_date').prop('required', recurring);
                renderRecurringPreview();
            }

            $('input[name="date_mode"]').on('change', syncDateMode);
            $('#recurring_start_date, #recurring_end_date, .recurring-weekday').on('change', renderRecurringPreview);
            syncDateMode();

            $('form').on('submit', function(event) {
                const endTime = $('#end_time').val().trim();

                if (isRecurringMode()) {
                    const dates = recurringDates();
                    if (endTime === '' || dates === null) {
                        alert('請選擇週期日期區間、勾選星期並輸入時間！');
                        event.preventDefault();
                        return;
                    }
                    if (dates.length === 0 || dates.length > RECURRING_MAX) {
                        alert($('#recurring-preview').text());
                        event.preventDefault();
                        return;
                    }
                    if (!confirm('確定要建立 ' + dates.length + ' 筆派工嗎？')) {
                        event.preventDefault();
                    }
                    return;
                }

                const endDate = $('#end_date').val().trim();
                if (endDate === '' || endTime === '') {
                    alert('請輸入預計完成日期與時間！');
                    event.preventDefault();
                }
            });

            initTaskTemplateByStage();
        });
    </script>
@endsection
