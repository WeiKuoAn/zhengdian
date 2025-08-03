@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', ['title' => '會議瀏覽', 'subtitle' => Auth::user()->name])

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        @php
                            $encrypted_id = \App\Services\EncryptionService::encryptProjectId($data->id);
                        @endphp
                        <form class="form-horizontal" method="POST" action="{{ route('customer.meet.check.data', $encrypted_id) }}">
                            @csrf
                            <div class="row mb-2">
                                <label for="inputEmail3" class="col-3 col-xl-2 col-form-label"
                                    style="text-align: right;">專案類別：</label>
                                <div class="col-8 col-xl-9">
                                    <input type="text" class="form-control" id="project_name" name="project_name"
                                        value="{{ $data->project->name }}" disabled style="background-color: #f8f9fa;">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputEmail3" class="col-3 col-xl-2 col-form-label"
                                    style="text-align: right;">會議名稱：</label>
                                <div class="col-8 col-xl-9">
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $data->name }}" disabled style="background-color: #f8f9fa;">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputPassword3" class="col-3 col-xl-2 col-form-label"
                                    style="text-align: right;">議程：</label>
                                <div class="col-8 col-xl-9">
                                    <div class="form-control" style="background-color: #f8f9fa; min-height: 120px; border: 1px solid #ced4da; padding: 10px; white-space: pre-wrap;">{!! $data->agenda !!}</div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputPassword5" class="col-3 col-xl-2 col-form-label"
                                    style="text-align: right;"><span class="text-danger">*</span>會議日期：</label>
                                <div class="col-8 col-xl-9">
                                    <div class="input-group mb-2">
                                        <input type="date" class="form-control" id="date" placeholder="日期"
                                            name="date" value="{{ substr($data->date, 0, 10) }}" required readonly style="background-color: #f8f9fa;">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <label for="inputPassword5" class="col-3 col-xl-2 col-form-label"
                                    style="text-align: right;"><span class="text-danger">*</span>開始時間：</label>
                                <div class="col-8 col-xl-9">
                                    <div class="input-group mb-2">
                                        <input type="time" class="form-control" id="start_time" placeholder="時間"
                                            name="start_time" value="{{ $data->start_time }}" readonly style="background-color: #f8f9fa;">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <label for="inputPassword5" class="col-3 col-xl-2 col-form-label"
                                    style="text-align: right;"><span class="text-danger">*</span>結束時間：</label>
                                <div class="col-8 col-xl-9">
                                    <div class="input-group mb-2">
                                        <input type="time" class="form-control" id="end_time" placeholder="時間"
                                            name="end_time" value="{{ $data->end_time }}" readonly style="background-color: #f8f9fa;">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <label for="inputEmail3" class="col-3 col-xl-2 col-form-label"
                                    style="text-align: right;">地點：</label>
                                <div class="col-8 col-xl-9">
                                    <input type="text" class="form-control" id="place" name="place"
                                        value="{{ $data->place }}" readonly style="background-color: #f8f9fa;">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputEmail3" class="col-3 col-xl-2 col-form-label"
                                    style="text-align: right;">列席：</label>
                                <div class="col-8 col-xl-9">
                                    <input type="text" class="form-control" id="attend" name="attend"
                                        value="{{ $data->attend }}" readonly style="background-color: #f8f9fa;">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputEmail3" class="col-3 col-xl-2 col-form-label"
                                    style="text-align: right;">會議記錄：</label>
                                <div class="col-8 col-xl-9">
                                    <div class="form-control" style="background-color: #f8f9fa; min-height: 200px; border: 1px solid #ced4da; padding: 10px; white-space: pre-wrap;">{!! $data->record !!}</div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputEmail3" class="col-3 col-xl-2 col-form-label"
                                    style="text-align: right;">錚典待辦：</label>
                                <div class="col-8 col-xl-9">
                                    <div class="form-control" style="background-color: #f8f9fa; min-height: 150px; border: 1px solid #ced4da; padding: 10px; white-space: pre-wrap;">{!! $data->to_do !!}</div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputEmail3" class="col-3 col-xl-2 col-form-label"
                                    style="text-align: right;">客戶待辦：</label>
                                <div class="col-8 col-xl-9">
                                    <div class="form-control" style="background-color: #f8f9fa; min-height: 150px; border: 1px solid #ced4da; padding: 10px; white-space: pre-wrap;">{!! $data->cust_to_do !!}</div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="inputEmail3" class="col-3 col-xl-2 col-form-label"
                                    style="text-align: right;">參考資料：</label>
                                <div class="col-8 col-xl-9">
                                    <input type="text" class="form-control" id="nas_link" name="nas_link"
                                        value="{{ $data->nas_link }}" readonly style="background-color: #f8f9fa;">
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-12 text-center">
                                    @if($data->status == 0)
                                        <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                                class="fe-check-circle me-1"></i>確認會議內容</button>
                                    @endif
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
                                var selected = (project.id == currentProjectId) ? 'selected' : '';
                                $projectSelect.append('<option value="' + project.id + '" ' + selected + '>' + project.name + '</option>');
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

            // TinyMCE 已移除，改用純文字顯示

            // ✅ 處理 .open-editor 按鈕 → 透過 AJAX 載入資料進編輯器
            document.querySelectorAll('.open-editor').forEach(btn => {
                btn.addEventListener('click', function() {
                    const field = this.getAttribute('data-field');

                    fetch(`/project/${projectId}/sbir05/get-field?field=${field}`)
                        .then(res => res.json())
                        .then(data => {
                            const content = data.value || '';
                            document.getElementById('currentField').value = field;

                            const wait = setInterval(() => {
                                const editor = tinymce.get('modalEditor');
                                if (editor) {
                                    editor.setContent(content);
                                    clearInterval(wait);
                                }
                            }, 100);
                        });
                });
            });
        });

        // ✅ 儲存資料
        function saveEditorContent() {
            const field = document.getElementById('currentField').value;
            const content = tinymce.get('modalEditor').getContent();

            const preview = document.getElementById(`preview_${field}`);
            if (preview) preview.innerHTML = content;

            fetch(`/project/${projectId}/sbir05/update-field`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        field: field,
                        value: content
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const modalInstance = bootstrap.Modal.getInstance(document.getElementById('editorModal'));
                        modalInstance.hide();
                        alert('儲存成功');
                    } else {
                        alert('儲存失敗');
                    }
                })
                .catch(err => {
                    alert('錯誤發生：' + err.message);
                });
        }
    </script>
@endsection
