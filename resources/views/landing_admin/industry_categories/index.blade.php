@extends('layouts.vertical', ['title' => '產業類別與客戶 Logo'])

@section('content')
    <div class="container-fluid">
        @include('layouts.shared.page-title', ['title' => '產業類別與客戶 Logo', 'subtitle' => '前端管理'])

        @include('landing_admin.partials.preview_bar')

        <div class="alert alert-light border mb-3 small">
            先建立<strong>產業類別</strong>，再點每列的 <i class="mdi mdi-view-grid"></i> 圖示上傳該產業下的客戶 Logo。
            區塊標題請到 <a href="{{ route('landing.sections', ['section' => 'cases']) }}">編輯官網 → 產業案例</a> 修改。
        </div>
        <div class="d-flex flex-wrap gap-2 mb-3">
            <button type="button" class="btn btn-danger btn-sm js-industry-create"
                data-bs-toggle="modal" data-bs-target="#industryCategoryModal">
                <i class="mdi mdi-plus-circle me-1"></i>新增產業類別
            </button>
            <a href="{{ route('landing.sections', ['section' => 'cases']) }}" class="btn btn-outline-secondary btn-sm">
                <i class="mdi mdi-arrow-left me-1"></i>回產業案例文案
            </a>
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
                                        <th>代碼</th>
                                        <th>名稱</th>
                                        <th>客戶數</th>
                                        <th>欄數</th>
                                        <th>排序</th>
                                        <th>狀態</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody id="industryCategoriesTbody">
                                    @foreach ($datas as $key => $data)
                                        <tr data-id="{{ $data->id }}">
                                            <td class="col-index">{{ $key + 1 }}</td>
                                            <td class="col-code">{{ $data->code }}</td>
                                            <td class="col-name">{{ $data->name }}</td>
                                            <td class="col-count">{{ $data->brand_clients_count }}</td>
                                            <td class="col-grid">{{ $data->grid_columns }}</td>
                                            <td class="col-seq">{{ $data->seq }}</td>
                                            <td class="col-status">{{ $data->status === 'up' ? '啟用' : '停用' }}</td>
                                            <td class="col-actions">
                                                <a href="{{ route('landing.brand-clients', ['category_id' => $data->id]) }}" class="action-icon" title="管理客戶"><i class="mdi mdi-view-grid"></i></a>
                                                <a href="javascript:void(0)" class="action-icon js-industry-edit"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#industryCategoryModal"
                                                    data-item="{{ json_encode([
                                                        'id' => $data->id,
                                                        'code' => $data->code,
                                                        'name' => $data->name,
                                                        'description' => $data->description,
                                                        'grid_columns' => $data->grid_columns,
                                                        'seq' => $data->seq,
                                                        'status' => $data->status,
                                                    ], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) }}"
                                                    title="編輯">
                                                    <i class="mdi mdi-square-edit-outline"></i>
                                                </a>
                                                @if ((int) (Auth::user()->level ?? 2) !== 2)
                                                    <a href="{{ route('landing.industry-categories.del', $data->id) }}" class="action-icon" title="刪除"><i class="mdi mdi-trash-can-outline"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="industryCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form class="modal-content" id="industryCategoryForm" method="POST" action="{{ route('landing.industry-categories.create.data') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="industryCategoryModalTitle">新增產業類別</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">類別代碼</label>
                        <input type="text" class="form-control" name="code" id="industryCode" placeholder="CATEGORY 01">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">名稱<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="industryName" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">說明</label>
                        <textarea class="form-control" name="description" id="industryDescription" rows="4"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Logo 牆欄數</label>
                            <input type="number" min="2" max="8" class="form-control" name="grid_columns" id="industryGridColumns" value="6">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">排序</label>
                            <input type="number" class="form-control" name="seq" id="industrySeq" value="0">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">狀態</label>
                            <select class="form-control" name="status" id="industryStatus">
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
    var modalEl = document.getElementById('industryCategoryModal');
    if (!modalEl) return;

    var form = document.getElementById('industryCategoryForm');
    var createUrl = @json(route('landing.industry-categories.create.data'));
    var editUrlTemplate = @json(route('landing.industry-categories.edit.data', ['id' => '__ID__']));
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
            '<td class="col-code">' + escapeHtml(item.code) + '</td>' +
            '<td class="col-name">' + escapeHtml(item.name) + '</td>' +
            '<td class="col-count">' + escapeHtml(item.brand_clients_count) + '</td>' +
            '<td class="col-grid">' + escapeHtml(item.grid_columns) + '</td>' +
            '<td class="col-seq">' + escapeHtml(item.seq) + '</td>' +
            '<td class="col-status">' + escapeHtml(item.status_label) + '</td>' +
            '<td class="col-actions"></td>';

        var actions = tr.querySelector('.col-actions');
        var clientsBtn = document.createElement('a');
        clientsBtn.href = item.clients_url;
        clientsBtn.className = 'action-icon';
        clientsBtn.title = '管理客戶';
        clientsBtn.innerHTML = '<i class="mdi mdi-view-grid"></i>';
        actions.appendChild(clientsBtn);

        var editBtn = document.createElement('a');
        editBtn.href = 'javascript:void(0)';
        editBtn.className = 'action-icon js-industry-edit';
        editBtn.setAttribute('data-bs-toggle', 'modal');
        editBtn.setAttribute('data-bs-target', '#industryCategoryModal');
        editBtn.setAttribute('data-item', JSON.stringify({
            id: item.id,
            code: item.code,
            name: item.name,
            description: item.description,
            grid_columns: item.grid_columns,
            seq: item.seq,
            status: item.status,
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
        var tbody = document.getElementById('industryCategoriesTbody');
        if (!tbody) return;
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

        if (button.classList.contains('js-industry-edit')) {
            var item = {};
            try {
                item = JSON.parse(button.getAttribute('data-item') || '{}');
            } catch (e) {
                item = {};
            }

            document.getElementById('industryCategoryModalTitle').textContent = '編輯產業類別';
            form.action = editUrlTemplate.replace('__ID__', item.id);
            document.getElementById('industryCode').value = item.code || '';
            document.getElementById('industryName').value = item.name || '';
            document.getElementById('industryDescription').value = item.description || '';
            document.getElementById('industryGridColumns').value = item.grid_columns ?? 6;
            document.getElementById('industrySeq').value = item.seq ?? 0;
            document.getElementById('industryStatus').value = item.status || 'up';
        } else {
            document.getElementById('industryCategoryModalTitle').textContent = '新增產業類別';
            form.action = createUrl;
            document.getElementById('industryCode').value = '';
            document.getElementById('industryName').value = '';
            document.getElementById('industryDescription').value = '';
            document.getElementById('industryGridColumns').value = 6;
            document.getElementById('industrySeq').value = 0;
            document.getElementById('industryStatus').value = 'up';
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
