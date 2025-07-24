@extends('layouts.vertical', ['title' => 'CRM Customers'])
@section('css')
    @vite(['node_modules/spectrum-colorpicker2/dist/spectrum.min.css', 'node_modules/flatpickr/dist/flatpickr.min.css', 'node_modules/clockpicker/dist/bootstrap-clockpicker.min.css', 'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css'])
    @vite(['node_modules/selectize/dist/css/selectize.bootstrap3.css', 'node_modules/mohithg-switchery/dist/switchery.min.css', 'node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css', 'node_modules/select2/dist/css/select2.min.css', 'node_modules/multiselect/css/multi-select.css'])
@endsection
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                                <a href="{{ route('project.edit', $data->id) }}" aria-expanded="false"
                                    class="nav-link active">
                                    專案基本設定
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.task', $data->id) }}" aria-expanded="false" class="nav-link">
                                    派工作業
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.plan', $data->id) }}" aria-expanded="false"
                                    class="nav-link">
                                    排程作業
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
                                <a href="{{ route('project.meet', $data->id) }}" aria-expanded="true" class="nav-link active">
                                    會議瀏覽
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- end row -->

                </div> <!-- end card-body -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row justify-content-between mb-3">
                                    <div class="col-md-10">
                                        <h4 class="header-title">會議記錄列表</h4>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="text-md-end">
                                            <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#createMeetingModal">
                                                <i class="mdi mdi-plus-circle me-1"></i> 新增會議
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap table-striped" id="products-datatable">
                                        <thead>
                                            <tr align="center">
                                                <th scope="col">No</th>
                                                <th scope="col">會議時間</th>
                                                <th scope="col">會議名稱</th>
                                                <th scope="col">地點</th>
                                                <th scope="col">錚典待辦</th>
                                                <th scope="col">客戶待辦</th>
                                                <th scope="col">NAS連結</th>
                                                <th scope="col" style="width: 200px;">操作</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($meet_datas as $key=>$meet_data)
                                                <tr>
                                                    <td align="center">{{ $key+1 }}</td>
                                                    <td align="center">{{ $meet_data->date }}</td>
                                                    <td align="center">{{ $meet_data->name }}</td>
                                                    <td align="center">{{ $meet_data->place }}</td>
                                                    <td>{!! $meet_data->to_do !!}</td>
                                                    <td>{!! $meet_data->cust_to_do !!}</td>
                                                    <td align="center">{{ $meet_data->nas_link }}</td>
                                                    <td align="center">
                                                        <button type="button" class="btn btn-sm btn-info edit-meeting-btn" data-id="{{ $meet_data->id }}">編輯</button>
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
            </div> <!-- end card-->
            <!-- end row -->



        </div> <!-- container -->

        <!-- 新增會議 Modal -->
        <div class="modal fade" id="createMeetingModal" tabindex="-1" aria-labelledby="createMeetingModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createMeetingModalLabel">新增會議記錄</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" method="POST" action="{{ route('meetData.create.data') }}" id="createMeetingForm">
                            @csrf
                            <div class="row mb-2">
                                <label for="inputEmail3" class="col-3 col-xl-2 col-form-label" style="text-align: right;">
                                    <span class="text-danger">*</span>客戶名稱：
                                </label>
                                <div class="col-8 col-xl-9">
                                    <select class="form-control" data-toggle="select2" data-width="100%" name="user_id" required>
                                        <option value="" selected>請選擇</option>
                                        <option value="{{ $data->user_id }}" selected>{{ $data->user_data->name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputEmail3" class="col-3 col-xl-2 col-form-label" style="text-align: right;">專案類別：</label>
                                <div class="col-8 col-xl-9">
                                    <select class="form-control" id="project_id" name="project_id">
                                        <option value="">請選擇</option>
                                        <option value="{{ $data->id }}" selected>{{ $data->name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputEmail3" class="col-3 col-xl-2 col-form-label" style="text-align: right;">會議名稱：</label>
                                <div class="col-8 col-xl-9">
                                    <input type="text" class="form-control" id="name" name="name" value="{{ \Carbon\Carbon::now()->format('Ymd') . '會議記錄' }}">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputPassword3" class="col-3 col-xl-2 col-form-label" style="text-align: right;">議程：</label>
                                <div class="col-8 col-xl-9">
                                    <textarea class="form-control tinymce-editor" name="agenda" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputPassword5" class="col-3 col-xl-2 col-form-label" style="text-align: right;">
                                    <span class="text-danger">*</span>會議日期：
                                </label>
                                <div class="col-8 col-xl-9">
                                    <div class="input-group mb-2">
                                        <input type="date" class="form-control" id="date" placeholder="日期" name="date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputPassword5" class="col-3 col-xl-2 col-form-label" style="text-align: right;">
                                    <span class="text-danger">*</span>開始時間：
                                </label>
                                <div class="col-8 col-xl-9">
                                    <div class="input-group mb-2">
                                        <input type="time" class="form-control" id="start_time" placeholder="時間" name="start_time">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputPassword5" class="col-3 col-xl-2 col-form-label" style="text-align: right;">
                                    <span class="text-danger">*</span>結束時間：
                                </label>
                                <div class="col-8 col-xl-9">
                                    <div class="input-group mb-2">
                                        <input type="time" class="form-control" id="end_time" placeholder="時間" name="end_time">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputEmail3" class="col-3 col-xl-2 col-form-label" style="text-align: right;">地點：</label>
                                <div class="col-8 col-xl-9">
                                    <input type="text" class="form-control" id="place" name="place">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputEmail3" class="col-3 col-xl-2 col-form-label" style="text-align: right;">列席：</label>
                                <div class="col-8 col-xl-9">
                                    <input type="text" class="form-control" id="attend" name="attend">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputEmail3" class="col-3 col-xl-2 col-form-label" style="text-align: right;">會議記錄：</label>
                                <div class="col-8 col-xl-9">
                                    <textarea class="form-control tinymce-editor" name="record" rows="8"></textarea>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputEmail3" class="col-3 col-xl-2 col-form-label" style="text-align: right;">錚典待辦：</label>
                                <div class="col-8 col-xl-9">
                                    <textarea class="form-control tinymce-editor" name="to_do" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputEmail3" class="col-3 col-xl-2 col-form-label" style="text-align: right;">客戶待辦：</label>
                                <div class="col-8 col-xl-9">
                                    <textarea class="form-control tinymce-editor" name="cust_to_do" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputEmail3" class="col-3 col-xl-2 col-form-label" style="text-align: right;">參考資料：</label>
                                <div class="col-8 col-xl-9">
                                    <input type="text" class="form-control" id="nas_link" name="nas_link">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                        <button type="submit" form="createMeetingForm" class="btn btn-success waves-effect waves-light">
                            <i class="fe-check-circle me-1"></i>新增會議
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- 編輯會議 Modal -->
        <div class="modal fade" id="editMeetingModal" tabindex="-1" aria-labelledby="editMeetingModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editMeetingModalLabel">編輯會議記錄</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editMeetingForm" method="POST" action="">
                            @csrf
                            <div class="row mb-2">
                                <label for="inputEmail3" class="col-3 col-xl-2 col-form-label" style="text-align: right;">
                                    <span class="text-danger">*</span>客戶名稱：
                                </label>
                                <div class="col-8 col-xl-9">
                                    <select class="form-control" data-toggle="select2" data-width="100%" name="user_id" required>
                                        <option value="" selected>請選擇</option>
                                        <option value="{{ $data->user_id }}" selected>{{ $data->user_data->name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputEmail3" class="col-3 col-xl-2 col-form-label" style="text-align: right;">專案類別：</label>
                                <div class="col-8 col-xl-9">
                                    <select class="form-control" id="project_id" name="project_id">
                                        <option value="">請選擇</option>
                                        <option value="{{ $data->id }}" selected>{{ $data->name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputEmail3" class="col-3 col-xl-2 col-form-label" style="text-align: right;">會議名稱：</label>
                                <div class="col-8 col-xl-9">
                                    <input type="text" class="form-control" id="name" name="name" value="{{ \Carbon\Carbon::now()->format('Ymd') . '會議記錄' }}">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputPassword3" class="col-3 col-xl-2 col-form-label" style="text-align: right;">議程：</label>
                                <div class="col-8 col-xl-9">
                                    <textarea class="form-control tinymce-editor" name="agenda" id="edit_agenda" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputPassword5" class="col-3 col-xl-2 col-form-label" style="text-align: right;">
                                    <span class="text-danger">*</span>會議日期：
                                </label>
                                <div class="col-8 col-xl-9">
                                    <div class="input-group mb-2">
                                        <input type="date" class="form-control" id="edit_date" placeholder="日期" name="date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputPassword5" class="col-3 col-xl-2 col-form-label" style="text-align: right;">
                                    <span class="text-danger">*</span>開始時間：
                                </label>
                                <div class="col-8 col-xl-9">
                                    <div class="input-group mb-2">
                                        <input type="time" class="form-control" id="edit_start_time" placeholder="時間" name="start_time">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputPassword5" class="col-3 col-xl-2 col-form-label" style="text-align: right;">
                                    <span class="text-danger">*</span>結束時間：
                                </label>
                                <div class="col-8 col-xl-9">
                                    <div class="input-group mb-2">
                                        <input type="time" class="form-control" id="edit_end_time" placeholder="時間" name="end_time">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputEmail3" class="col-3 col-xl-2 col-form-label" style="text-align: right;">地點：</label>
                                <div class="col-8 col-xl-9">
                                    <input type="text" class="form-control" id="edit_place" name="place">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputEmail3" class="col-3 col-xl-2 col-form-label" style="text-align: right;">列席：</label>
                                <div class="col-8 col-xl-9">
                                    <input type="text" class="form-control" id="edit_attend" name="attend">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputEmail3" class="col-3 col-xl-2 col-form-label" style="text-align: right;">會議記錄：</label>
                                <div class="col-8 col-xl-9">
                                    <textarea class="form-control tinymce-editor" name="record" id="edit_record" rows="8"></textarea>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputEmail3" class="col-3 col-xl-2 col-form-label" style="text-align: right;">錚典待辦：</label>
                                <div class="col-8 col-xl-9">
                                    <textarea class="form-control tinymce-editor" name="to_do" id="edit_to_do" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputEmail3" class="col-3 col-xl-2 col-form-label" style="text-align: right;">客戶待辦：</label>
                                <div class="col-8 col-xl-9">
                                    <textarea class="form-control tinymce-editor" name="cust_to_do" id="edit_cust_to_do" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputEmail3" class="col-3 col-xl-2 col-form-label" style="text-align: right;">參考資料：</label>
                                <div class="col-8 col-xl-9">
                                    <input type="text" class="form-control" id="edit_nas_link" name="nas_link">
                                </div>
                            </div>
                            <input type="hidden" name="user_id" id="edit_user_id">
                            <input type="hidden" name="project_id" id="edit_project_id">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                        <button type="submit" form="editMeetingForm" class="btn btn-success waves-effect waves-light">
                            <i class="fe-check-circle me-1"></i>儲存變更
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('script')
        @vite(['resources/js/pages/form-advanced.init.js'])
        @vite(['resources/js/pages/form-pickers.init.js'])
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/tinymce@7/tinymce.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            $(document).ready(function() {
                // 初始化 TinyMCE 編輯器
                function initTinyMCE() {
                    tinymce.init({
                        selector: '.tinymce-editor',
                        height: 300,
                        menubar: 'file edit view insert format tools table help',
                        plugins: 'lists table image code link paste',
                        toolbar: 'undo redo | blocks | bold italic underline forecolor backcolor | alignleft aligncenter alignright | indent outdent | bullist numlist | table image link | code',

                        // ✅ 處理貼上行為：保留常見樣式、過濾 Word 樣式
                        paste_as_text: false,
                        paste_remove_styles_if_webkit: false,
                        paste_webkit_styles: 'font-weight font-style text-decoration color background-color',
                        paste_data_images: false,
                        valid_elements: 'span[style],p,br,b,strong,i,em,u,a[href|target],ul,ol,li,table,tr,td,th,thead,tbody,img[src|alt|width|height],h1,h2,h3',
                        valid_styles: {
                            '*': 'font-weight,font-style,text-decoration,color,background-color'
                        },

                        paste_preprocess: function(plugin, args) {
                            args.content = args.content
                                .replace(/<!--[\s\S]*?-->/g, '')
                                .replace(/<(\/?)(font|span|style)[^>]*>/gi, '');
                        },

                        images_upload_url: '/upload-image',
                        automatic_uploads: true,
                        file_picker_types: 'image',
                        file_picker_callback: function(cb, value, meta) {
                            if (meta.filetype === 'image') {
                                const input = document.createElement('input');
                                input.type = 'file';
                                input.accept = 'image/*';

                                input.onchange = function() {
                                    const file = this.files[0];
                                    if (file.size > 2 * 1024 * 1024) {
                                        alert('檔案大小不能超過 2MB');
                                        return;
                                    }

                                    const formData = new FormData();
                                    formData.append('file', file);

                                    fetch('/upload-image', {
                                            method: 'POST',
                                            body: formData,
                                            headers: {
                                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                            }
                                        })
                                        .then(res => res.json())
                                        .then(json => cb(json.location))
                                        .catch(err => console.error(err));
                                };

                                input.click();
                            }
                        },

                        setup: function(editor) {
                            editorInstance = editor;
                        },

                        table_toolbar: 'tableprops tabledelete | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol',
                    });
                }

                // Modal 顯示時初始化 TinyMCE
                $('#createMeetingModal').on('shown.bs.modal', function() {
                    initTinyMCE();
                });

                // Modal 隱藏時銷毀 TinyMCE
                $('#createMeetingModal').on('hidden.bs.modal', function() {
                    tinymce.remove();
                });

                // 表單提交處理
                $('#createMeetingForm').on('submit', function(e) {
                    e.preventDefault();
                    
                    // 同步 TinyMCE 內容到 textarea
                    tinymce.triggerSave();
                    
                    const formData = new FormData(this);
                    
                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            // 成功後關閉 modal 並重新載入頁面
                            $('#createMeetingModal').modal('hide');
                            alert('會議記錄新增成功！');
                            location.reload();
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                // 驗證錯誤
                                const errors = xhr.responseJSON.errors;
                                let errorMessage = '請檢查以下欄位：\n';
                                for (let field in errors) {
                                    errorMessage += errors[field].join('\n') + '\n';
                                }
                                alert(errorMessage);
                            } else {
                                alert('新增失敗，請稍後再試。');
                            }
                        }
                    });
                });

                // 編輯按鈕點擊
                // 用 on 綁定動態元素
                $(document).on('click', '.edit-meeting-btn', function() {
                    var id = $(this).data('id');
                    $.get('/project/meet/edit/' + id, function(data) {
                        console.log(data);
                        // 設定 form action
                        $('#editMeetingForm').attr('action', '/meetData/edit/' + id);

                        // 填入欄位
                        $('#edit_user_id').val(data.user_id);
                        $('#edit_project_id').val(data.project_id);
                        $('#edit_name').val(data.name);
                        $('#edit_agenda').val(data.agenda);
                        $('#edit_date').val(data.date ? data.date.substr(0, 10) : '');
                        $('#edit_start_time').val(data.start_time || '');
                        $('#edit_end_time').val(data.end_time || '');
                        $('#edit_place').val(data.place || '');
                        $('#edit_attend').val(data.attend || '');
                        $('#edit_nas_link').val(data.nas_link || '');

                        // TinyMCE 內容
                        if (tinymce.get('edit_agenda')) tinymce.get('edit_agenda').setContent(data.agenda || '');
                        if (tinymce.get('edit_record')) tinymce.get('edit_record').setContent(data.record || '');
                        if (tinymce.get('edit_to_do')) tinymce.get('edit_to_do').setContent(data.to_do || '');
                        if (tinymce.get('edit_cust_to_do')) tinymce.get('edit_cust_to_do').setContent(data.cust_to_do || '');

                        // 先移除舊的
                        tinymce.remove('.tinymce-editor');
                        // 再初始化
                        tinymce.init({
                            selector: '.tinymce-editor',
                            height: 300,
                            menubar: 'file edit view insert format tools table help',
                            plugins: 'lists table image code link paste',
                            toolbar: 'undo redo | blocks | bold italic underline forecolor backcolor | alignleft aligncenter alignright | indent outdent | bullist numlist | table image link | code',

                            // ✅ 處理貼上行為：保留常見樣式、過濾 Word 樣式
                            paste_as_text: false,
                            paste_remove_styles_if_webkit: false,
                            paste_webkit_styles: 'font-weight font-style text-decoration color background-color',
                            paste_data_images: false,
                            valid_elements: 'span[style],p,br,b,strong,i,em,u,a[href|target],ul,ol,li,table,tr,td,th,thead,tbody,img[src|alt|width|height],h1,h2,h3',
                            valid_styles: {
                                '*': 'font-weight,font-style,text-decoration,color,background-color'
                            },

                            paste_preprocess: function(plugin, args) {
                                args.content = args.content
                                    .replace(/<!--[\s\S]*?-->/g, '')
                                    .replace(/<(\/?)(font|span|style)[^>]*>/gi, '');
                            },

                            images_upload_url: '/upload-image',
                            automatic_uploads: true,
                            file_picker_types: 'image',
                            file_picker_callback: function(cb, value, meta) {
                                if (meta.filetype === 'image') {
                                    const input = document.createElement('input');
                                    input.type = 'file';
                                    input.accept = 'image/*';

                                    input.onchange = function() {
                                        const file = this.files[0];
                                        if (file.size > 2 * 1024 * 1024) {
                                            alert('檔案大小不能超過 2MB');
                                            return;
                                        }

                                        const formData = new FormData();
                                        formData.append('file', file);

                                        fetch('/upload-image', {
                                                method: 'POST',
                                                body: formData,
                                                headers: {
                                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                                }
                                            })
                                            .then(res => res.json())
                                            .then(json => cb(json.location))
                                            .catch(err => console.error(err));
                                    };

                                    input.click();
                                }
                            },

                            setup: function(editor) {
                                editorInstance = editor;
                            },

                            table_toolbar: 'tableprops tabledelete | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol',
                        });
                        // 設定內容
                        setTimeout(function() {
                            if (tinymce.get('edit_record')) tinymce.get('edit_record').setContent(data.record || '');
                            if (tinymce.get('edit_to_do')) tinymce.get('edit_to_do').setContent(data.to_do || '');
                            if (tinymce.get('edit_cust_to_do')) tinymce.get('edit_cust_to_do').setContent(data.cust_to_do || '');
                        }, 300);

                        // 顯示 Modal
                        var modal = new bootstrap.Modal(document.getElementById('editMeetingModal'));
                        modal.show();
                    });
                });

                // 表單送出
                $(document).on('submit', '#editMeetingForm', function(e) {
                    e.preventDefault();
                    tinymce.triggerSave();
                    var form = $(this);
                    $.ajax({
                        url: form.attr('action'),
                        type: 'POST',
                        data: form.serialize(),
                        success: function() {
                            var modal = bootstrap.Modal.getInstance(document.getElementById('editMeetingModal'));
                            modal.hide();
                            location.reload();
                        },
                        error: function(xhr) {
                            alert('儲存失敗');
                        }
                    });
                });

                // Modal 關閉時銷毀 TinyMCE
                $('#editMeetingModal').on('hidden.bs.modal', function() {
                    tinymce.remove('.tinymce-editor');
                });
            });
        </script>
    @endsection
