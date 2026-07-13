<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label class="form-label">產業類別<span class="text-danger">*</span></label>
        <select class="form-control" name="category_id" required>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected((string) old('category_id', $defaultCategoryId) === (string) $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">客戶名稱<span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="name" value="{{ old('name', $data->name ?? '') }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Logo 圖片</label>
        <input type="file" class="form-control" name="logo" accept="image/*">
        @if (!empty($data?->logoUrl()))
            <div class="mt-2">
                <img src="{{ $data->logoUrl() }}" alt="{{ $data->name }}" style="height:48px;max-width:120px;object-fit:contain;">
            </div>
            <div class="form-check mt-2">
                <input type="checkbox" class="form-check-input" id="remove_logo" name="remove_logo" value="1">
                <label class="form-check-label" for="remove_logo">移除現有 Logo</label>
            </div>
        @endif
        <small class="text-muted">未上傳 Logo 時，前台將顯示文字名稱。</small>
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
