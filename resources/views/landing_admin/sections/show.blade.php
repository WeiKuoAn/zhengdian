@php
    $settingLabels = [
        'meta_title' => '頁面標題',
        'meta_description' => '搜尋結果描述',
        'hero_eyebrow' => '上方小標',
        'hero_tagline' => '副標語',
        'hero_title' => '主標題',
        'hero_lead' => '說明文字',
        'hero_btn_primary' => '主要按鈕',
        'hero_btn_secondary' => '次要按鈕',
        'workflow_footer' => '流程底部補充',
        'cases_disclaimer' => '免責聲明',
        'academic_note' => '底部備註',
        'cta_title' => '聯絡區標題',
        'cta_text' => '聯絡區說明',
        'contact_name' => '服務窗口',
        'contact_phone' => '手機',
        'contact_tel' => '市話',
        'contact_email' => 'Email',
        'contact_line_url' => 'LINE 連結',
        'footer_desc' => '頁尾簡介',
    ];
    foreach (['services', 'workflow', 'themes', 'scenarios', 'cases', 'academic', 'why'] as $prefix) {
        $settingLabels[$prefix . '_eyebrow'] = '小標籤';
        $settingLabels[$prefix . '_title'] = '區塊標題';
        $settingLabels[$prefix . '_subtitle'] = '區塊說明';
    }
    $settingKeys = \App\Support\LandingSectionRegistry::settingKeysFor($sectionKey);
    $previewUrl = route('landing.test') . ($section['anchor'] ?? '');
@endphp

@extends('layouts.vertical', ['title' => '編輯官網｜' . $section['label']])

@section('css')
<style>
.landing-editor-hero {
    background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 55%, #2563eb 100%);
    border-radius: 16px;
    color: #fff;
    padding: 24px 28px;
}
.landing-section-nav {
    margin-bottom: 1.5rem;
}
.landing-section-nav .card-body {
    padding: 16px !important;
}
.landing-section-tabs {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
    gap: 8px;
    width: 100%;
}
.landing-section-tabs .tab-link {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 9px 12px;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    background: #fff;
    color: #475569;
    font-size: 12px;
    font-weight: 600;
    line-height: 1.3;
    text-align: center;
    min-width: 0;
    transition: all .2s ease;
}
.landing-section-tabs .tab-link i {
    font-size: 16px;
    flex-shrink: 0;
}
.landing-section-tabs .tab-link span {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.landing-section-tabs .tab-link:hover {
    border-color: #93c5fd;
    color: #1d4ed8;
    background: #eff6ff;
}
.landing-section-tabs .tab-link.active {
    background: linear-gradient(135deg, #1e3a8a, #2563eb);
    border-color: transparent;
    color: #fff;
    box-shadow: 0 4px 12px rgba(37, 99, 235, .2);
}
.landing-panel {
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    background: #fff;
    box-shadow: 0 8px 24px rgba(15, 23, 42, .04);
    overflow: hidden;
}
.landing-panel-header {
    padding: 18px 22px;
    border-bottom: 1px solid #f1f5f9;
    background: linear-gradient(180deg, #fafbff 0%, #fff 100%);
}
.landing-panel-body { padding: 22px; }
.landing-items-table {
    width: 100%;
    table-layout: fixed;
    margin-bottom: 0;
}
.landing-items-table thead th {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: .04em;
    color: #64748b;
    background: #f8fafc;
    white-space: nowrap;
    vertical-align: middle;
}
.landing-items-table td {
    vertical-align: middle;
    word-break: break-word;
}
.landing-items-table .col-index { width: 48px; }
.landing-items-table .col-title { width: 18%; }
.landing-items-table .col-sub { width: 20%; }
.landing-items-table .col-body {
    width: auto;
    max-width: 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.landing-items-table .col-seq { width: 64px; }
.landing-items-table .col-status { width: 88px; }
.landing-items-table .col-actions {
    width: 72px;
    white-space: nowrap;
}
.landing-type-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 999px;
    background: #eff6ff;
    color: #1d4ed8;
    font-size: 12px;
    font-weight: 700;
}
@media (max-width: 991.98px) {
    .landing-items-table .col-body,
    .landing-items-table .col-body-h {
        display: none;
    }
}
@media (max-width: 767.98px) {
    .landing-section-tabs {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
    .landing-items-table .col-sub,
    .landing-items-table .col-sub-h {
        display: none;
    }
}
.modal-dialog-scrollable form.modal-content {
    max-height: calc(100vh - 2rem);
    overflow: hidden;
    display: flex;
    flex-direction: column;
}
.modal-dialog-scrollable form.modal-content .modal-body {
    overflow-y: auto;
}
.modal-dialog-scrollable form.modal-content .modal-footer {
    flex-shrink: 0;
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    @include('layouts.shared.page-title', ['title' => '編輯官網', 'subtitle' => '前端管理'])

    @include('landing_admin.partials.preview_bar')

    <div class="landing-editor-hero mb-4 d-flex flex-wrap justify-content-between align-items-start gap-3">
        <div>
            <div class="small text-white-50 mb-1">依官網區段編輯 · 文案與列表在同一頁</div>
            <h4 class="mb-2 text-white">{{ $section['label'] }}</h4>
            <p class="mb-0 text-white-50">{{ $section['hint'] }}</p>
        </div>
        <a href="{{ $previewUrl }}" target="_blank" rel="noopener" class="btn btn-light btn-sm">
            <i class="mdi mdi-open-in-new me-1"></i>預覽此區段
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm landing-section-nav">
        <div class="card-body">
            <div class="landing-section-tabs">
                @foreach ($sections as $key => $meta)
                    <a href="{{ route('landing.sections', ['section' => $key]) }}"
                        class="tab-link {{ $sectionKey === $key ? 'active' : '' }}"
                        title="{{ $meta['label'] }}">
                        <i class="mdi {{ $meta['icon'] }}"></i>
                        <span>{{ $meta['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    @if ($settingKeys !== [])
        <div class="landing-panel mb-4">
            <div class="landing-panel-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">區塊文案</h5>
                    <div class="text-muted small">標題、說明等文字設定</div>
                </div>
            </div>
            <div class="landing-panel-body">
                <form method="POST" action="{{ route('landing.sections.update', $sectionKey) }}">
                    @csrf
                    <div class="row g-3">
                        @foreach ($settingKeys as $key)
                            @php
                                $isLong = in_array($key, [
                                    'meta_description', 'hero_title', 'hero_lead',
                                    'cta_title', 'cta_text', 'footer_desc',
                                    'cases_disclaimer', 'academic_note',
                                ], true) || str_ends_with($key, '_subtitle');
                            @endphp
                            <div class="{{ $isLong ? 'col-12' : 'col-md-6' }}">
                                <label class="form-label fw-semibold">{{ $settingLabels[$key] ?? $key }}</label>
                                @if ($isLong)
                                    <textarea class="form-control" name="{{ $key }}" rows="{{ in_array($key, ['hero_title', 'cta_title'], true) ? 2 : 3 }}">{{ old($key, $settings[$key] ?? '') }}</textarea>
                                @else
                                    <input type="text" class="form-control" name="{{ $key }}" value="{{ old($key, $settings[$key] ?? '') }}">
                                @endif
                                @if ($key === 'hero_title' || $key === 'cta_title')
                                    <div class="form-text">需要換行時按 Enter</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fe-check-circle me-1"></i>儲存文案
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if ($sectionKey === 'cases')
        <div class="alert alert-light border d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
            <div class="small mb-0">
                <i class="mdi mdi-information-outline me-1"></i>
                此頁只編輯區塊標題與說明。產業分類與客戶 Logo 請到獨立頁面管理。
            </div>
            <a href="{{ route('landing.industry-categories') }}" class="btn btn-sm btn-outline-primary">
                <i class="mdi mdi-domain me-1"></i>管理產業類別與 Logo
            </a>
        </div>
    @endif

    @foreach ($section['content_types'] ?? [] as $type)
        <div class="landing-panel mb-4">
            <div class="landing-panel-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <span class="landing-type-chip mb-2"><i class="mdi mdi-format-list-bulleted"></i>{{ $typeLabels[$type] ?? $type }}</span>
                    <div class="text-muted small">{{ $typeHints[$type] ?? '' }}</div>
                </div>
                <button type="button" class="btn btn-sm btn-danger js-content-item-create"
                    data-type="{{ $type }}"
                    data-type-label="{{ $typeLabels[$type] ?? $type }}"
                    data-bs-toggle="modal"
                    data-bs-target="#contentItemModal">
                    <i class="mdi mdi-plus-circle me-1"></i>新增
                </button>
            </div>
            <div class="landing-panel-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 landing-items-table">
                        <thead>
                            <tr>
                                <th class="col-index">#</th>
                                <th class="col-title">主標題 / 數字</th>
                                <th class="col-sub col-sub-h">副標 / 圖示</th>
                                <th class="col-body col-body-h">內容</th>
                                <th class="col-seq">排序</th>
                                <th class="col-status">狀態</th>
                                <th class="col-actions"></th>
                            </tr>
                        </thead>
                        <tbody data-content-type="{{ $type }}">
                            @forelse ($itemsByType[$type] ?? [] as $index => $item)
                                <tr data-id="{{ $item->id }}">
                                    <td class="col-index">{{ $index + 1 }}</td>
                                    <td class="col-title fw-semibold">{{ $item->title }}</td>
                                    <td class="col-sub">{{ $item->subtitle ?: $item->icon }}{{ $item->extra ? ' / ' . $item->extra : '' }}</td>
                                    <td class="col-body text-muted small" title="{{ $item->body }}">{{ \Illuminate\Support\Str::limit($item->body, 48) }}</td>
                                    <td class="col-seq">{{ $item->seq }}</td>
                                    <td class="col-status">
                                        <span class="badge {{ $item->status === 'up' ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary' }}">
                                            {{ $item->status === 'up' ? '顯示中' : '已隱藏' }}
                                        </span>
                                    </td>
                                    <td class="col-actions text-end">
                                        <a href="javascript:void(0)" class="action-icon js-content-item-edit"
                                            data-bs-toggle="modal"
                                            data-bs-target="#contentItemModal"
                                            data-item="{{ json_encode([
                                                'id' => $item->id,
                                                'type' => $item->type,
                                                'typeLabel' => $typeLabels[$item->type] ?? $item->type,
                                                'title' => $item->title,
                                                'subtitle' => $item->subtitle,
                                                'icon' => $item->icon,
                                                'extra' => $item->extra,
                                                'body' => $item->body,
                                                'seq' => $item->seq,
                                                'status' => $item->status,
                                            ], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) }}"
                                            title="編輯">
                                            <i class="mdi mdi-square-edit-outline"></i>
                                        </a>
                                        @if (in_array((int) (Auth::user()->level ?? 2), [0, 1], true))
                                            <a href="{{ route('landing.content-items.del', ['id' => $item->id, 'section' => $sectionKey]) }}" class="action-icon" title="刪除"><i class="mdi mdi-trash-can-outline"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr class="js-empty-row">
                                    <td colspan="7" class="text-center text-muted py-4">尚無資料，請按「新增」</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
</div>

@if (!empty($section['content_types']))
<div class="modal fade" id="contentItemModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <form class="modal-content" id="contentItemForm" method="POST" action="{{ route('landing.content-items.create.data') }}">
            @csrf
            <input type="hidden" name="type" id="contentItemType" value="">
            <input type="hidden" name="section" value="{{ $sectionKey }}">
            <div class="modal-header">
                <h5 class="modal-title" id="contentItemModalTitle">新增內容</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">類型</label>
                    <input type="text" class="form-control" id="contentItemTypeLabel" value="" disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">標題 / 數值<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="title" id="contentItemTitle" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">副標題</label>
                    <input type="text" class="form-control" name="subtitle" id="contentItemSubtitle">
                </div>
                <div class="mb-3 d-none" id="contentItemIconWrap">
                    <label class="form-label">圖示文字</label>
                    <input type="text" class="form-control" name="icon" id="contentItemIcon" placeholder="例如 $、C、AI">
                </div>
                <div class="mb-3 d-none" id="contentItemExtraWrap">
                    <label class="form-label">數值後綴</label>
                    <input type="text" class="form-control" name="extra" id="contentItemExtra" placeholder="例如 +">
                </div>
                <div class="mb-3">
                    <label class="form-label">內容</label>
                    <textarea class="form-control" name="body" id="contentItemBody" rows="4" placeholder="服務項目請一行一項"></textarea>
                    <small class="text-muted d-none" id="contentItemBodyHint">服務項目請每行一項。</small>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">排序</label>
                        <input type="number" class="form-control" name="seq" id="contentItemSeq" value="0">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">狀態</label>
                        <select class="form-control" name="status" id="contentItemStatus">
                            <option value="up">啟用</option>
                            <option value="down">停用</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">取消</button>
                <button type="submit" class="btn btn-success"><i class="fe-check-circle me-1"></i>儲存</button>
            </div>
        </form>
    </div>
</div>
@endif
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var modalEl = document.getElementById('contentItemModal');
    if (!modalEl) return;

    var form = document.getElementById('contentItemForm');
    var createUrl = @json(route('landing.content-items.create.data'));
    var editUrlTemplate = @json(route('landing.content-items.edit.data', ['id' => '__ID__']));
    var editingId = null;
    var submitBtn = form.querySelector('[type="submit"]');

    function escapeHtml(str) {
        return String(str == null ? '' : str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function showToast(message, isError) {
        var existing = document.getElementById('landingAjaxToast');
        if (existing) existing.remove();

        var el = document.createElement('div');
        el.id = 'landingAjaxToast';
        el.className = 'alert ' + (isError ? 'alert-danger' : 'alert-success') + ' shadow-sm';
        el.style.cssText = 'position:fixed;top:80px;right:24px;z-index:2000;min-width:220px;';
        el.textContent = message;
        document.body.appendChild(el);
        setTimeout(function () { el.remove(); }, 2500);
    }

    function toggleTypeFields(type) {
        document.getElementById('contentItemIconWrap').classList.toggle('d-none', type !== 'service');
        document.getElementById('contentItemExtraWrap').classList.toggle('d-none', type !== 'stat');
        document.getElementById('contentItemBodyHint').classList.toggle('d-none', type !== 'service');
    }

    function fillForm(data) {
        document.getElementById('contentItemType').value = data.type || '';
        document.getElementById('contentItemTypeLabel').value = data.typeLabel || '';
        document.getElementById('contentItemTitle').value = data.title || '';
        document.getElementById('contentItemSubtitle').value = data.subtitle || '';
        document.getElementById('contentItemIcon').value = data.icon || '';
        document.getElementById('contentItemExtra').value = data.extra || '';
        document.getElementById('contentItemBody').value = data.body || '';
        document.getElementById('contentItemSeq').value = data.seq ?? 0;
        document.getElementById('contentItemStatus').value = data.status || 'up';
        toggleTypeFields(data.type || '');
    }

    function itemJsonAttr(item) {
        return JSON.stringify({
            id: item.id,
            type: item.type,
            typeLabel: item.typeLabel,
            title: item.title,
            subtitle: item.subtitle,
            icon: item.icon,
            extra: item.extra,
            body: item.body,
            seq: item.seq,
            status: item.status,
        });
    }

    function buildRow(item, index) {
        var tr = document.createElement('tr');
        tr.setAttribute('data-id', item.id);

        var badgeClass = item.status_up ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary';
        var statusText = item.status_up ? '顯示中' : '已隱藏';

        tr.innerHTML =
            '<td class="col-index">' + index + '</td>' +
            '<td class="col-title fw-semibold">' + escapeHtml(item.title) + '</td>' +
            '<td class="col-sub">' + escapeHtml(item.sub_display) + '</td>' +
            '<td class="col-body text-muted small"></td>' +
            '<td class="col-seq">' + escapeHtml(item.seq) + '</td>' +
            '<td class="col-status"><span class="badge ' + badgeClass + '">' + statusText + '</span></td>' +
            '<td class="col-actions text-end"></td>';

        var bodyCell = tr.querySelector('.col-body');
        bodyCell.title = item.body || '';
        bodyCell.textContent = item.body_preview || '';

        var actions = tr.querySelector('.col-actions');
        var editBtn = document.createElement('a');
        editBtn.href = 'javascript:void(0)';
        editBtn.className = 'action-icon js-content-item-edit';
        editBtn.setAttribute('data-bs-toggle', 'modal');
        editBtn.setAttribute('data-bs-target', '#contentItemModal');
        editBtn.setAttribute('data-item', itemJsonAttr(item));
        editBtn.title = '編輯';
        editBtn.innerHTML = '<i class="mdi mdi-square-edit-outline"></i>';
        actions.appendChild(editBtn);

        if (item.can_delete) {
            var delBtn = document.createElement('a');
            delBtn.href = item.del_url;
            delBtn.className = 'action-icon';
            delBtn.title = '刪除';
            delBtn.innerHTML = '<i class="mdi mdi-trash-can-outline"></i>';
            actions.appendChild(delBtn);
        }

        return tr;
    }

    function renumber(tbody) {
        Array.prototype.forEach.call(tbody.querySelectorAll('tr[data-id]'), function (tr, i) {
            var cell = tr.querySelector('.col-index');
            if (cell) cell.textContent = i + 1;
        });
    }

    function upsertRow(item) {
        var tbody = document.querySelector('tbody[data-content-type="' + item.type + '"]');
        if (!tbody) return;

        var empty = tbody.querySelector('.js-empty-row');
        if (empty) empty.remove();

        var existing = tbody.querySelector('tr[data-id="' + item.id + '"]');
        var newRow = buildRow(item, 1);

        if (existing) {
            existing.replaceWith(newRow);
        } else {
            tbody.appendChild(newRow);
        }
        renumber(tbody);
    }

    modalEl.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        if (!button) return;

        var isEdit = button.classList.contains('js-content-item-edit');
        var type = button.getAttribute('data-type') || '';
        var typeLabel = button.getAttribute('data-type-label') || type;

        if (isEdit) {
            var item = {};
            try {
                item = JSON.parse(button.getAttribute('data-item') || '{}');
            } catch (e) {
                item = {};
            }
            editingId = item.id || null;
            document.getElementById('contentItemModalTitle').textContent = '編輯' + (item.typeLabel || '');
            form.action = editUrlTemplate.replace('__ID__', item.id);
            fillForm(item);
        } else {
            editingId = null;
            document.getElementById('contentItemModalTitle').textContent = '新增' + typeLabel;
            form.action = createUrl;
            fillForm({ type: type, typeLabel: typeLabel, seq: 0, status: 'up' });
        }
    });

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '儲存中…';
        }

        var fd = new FormData(form);
        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: fd,
            credentials: 'same-origin',
        })
        .then(function (res) {
            return res.json().then(function (data) {
                if (!res.ok) throw data;
                return data;
            });
        })
        .then(function (data) {
            if (!data.success) throw data;
            upsertRow(data.item);
            bootstrap.Modal.getInstance(modalEl).hide();
            showToast(data.message || '已儲存');
        })
        .catch(function (err) {
            var msg = (err && err.message) ? err.message : '儲存失敗，請再試一次';
            if (err && err.errors) {
                msg = Object.values(err.errors).flat().join('、');
            }
            showToast(msg, true);
        })
        .finally(function () {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fe-check-circle me-1"></i>儲存';
            }
        });
    });
});
</script>
@endsection
