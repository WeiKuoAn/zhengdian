@extends('layouts.vertical', ['title' => 'CRM Customers'])
@section('css')
    @vite(['node_modules/spectrum-colorpicker2/dist/spectrum.min.css', 'node_modules/flatpickr/dist/flatpickr.min.css', 'node_modules/clockpicker/dist/bootstrap-clockpicker.min.css', 'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css'])
    @vite(['node_modules/selectize/dist/css/selectize.bootstrap3.css', 'node_modules/mohithg-switchery/dist/switchery.min.css', 'node_modules/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css', 'node_modules/select2/dist/css/select2.min.css', 'node_modules/multiselect/css/multi-select.css'])
@endsection
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', ['title' => '會議管理', 'subtitle' => '刪除會議'])

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <form class="form-horizontal" method="POST" action="{{ route('meetData.del.data', $data->id) }}">
                            @csrf
                            <div class="row mb-2">
                                <label for="inputEmail3" class="col-3 col-xl-2 col-form-label"
                                    style="text-align: right;"><span class="text-danger">*</span>客戶名稱：</label>
                                <div class="col-8 col-xl-9">
                                    <select class="form-control" data-toggle="select2" data-width="100%" name="user_id"
                                        required>
                                        <option value="" selected>請選擇</option>
                                        @foreach ($cust_datas as $key => $cust_data)
                                            <option value="{{ $cust_data->id }}"
                                                @if ($data->user_id == $cust_data->id) selected @endif>{{ $cust_data->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputEmail3" class="col-3 col-xl-2 col-form-label"
                                    style="text-align: right;">專案類別：</label>
                                <div class="col-8 col-xl-9">
                                    <select class="form-control" id="project_id" name="project_id">
                                        <option value="">請選擇</option>
                                        @if ($data->project_id)
                                            <option value="{{ $data->project_id }}" selected>{{ $data->project_id }}
                                            </option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputEmail3" class="col-3 col-xl-2 col-form-label"
                                    style="text-align: right;">會議名稱：</label>
                                <div class="col-8 col-xl-9">
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $data->name }}">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputPassword3" class="col-3 col-xl-2 col-form-label"
                                    style="text-align: right;">議程：</label>
                                <div class="col-8 col-xl-9">
                                    <textarea class="form-control tinymce-editor" name="agenda" rows="4">{{ $data->agenda }}</textarea>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputPassword5" class="col-3 col-xl-2 col-form-label"
                                    style="text-align: right;"><span class="text-danger">*</span>會議日期：</label>
                                <div class="col-8 col-xl-9">
                                    <div class="input-group mb-2">
                                        <input type="date" class="form-control" id="date" placeholder="日期"
                                            name="date" value="{{ substr($data->date, 0, 10) }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputPassword5" class="col-3 col-xl-2 col-form-label"
                                    style="text-align: right;"><span class="text-danger">*</span>開始時間：</label>
                                <div class="col-8 col-xl-9">
                                    <div class="input-group mb-2">
                                        <input type="time" class="form-control" id="start_time" placeholder="時間"
                                            name="start_time" value="{{ $data->start_time }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <label for="inputPassword5" class="col-3 col-xl-2 col-form-label"
                                    style="text-align: right;"><span class="text-danger">*</span>結束時間：</label>
                                <div class="col-8 col-xl-9">
                                    <div class="input-group mb-2">
                                        <input type="time" class="form-control" id="end_time" placeholder="時間"
                                            name="end_time" value="{{ $data->end_time }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputEmail3" class="col-3 col-xl-2 col-form-label"
                                    style="text-align: right;">地點：</label>
                                <div class="col-8 col-xl-9">
                                    <input type="text" class="form-control" id="place" name="place"
                                        value="{{ $data->place }}">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputEmail3" class="col-3 col-xl-2 col-form-label"
                                    style="text-align: right;">列席：</label>
                                <div class="col-8 col-xl-9">
                                    <input type="text" class="form-control" id="attend" name="attend"
                                        value="{{ $data->attend }}">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputEmail3" class="col-3 col-xl-2 col-form-label"
                                    style="text-align: right;">會議記錄：</label>
                                <div class="col-8 col-xl-9">
                                    <textarea class="form-control tinymce-editor" name="record" rows="8">{{ $data->record }}</textarea>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputEmail3" class="col-3 col-xl-2 col-form-label"
                                    style="text-align: right;">錚典待辦：</label>
                                <div class="col-8 col-xl-9">
                                    <textarea class="form-control tinymce-editor" name="to_do" rows="5">{{ $data->to_do }}</textarea>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputEmail3" class="col-3 col-xl-2 col-form-label"
                                    style="text-align: right;">客戶待辦：</label>
                                <div class="col-8 col-xl-9">
                                    <textarea class="form-control tinymce-editor" name="cust_to_do" rows="5">{{ $data->cust_to_do }}</textarea>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputEmail3" class="col-3 col-xl-2 col-form-label"
                                    style="text-align: right;">參考資料：</label>
                                <div class="col-8 col-xl-9">
                                    <input type="text" class="form-control" id="nas_link" name="nas_link"
                                        value="{{ $data->nas_link }}">
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-danger waves-effect waves-light m-1"><i
                                            class="fe-trash-2 me-1"></i>確認刪除</button>
                                    <button type="reset" class="btn btn-secondary waves-effect waves-light m-1"
                                        onclick="history.go(-1)"><i class="fe-x me-1"></i>回上一頁</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- end row -->

                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col-->
        <!-- end row -->

    </div> <!-- container -->
@endsection
@section('script')
    @vite(['resources/js/pages/form-advanced.init.js'])
    @vite(['resources/js/pages/form-pickers.init.js'])
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tinymce@7/tinymce.min.js"></script>
    <script>
        $(document).ready(function() {
            // 載入專案列表的函數
            function loadProjects(user_id) {
                if (user_id) {
                    $.ajax({
                        url: '/customer/project/search',
                        type: 'GET',
                        data: {
                            user_id: user_id
                        },
                        dataType: 'json',
                        success: function(data) {
                            console.log(data);
                            var $projectSelect = $('#project_id');
                            var currentProjectId = $projectSelect.val(); // 保存當前選中的值

                            $projectSelect.empty();
                            $projectSelect.append('<option value="">請選擇</option>');

                            $.each(data, function(index, project) {
                                var selected = (project.id == currentProjectId) ? 'selected' :
                                    '';
                                $projectSelect.append('<option value="' + project.id + '" ' +
                                    selected + '>' + project.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#project_id').empty().append('<option value="">請選擇</option>');
                }
            }

            // 頁面載入時，如果已有 user_id 值，自動載入專案列表
            var initialUserId = $('select[name="user_id"]').val();
            if (initialUserId) {
                loadProjects(initialUserId);
            }

            // 當 user_id 改變時載入專案列表
            $('select[name="user_id"]').on('change', function() {
                var user_id = $(this).val();
                loadProjects(user_id);
            });

            tinymce.init({
                selector: '.tinymce-editor',
                height: 500,
                menubar: 'file edit view insert format tools table help',
                plugins: 'lists table image code link paste',
                toolbar: 'undo redo | blocks | bold italic underline forecolor backcolor | alignleft aligncenter alignright | indent outdent | bullist numlist | table image link | code',

                // ✅ 處理貼上行為：保留常見樣式、過濾 Word 樣式
                paste_as_text: false,
                paste_remove_styles_if_webkit: false,
                paste_webkit_styles: 'font-weight font-style text-decoration color background-color',
                paste_data_images: false, // 如需 base64 圖片可改 true
                valid_elements: 'span[style],p,br,b,strong,i,em,u,a[href|target],ul,ol,li,table,tr,td,th,thead,tbody,img[src|alt|width|height],h1,h2,h3',
                valid_styles: {
                    '*': 'font-weight,font-style,text-decoration,color,background-color'
                },

                paste_preprocess: function(plugin, args) {
                    args.content = args.content
                        .replace(/<!--[\s\S]*?-->/g, '') // 移除 HTML 註解（常見於 Word）
                        .replace(/<(\/?)(font|span|style)[^>]*>/gi, ''); // 移除雜質標籤
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
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').content
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

            // 刪除確認
            $('form').on('submit', function(event) {
                if (!confirm('確定要刪除這筆會議記錄嗎？此操作無法復原。')) {
                    event.preventDefault();
                }
            });
        });
    </script>
@endsection
