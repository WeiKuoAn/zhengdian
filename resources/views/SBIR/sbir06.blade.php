@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', [
            'title' => $project->user_data->name . '專案管理',
            'subtitle' => '專案管理',
        ])

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-start mb-3">
                            <div class="w-100 ">
                                <h3 class="mt-1 mb-0">{{ $project->name }}</h3>
                                <p class="mb-1 mt-1 text-muted">計畫登入帳號：ＸＸＸ　計畫登入密碼：ＸＸＸ</p>
                            </div>
                        </div>
                        <ul class="nav nav-tabs nav-bordered nav-justified">
                            <li class="nav-item">
                                <a href="{{ route('project.edit', $project->id) }}" aria-expanded="false"
                                    class="nav-link ">
                                    專案基本設定
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.task', $project->id) }}" aria-expanded="false" class="nav-link">
                                    派工作業
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.plan', $project->id) }}" aria-expanded="false"
                                    class="nav-link">
                                    排程作業
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.background', $project->id) }}" aria-expanded="false" class="nav-link ">
                                    專案背景調查
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.write', $project->id) }}" aria-expanded="false"
                                    class="nav-link">
                                    人事/帶動企業
                                </a>
                            </li>
                            @if($project->type == '3')
                            <li class="nav-item">
                                <a href="{{ route('project.sbir01', $project->id) }}" aria-expanded="false"
                                    class="nav-link active">
                                    SBIR內容撰寫
                                </a>
                            </li>
                            @endif
                            <li class="nav-item">
                                <a href="{{ route('project.send', $project->id) }}" aria-expanded="false" class="nav-link">
                                    送件作業
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.midterm', $project->id) }}" aria-expanded="false" class="nav-link">
                                    期中報告/檢核
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.final', $project->id) }}" aria-expanded="false" class="nav-link">
                                    期末報告/結案
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.accounting', $project->id) }}" aria-expanded="true" class="nav-link ">
                                    經費報表
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('project.meet', $project->id) }}" aria-expanded="false" class="nav-link">
                                    會議瀏覽
                                </a>
                            </li>
                        </ul>
                        <div id="success-btn" class="modal fade" tabindex="-1" aria-labelledby="success-btnLabel"
                            aria-hidden="true" data-bs-scroll="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="text-center">
                                            <i class="bx bx-check-circle display-1 text-success"></i>
                                            <h4 class="mt-3">儲存SBIR資料成功！</h4>
                                        </div>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
                    </div> <!-- end row-->
                </div>
                <!-- end row -->
            </div> <!-- end card-body -->
        </div> <!-- end card-->
        <!-- end row -->

        <div class="row">
            <form action="{{ route('project.sbir06.data', $project->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-12 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <!--選單-->
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir01', $project->id) }}" class="nav-link ">
                                                    壹、計畫書基本資料
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir02', $project->id) }}" class="nav-link ">
                                                    貳、計畫申請表
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir03', $project->id) }}" class="nav-link ">
                                                    參、計畫摘要表
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir04', $project->id) }}" class="nav-link ">
                                                    肆、公司概況
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir05', $project->id) }}" class="nav-link ">
                                                    伍、研發動機
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir06', $project->id) }}"
                                                    class="nav-link active">
                                                    陸、計畫目標
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir07', $project->id) }}" class="nav-link">
                                                    柒、實施方式
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir08', $project->id) }}" class="nav-link">
                                                    捌、智財分析
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir09', $project->id) }}" class="nav-link">
                                                    玖、計畫執行查核點說明
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir10', $project->id) }}" class="nav-link">
                                                    拾、經費需求
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.appendix', $project->id) }}" class="nav-link">
                                                    拾壹、附件
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.supplement', $project->id) }}" class="nav-link">
                                                    拾貳、補充資料
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="card-body">
                                            @php
                                                $sections = [
                                                    [
                                                        'title' => '(一)計畫目標',
                                                        'field' => 'text1',
                                                        'description' =>
                                                            '(如:既有技術/服務缺口提出明確解決方案或開發新興市場，計畫產出可提高公司獲利(益)模式)',
                                                    ],
                                                    [
                                                        'title' => '(二)創新性說明',
                                                        'field' => 'text2',
                                                        'description' =>
                                                            '(請說明本計畫在系統、研發、製程、產品功能或規格等構面之創新性。)。',
                                                    ],
                                                    [
                                                        'title' => '(三)功能規格（技術指標）/服務模式（服務指標）',
                                                        'field' => 'text3',
                                                        'description' => '市場需求性與優勢及公司研發能力。',
                                                    ],
                                                    [
                                                        'title' => '(四)主要關鍵技術或服務、零組件及其來源',
                                                        'field' => 'text4',
                                                        'description' =>
                                                            '(計畫開發核心能力掌握程度，如:主要研發人員、原料來源、平台維運、金流收益等)',
                                                    ],
                                                    [
                                                        'title' => '(五)技術或服務應用範圍',
                                                        'field' => 'text5',
                                                        'description' => '(請儘量附圖表配合說明)',
                                                    ],
                                                    [
                                                        'title' => '(六)加值應用說明',
                                                        'field' => 'text6',
                                                        'description' =>
                                                            '(申請SBIR Phase2+申請階段必填，並須敘明原Phase 2計畫名稱、研發成果及如何加值應用)',
                                                    ],
                                                ];
                                            @endphp

                                            @foreach ($sections as $sec)
                                                <div class="card mb-3">
                                                    <div class="card-body">
                                                        <h5 class="card-title">{{ $sec['title'] }}</h5>
                                                        <p class="text-muted">{{ $sec['description'] }}</p>
                                                        <div id="preview_{{ $sec['field'] }}"
                                                            class="border p-3 bg-light mb-2">
                                                            {!! $data[$sec['field']] ?? '' !!}
                                                        </div>
                                                        <button type="button" class="btn btn-sm btn-primary open-editor"
                                                            data-bs-toggle="modal" data-bs-target="#editorModal"
                                                            data-field="{{ $sec['field'] }}">
                                                            編輯內容
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <!-- 匯出 Word 按鈕 -->
                                            <div class="text-end mt-4">
                                                <a href="{{ route('project.sbir05.export', $project->id) }}"
                                                    class="btn btn-success">
                                                    匯出計畫書 Word 檔
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </form>
        </div>

    </div> <!-- container -->
    <!-- 編輯 Modal -->
    <div class="modal fade" id="editorModal" tabindex="-1" aria-labelledby="editorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editorModalLabel">內容編輯器</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <textarea id="modalEditor"></textarea>
                    <input type="hidden" id="currentField">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" onclick="saveEditorContent()">儲存</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @if (session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var successModal = new bootstrap.Modal(document.getElementById('success-btn'));
                successModal.show();
            });
        </script>
    @endif

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- TinyMCE + Modal 操作邏輯 -->
    <!--預設，誤動 -->
    <script src="https://cdn.jsdelivr.net/npm/tinymce@7/tinymce.min.js"></script>
    <script>
        const projectId = {{ $project->id }};
    </script>
    <script>
        let editorInstance;

        document.addEventListener('DOMContentLoaded', function() {
            tinymce.init({
                selector: '#modalEditor',
                height: 500,
                menubar: true,
                plugins: 'lists table image code link textcolor',
                toolbar: 'undo redo | blocks | bold italic underline forecolor backcolor | alignleft aligncenter alignright | bullist numlist | image table link | code',
                
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
                        input.setAttribute('type', 'file');
                        input.setAttribute('accept', 'image/*');

                        input.onchange = function() {
                            const file = this.files[0];
                            const formData = new FormData();
                            formData.append('file', file);

                            fetch('/upload-image', {
                                    method: 'POST',
                                    body: formData,
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').getAttribute(
                                            'content')
                                    }
                                })
                                .then(response => response.json())
                                .then(result => {
                                    cb(result.location);
                                });
                        };

                        input.click();
                    }
                },
                setup: function(editor) {
                    editorInstance = editor;
                }
            });

            document.querySelectorAll('.open-editor').forEach(btn => {
                btn.addEventListener('click', function() {
                    const field = this.getAttribute('data-field');

                    // 改為呼叫正確的 GET 路由
                    fetch(`/project/${projectId}/sbir06/get-field?field=${field}`)
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

        function saveEditorContent() {
            const field = document.getElementById('currentField').value;
            const content = tinymce.get('modalEditor').getContent();

            const preview = document.getElementById(`preview_${field}`);
            if (preview) preview.innerHTML = content;

            fetch(`/project/${projectId}/sbir06/update-field`, {
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
