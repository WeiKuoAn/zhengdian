@extends('layouts.vertical', ['title' => 'SBIR附件'])

@section('content')
    <style>
        textarea {
            white-space: pre-line !important;
            word-break: break-all !important;
            overflow-x: hidden !important;
            resize: vertical;
        }

        textarea:read-only {
            cursor: not-allowed !important;
            background-color: #f8f9fa !important;
        }

        /* Accordion 樣式優化 */
        .accordion-item {
            border: 2px solid #d1d5db;
            border-radius: 1rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            background-color: #ffffff;
            transition: all 0.3s ease;
        }

        /* 確保所有項目都有相同的邊框樣式 */
        .accordion-item:nth-child(2),
        .accordion-item:nth-child(3),
        .accordion-item:nth-child(4) {
            border: 2px solid #d1d5db;
            border-radius: 1rem;
        }

        /* 特別確保Q4（最後一個項目）有完整的邊框 */
        .accordion-item:last-child {
            border: 2px solid #d1d5db !important;
            border-radius: 1rem !important;
        }

        .accordion-item:last-child .accordion-button {
            border-radius: 1rem !important;
        }

        .accordion-item:last-child .accordion-body {
            border-radius: 0 0 1rem 1rem !important;
        }



        .accordion-item:first-child {
            border-radius: 1rem;
        }

        .accordion-item.bg-light {
            background-color: #f9fafb !important;
        }

        .accordion-button {
            padding: 1.5rem 1.5rem;
            font-weight: 600;
            font-size: 1.1rem;
            background-color: #ffffff;
            border: none;
            border-radius: 1rem;
            color: #374151;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .accordion-item:first-child .accordion-button {
            border-radius: 1rem;
        }

        .accordion-button:not(.collapsed) {
            background-color: #f8fafc;
            color: #1f2937;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.1);
        }

        .accordion-button:focus {
            box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.25);
            background-color: #f8fafc;
        }

        .accordion-button:hover {
            background-color: #f1f5f9;
            color: #1f2937;
        }

        .accordion-button::after {
            background-size: 1.2rem;
            transition: transform 0.3s ease;
            filter: brightness(0.7);
            opacity: 1;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23343a40'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: center;
            width: 1.2rem;
            height: 1.2rem;
            margin-left: auto;
            flex-shrink: 0;
        }

        .accordion-button:not(.collapsed)::after {
            transform: rotate(180deg);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23343a40'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: center;
        }

        .accordion-button:hover::after {
            filter: brightness(0.5);
        }

        .accordion-body {
            padding: 1.5rem;
            background-color: #ffffff;
            border-top: 1px solid #e5e7eb;
            border-radius: 1rem;
        }

        .accordion-item:first-child .accordion-body {
            border-radius: 1rem;
        }

        .accordion-item:last-child {
            border-radius: 1rem;
        }

        .accordion-item:last-child .accordion-button {
            border-radius: 1rem;
        }

        .accordion-item:last-child .accordion-body {
            border-radius: 1rem;
        }

        /* 已確認項目的特殊樣式 */
        .accordion-item.bg-light .accordion-button {
            background-color: #f9fafb;
            color: #6b7280;
        }

        .accordion-item.bg-light .accordion-button:not(.collapsed) {
            background-color: #f3f4f6;
            color: #374151;
        }

        .accordion-item.bg-light .accordion-button:hover {
            background-color: #f3f4f6;
            color: #374151;
        }

        /* 問題標題樣式 */
        .question-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #1f2937;
            line-height: 1.4;
        }

        .question-number {
            font-size: 1.1rem;
            font-weight: 700;
            color: #3b82f6;
            margin-right: 0.75rem;
        }

        /* 標籤樣式 */
        .status-badges {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            font-weight: 500;
        }

        /* 動畫效果 */
        .animate-expand {
            animation: expandItem 0.3s ease-out;
        }

        .animate-collapse {
            animation: collapseItem 0.3s ease-in;
        }

        @keyframes expandItem {
            0% {
                transform: scaleY(0.8);
                opacity: 0.8;
            }
            100% {
                transform: scaleY(1);
                opacity: 1;
            }
        }

        @keyframes collapseItem {
            0% {
                transform: scaleY(1);
                opacity: 1;
            }
            100% {
                transform: scaleY(0.8);
                opacity: 0.8;
            }
        }

        /* 按鈕動畫 */
        #expandAllBtn {
            transition: all 0.3s ease;
        }

        #expandAllBtn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }
    </style>
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', [
            'title' => $project->user_data->name,
            'subtitle' => '專案瀏覽',
        ])
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <label class="form-label" for="AddNew-Username"><b>計劃書下載連結：
                                            <a href="{{ $cust_data->nas_link ?? '#' }}" target="_blank"
                                                style="color: #003f8d;">
                                                請點擊我
                                            </a>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <!--選單-->
                                    <ul class="nav nav-tabs">
                                        {{-- <li class="nav-item">
                                                <a href="{{ route('project.sbir01', \App\Services\EncryptionService::encryptProjectId($project->id)) }}" class="nav-link ">
                                                    壹、計畫書基本資料
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir02', \App\Services\EncryptionService::encryptProjectId($project->id)) }}" class="nav-link ">
                                                    貳、計畫申請表
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir03', \App\Services\EncryptionService::encryptProjectId($project->id)) }}" class="nav-link ">
                                                    參、計畫摘要表
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir04', \App\Services\EncryptionService::encryptProjectId($project->id)) }}" class="nav-link">
                                                    肆、公司概況
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir05', \App\Services\EncryptionService::encryptProjectId($project->id)) }}" class="nav-link">
                                                    伍、研發動機
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir06', \App\Services\EncryptionService::encryptProjectId($project->id)) }}" class="nav-link">
                                                    陸、計畫目標
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir07', \App\Services\EncryptionService::encryptProjectId($project->id)) }}" class="nav-link">
                                                    柒、實施方式
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir08', \App\Services\EncryptionService::encryptProjectId($project->id)) }}" class="nav-link">
                                                    捌、智財分析
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir09', \App\Services\EncryptionService::encryptProjectId($project->id)) }}" class="nav-link">
                                                    玖、計畫執行查核點說明
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="{{ route('project.sbir10', \App\Services\EncryptionService::encryptProjectId($project->id)) }}" class="nav-link">
                                                    拾、經費需求
                                                </a>
                                            </li> --}}
                                        <li class="nav-item">
                                            <a href="{{ route('customer.project.sbir.appendix', \App\Services\EncryptionService::encryptProjectId($project->id)) }}"
                                                class="nav-link ">
                                                附件確認
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('customer.project.sbir.appendix', \App\Services\EncryptionService::encryptProjectId($project->id)) }}"
                                                class="nav-link active">
                                                補充資料填寫
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="card-body mt-3">
                                        <form action="{{ route('customer.project.supplement.store', $project->id) }}"
                                            method="POST">
                                            @csrf
                                            <input type="hidden" name="project_id" value="{{ $project->id }}">
                                            
                                            <!-- 全部展開按鈕 -->
                                            <div class="text-end mb-3">
                                                <button type="button" class="btn btn-outline-secondary" id="expandAllBtn">
                                                    全部展開
                                                </button>
                                            </div>
                                            
                                            <div class="accordion" id="supplementAccordion">
                                            @forelse($supplements as $index => $item)
                                                <div class="accordion-item mb-3 {{ $item->is_confirmed ? 'bg-light' : '' }}" 
                                                     style="{{ $item->is_confirmed ? 'background-color: #f8f9fa !important;' : '' }}">
                                                    <h2 class="accordion-header" id="heading{{ $index }}">
                                                        <button class="accordion-button collapsed" 
                                                                type="button" 
                                                                data-bs-toggle="collapse" 
                                                                data-bs-target="#collapse{{ $index }}" 
                                                                aria-expanded="false" 
                                                                aria-controls="collapse{{ $index }}">
                                                            <div class="d-flex justify-content-between align-items-center w-100 me-3">
                                                                <div class="d-flex align-items-center flex-grow-1">
                                                                    <span class="question-number">Q{{ $index + 1 }}</span>
                                                                    <span class="question-title">{{ $item->question }}</span>
                                                                </div>
                                                                <div class="status-badges">
                                                                    @if ($item->is_urgent)
                                                                        <span class="badge bg-danger">緊急</span>
                                                                    @else
                                                                        <span class="badge bg-secondary">一般</span>
                                                                    @endif
                                                                    {{-- @if ($item->is_confirmed)
                                                                        <span class="badge bg-success me-2">已確認</span>
                                                                    @else
                                                                        <span class="badge bg-warning text-dark me-2">待確認</span>
                                                                    @endif --}}
                                                                    <small class="text-muted ms-2">{{ $item->date }}</small>
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <div id="collapse{{ $index }}" 
                                                         class="accordion-collapse collapse" 
                                                         aria-labelledby="heading{{ $index }}" 
                                                         data-bs-parent="#supplementAccordion">
                                                        <div class="accordion-body">
                                                            <div class="mb-4">
                                                                <label class="form-label fw-bold fs-5" style="color: #374151;">請回覆：</label>
                                                                <textarea name="answer[]" 
                                                                          class="form-control" 
                                                                          rows="5" 
                                                                          placeholder="請在此輸入您的回覆..."
                                                                          {{ $item->is_confirmed ? 'readonly' : '' }}
                                                                          style="{{ $item->is_confirmed ? 'background-color: #f9fafb;' : '' }}; border-radius: 1rem; border: 2px solid #e5e7eb; padding: 1rem;">{{ $item->answer }}</textarea>
                                                                <input type="hidden" name="supplement_id[]" value="{{ $item->id }}">
                                                            </div>
                                                            @if ($item->note)
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold fs-6" style="color: #6b7280;">備註：</label>
                                                                    <textarea name="note[]" 
                                                                              class="form-control" 
                                                                              rows="2" 
                                                                              readonly 
                                                                              style="background-color: #f9fafb; border-radius: 1rem; border: 2px solid #e5e7eb; padding: 0.75rem;">{{ $item->note }}</textarea>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="alert alert-info">目前尚無補充資料。</div>
                                            @endforelse
                                            </div>

                                            @php
                                                $all_submitted =
                                                    $supplements->count() > 0 &&
                                                    $supplements->every(fn($item) => $item->status == 1);
                                            @endphp

                                            @if (count($supplements) > 0)
                                                <div class="text-end d-flex gap-2 justify-content-end">
                                                    @if (empty($all_submitted) || !$all_submitted)
                                                        <button type="submit" name="action" value="save"
                                                            class="btn btn-secondary">
                                                            暫存
                                                        </button>
                                                    @endif
                                                    <button type="submit" name="action" value="submit"
                                                        class="btn btn-success"
                                                        {{ !empty($all_submitted) && $all_submitted ? 'disabled' : '' }}>
                                                        確認送出
                                                    </button>
                                                </div>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- container -->

    <!-- Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <i class="bx bx-check-circle display-1 text-success"></i>
                    <h4 class="mt-3" id="successModalLabel"></h4>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/js/twzipcode-1.4.1-min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 1500
                });
            @endif

            // 全部展開/收合功能
            let isAllExpanded = false;
            $('#expandAllBtn').on('click', function() {
                const accordionItems = $('.accordion-collapse');
                const button = $(this);
                
                if (isAllExpanded) {
                    // 全部收合 - 從最後一個開始，有延遲效果
                    button.text('收合中...').prop('disabled', true);
                    
                    accordionItems.each(function(index) {
                        const item = $(this);
                        setTimeout(function() {
                            item.removeClass('show');
                            item.closest('.accordion-item').addClass('animate-collapse');
                        }, (accordionItems.length - index - 1) * 100);
                    });
                    
                    setTimeout(function() {
                        button.text('全部展開').prop('disabled', false);
                        $('.accordion-item').removeClass('animate-collapse');
                    }, accordionItems.length * 100 + 300);
                    
                    isAllExpanded = false;
                } else {
                    // 全部展開 - 從第一個開始，有延遲效果
                    button.text('展開中...').prop('disabled', true);
                    
                    accordionItems.each(function(index) {
                        const item = $(this);
                        setTimeout(function() {
                            item.addClass('show');
                            item.closest('.accordion-item').addClass('animate-expand');
                        }, index * 100);
                    });
                    
                    setTimeout(function() {
                        button.text('全部收合').prop('disabled', false);
                        $('.accordion-item').removeClass('animate-expand');
                    }, accordionItems.length * 100 + 300);
                    
                    isAllExpanded = true;
                }
            });

            // 所有項目預設都是收合狀態
            $('.accordion-collapse').removeClass('show');
        });
    </script>
@endsection
