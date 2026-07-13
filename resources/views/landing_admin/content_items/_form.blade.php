<form action="{{ $action }}" method="POST">
    @csrf
    <input type="hidden" name="type" value="{{ $type }}">

    <div class="mb-3">
        <label class="form-label">類型</label>
        <input type="text" class="form-control" value="{{ $typeLabels[$type] ?? $type }}" disabled>
    </div>
    <div class="mb-3">
        <label class="form-label">標題 / 數值<span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="title" value="{{ old('title', $data->title ?? '') }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">副標題</label>
        <input type="text" class="form-control" name="subtitle" value="{{ old('subtitle', $data->subtitle ?? '') }}">
    </div>
    @if (in_array($type, ['service'], true))
        <div class="mb-3">
            <label class="form-label">圖示文字</label>
            <input type="text" class="form-control" name="icon" value="{{ old('icon', $data->icon ?? '') }}" placeholder="例如 $、C、AI">
        </div>
    @endif
    @if (in_array($type, ['stat'], true))
        <div class="mb-3">
            <label class="form-label">數值後綴</label>
            <input type="text" class="form-control" name="extra" value="{{ old('extra', $data->extra ?? '') }}" placeholder="例如 +">
        </div>
    @endif
    <div class="mb-3">
        <label class="form-label">內容</label>
        <textarea class="form-control" name="body" rows="6" placeholder="服務項目請一行一項">{{ old('body', $data->body ?? '') }}</textarea>
        @if ($type === 'service')
            <small class="text-muted">服務項目請每行一項。</small>
        @endif
    </div>
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">排序</label>
            <input type="number" class="form-control" name="seq" value="{{ old('seq', $data->seq ?? 0) }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">狀態</label>
            <select class="form-control" name="status">
                <option value="up" @selected(old('status', $data->status ?? 'up') === 'up')>啟用</option>
                <option value="down" @selected(old('status', $data->status ?? 'up') === 'down')>停用</option>
            </select>
        </div>
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-success m-1"><i class="fe-check-circle me-1"></i>儲存</button>
        <button type="button" class="btn btn-secondary m-1" onclick="history.go(-1)"><i class="fe-x me-1"></i>回上一頁</button>
    </div>
</form>
