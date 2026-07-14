@extends('layouts.vertical', ['title' => '官網合作客戶'])

@section('content')
    <div class="container-fluid">
        @include('layouts.shared.page-title', ['title' => '合作客戶 Logo', 'subtitle' => '前端管理'])

        @include('landing_admin.partials.preview_bar')

        <div class="mb-3 small">
            <a href="{{ route('landing.industry-categories') }}" class="text-muted"><i class="mdi mdi-arrow-left"></i> 回產業類別列表</a>
        </div>

        <div class="row mb-3">
            <div class="col-md-8">
                <form method="GET" class="d-flex gap-2">
                    <select name="category_id" class="form-select" onchange="this.form.submit()">
                        <option value="">全部產業類別</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected((string) $categoryId === (string) $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div class="col-md-4 text-md-end">
                <button type="button" class="btn btn-danger btn-sm js-brand-client-create"
                    data-bs-toggle="modal"
                    data-bs-target="#brandClientModal"
                    data-category-id="{{ $categoryId }}">
                    <i class="mdi mdi-plus-circle me-1"></i>新增合作客戶
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
                        <div class="table-responsive">
                            <table class="table table-centered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Logo</th>
                                        <th>名稱</th>
                                        <th>產業類別</th>
                                        <th>排序</th>
                                        <th>狀態</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody id="brandClientsTbody">
                                    @forelse ($datas as $key => $data)
                                        <tr data-id="{{ $data->id }}">
                                            <td class="col-index">{{ $key + 1 }}</td>
                                            <td class="col-logo">
                                                @if ($data->logoUrl())
                                                    <img src="{{ $data->logoUrl() }}" alt="{{ $data->name }}" style="height:36px;max-width:80px;object-fit:contain;">
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td class="col-name">{{ $data->name }}</td>
                                            <td class="col-category">{{ $data->category->name ?? '—' }}</td>
                                            <td class="col-seq">{{ $data->seq }}</td>
                                            <td class="col-status">{{ $data->status === 'up' ? '啟用' : '停用' }}</td>
                                            <td class="col-actions">
                                                <a href="javascript:void(0)" class="action-icon js-brand-client-edit"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#brandClientModal"
                                                    data-item="{{ json_encode([
                                                        'id' => $data->id,
                                                        'category_id' => $data->category_id,
                                                        'name' => $data->name,
                                                        'seq' => $data->seq,
                                                        'status' => $data->status,
                                                        'logo_url' => $data->logoUrl(),
                                                    ], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) }}"
                                                    title="編輯">
                                                    <i class="mdi mdi-square-edit-outline"></i>
                                                </a>
                                                @if ((int) (Auth::user()->level ?? 2) !== 2)
                                                    <a href="{{ route('landing.brand-clients.del', $data->id) }}" class="action-icon" title="刪除"><i class="mdi mdi-trash-can-outline"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="js-empty-row"><td colspan="7" class="text-center text-muted">尚無資料</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="brandClientModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form class="modal-content" id="brandClientForm" method="POST" action="{{ route('landing.brand-clients.create.data') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="brandClientModalTitle">新增合作客戶</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">產業類別<span class="text-danger">*</span></label>
                        <select class="form-control" name="category_id" id="brandClientCategory" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">客戶名稱<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="brandClientName" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Logo 圖片</label>
                        <input type="file" class="form-control" name="logo" id="brandClientLogo" accept="image/*">
                        <div class="mt-2 d-none" id="brandClientLogoPreviewWrap">
                            <img src="" alt="" id="brandClientLogoPreview" style="height:48px;max-width:120px;object-fit:contain;">
                        </div>
                        <div class="form-check mt-2 d-none" id="brandClientRemoveLogoWrap">
                            <input type="checkbox" class="form-check-input" id="brandClientRemoveLogo" name="remove_logo" value="1">
                            <label class="form-check-label" for="brandClientRemoveLogo">移除現有 Logo</label>
                        </div>
                        <small class="text-muted">未上傳 Logo 時，前台將顯示文字名稱。</small>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">排序</label>
                            <input type="number" class="form-control" name="seq" id="brandClientSeq" value="0">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">狀態</label>
                            <select class="form-control" name="status" id="brandClientStatus">
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
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var modalEl = document.getElementById('brandClientModal');
    if (!modalEl) return;

    var form = document.getElementById('brandClientForm');
    var createUrl = @json(route('landing.brand-clients.create.data'));
    var editUrlTemplate = @json(route('landing.brand-clients.edit.data', ['id' => '__ID__']));
    var defaultCategoryId = @json((string) ($categoryId ?? ''));
    var filterCategoryId = defaultCategoryId;
    var submitBtn = form.querySelector('[type="submit"]');

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

    function resetLogoFields() {
        document.getElementById('brandClientLogo').value = '';
        document.getElementById('brandClientRemoveLogo').checked = false;
        document.getElementById('brandClientLogoPreview').src = '';
        document.getElementById('brandClientLogoPreviewWrap').classList.add('d-none');
        document.getElementById('brandClientRemoveLogoWrap').classList.add('d-none');
    }

    function escapeHtml(str) {
        return String(str == null ? '' : str)
            .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;').replace(/'/g, '&#039;');
    }

    function buildRow(item, index) {
        var tr = document.createElement('tr');
        tr.setAttribute('data-id', item.id);
        tr.innerHTML =
            '<td class="col-index">' + index + '</td>' +
            '<td class="col-logo"></td>' +
            '<td class="col-name">' + escapeHtml(item.name) + '</td>' +
            '<td class="col-category">' + escapeHtml(item.category_name) + '</td>' +
            '<td class="col-seq">' + escapeHtml(item.seq) + '</td>' +
            '<td class="col-status">' + escapeHtml(item.status_label) + '</td>' +
            '<td class="col-actions"></td>';

        var logoCell = tr.querySelector('.col-logo');
        if (item.logo_url) {
            var img = document.createElement('img');
            img.src = item.logo_url;
            img.alt = item.name || '';
            img.style.cssText = 'height:36px;max-width:80px;object-fit:contain;';
            logoCell.appendChild(img);
        } else {
            logoCell.innerHTML = '<span class="text-muted">—</span>';
        }

        var actions = tr.querySelector('.col-actions');
        var editBtn = document.createElement('a');
        editBtn.href = 'javascript:void(0)';
        editBtn.className = 'action-icon js-brand-client-edit';
        editBtn.setAttribute('data-bs-toggle', 'modal');
        editBtn.setAttribute('data-bs-target', '#brandClientModal');
        editBtn.setAttribute('data-item', JSON.stringify({
            id: item.id,
            category_id: item.category_id,
            name: item.name,
            seq: item.seq,
            status: item.status,
            logo_url: item.logo_url,
        }));
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
        var tbody = document.getElementById('brandClientsTbody');
        if (!tbody) return;

        var empty = tbody.querySelector('.js-empty-row');
        if (empty) empty.remove();

        var existing = tbody.querySelector('tr[data-id="' + item.id + '"]');

        if (filterCategoryId && String(item.category_id) !== String(filterCategoryId)) {
            if (existing) existing.remove();
            renumber(tbody);
            if (!tbody.querySelector('tr[data-id]')) {
                tbody.innerHTML = '<tr class="js-empty-row"><td colspan="7" class="text-center text-muted">尚無資料</td></tr>';
            }
            return;
        }

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

        resetLogoFields();

        if (button.classList.contains('js-brand-client-edit')) {
            var item = {};
            try {
                item = JSON.parse(button.getAttribute('data-item') || '{}');
            } catch (e) {
                item = {};
            }

            document.getElementById('brandClientModalTitle').textContent = '編輯合作客戶';
            form.action = editUrlTemplate.replace('__ID__', item.id);
            document.getElementById('brandClientCategory').value = String(item.category_id || '');
            document.getElementById('brandClientName').value = item.name || '';
            document.getElementById('brandClientSeq').value = item.seq ?? 0;
            document.getElementById('brandClientStatus').value = item.status || 'up';

            if (item.logo_url) {
                document.getElementById('brandClientLogoPreview').src = item.logo_url;
                document.getElementById('brandClientLogoPreview').alt = item.name || '';
                document.getElementById('brandClientLogoPreviewWrap').classList.remove('d-none');
                document.getElementById('brandClientRemoveLogoWrap').classList.remove('d-none');
            }
        } else {
            document.getElementById('brandClientModalTitle').textContent = '新增合作客戶';
            form.action = createUrl;
            document.getElementById('brandClientCategory').value = defaultCategoryId || (document.getElementById('brandClientCategory').options[0]?.value || '');
            document.getElementById('brandClientName').value = '';
            document.getElementById('brandClientSeq').value = 0;
            document.getElementById('brandClientStatus').value = 'up';
        }
    });

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '儲存中…';
        }

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: new FormData(form),
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
            if (err && err.errors) msg = Object.values(err.errors).flat().join('、');
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
