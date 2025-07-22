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
            /* 可選，讓readonly更明顯 */
        }
    </style>
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', [
            'title' => $project->user_data->name,
            'subtitle' => '專案瀏覽',
        ])

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
                                            @forelse($supplements as $index => $item)
                                                <div class="card mb-4 shadow-sm border border-secondary rounded-4"
                                                    style="border-width:2px;">
                                                    <div class="card-body">
                                                        <div class="row mb-2 align-items-center">
                                                            <div class="col-md-3 col-12 mb-2 mb-md-0">
                                                                <span class="fw-bold">日期：</span>{{ $item->date }}
                                                            </div>
                                                            <div class="col-md-3 col-6">
                                                                <span class="fw-bold">緊急度：</span>
                                                                @if ($item->is_urgent)
                                                                    <span class="badge bg-danger px-3 pt-1 pb-1 ">緊急</span>
                                                                @else
                                                                    <span
                                                                        class="badge bg-secondary px-3 pt-1 pb-1  ">一般</span>
                                                                @endif
                                                            </div>
                                                            <div class="col-md-3 col-6">
                                                                <span class="fw-bold">狀態：</span>
                                                                @if ($item->is_confirmed)
                                                                    <span class="badge bg-success px-3 pt-1 pb-1">已確認</span>
                                                                @else
                                                                    <span
                                                                        class="badge bg-warning text-dark px-3 pt-1 pb-1">待確認</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="mb-2">
                                                            <span class="fw-bold text-dark fs-4">問題：</span>
                                                            <span
                                                                class="fw-bold text-dark fs-4">{{ $item->question }}</span>
                                                        </div>
                                                        <div class="mb-2">
                                                            <span class="fw-bold text-dark fs-5">回復：</span>
                                                            <textarea name="answer[]" class="form-control bg-light rounded-3 fs-5" rows="4"
                                                                {{ $item->is_confirmed ? 'readonly' : '' }}>{{ $item->answer }}</textarea>
                                                            <input type="hidden" name="supplement_id[]"
                                                                value="{{ $item->id }}">
                                                        </div>
                                                        @if ($item->note)
                                                            <div>
                                                                <span class="fw-bold text-dark fs-5">備註：</span>
                                                                <textarea name="note[]" class="form-control bg-light rounded-3 fs-5" rows="1"
                                                                    {{ $item->note ? 'readonly' : '' }}>{{ $item->note }}</textarea>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="alert alert-info">目前尚無補充資料。</div>
                                            @endforelse

                                            @php
                                                $all_submitted = $supplements->count() > 0 && $supplements->every(fn($item) => $item->status == 1);
                                            @endphp

                                            @if (count($supplements) > 0)
                                                <div class="text-end d-flex gap-2 justify-content-end">
                                                    @if(empty($all_submitted) || !$all_submitted)
                                                        <button type="submit" name="action" value="save" class="btn btn-secondary">
                                                            暫存
                                                        </button>
                                                    @endif
                                                    <button type="submit" name="action" value="submit" class="btn btn-success" {{ !empty($all_submitted) && $all_submitted ? 'disabled' : '' }}>
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
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 1500
        });
    @endif
});
</script>
@endsection
