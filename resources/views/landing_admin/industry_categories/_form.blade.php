<form action="{{ $action }}" method="POST">
    @csrf
    <div class="mb-3">
        <label class="form-label">類別代碼</label>
        <input type="text" class="form-control" name="code" value="{{ old('code', $data->code ?? '') }}" placeholder="CATEGORY 01">
    </div>
    <div class="mb-3">
        <label class="form-label">名稱<span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="name" value="{{ old('name', $data->name ?? '') }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">說明</label>
        <textarea class="form-control" name="description" rows="4">{{ old('description', $data->description ?? '') }}</textarea>
    </div>
    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Logo 牆欄數</label>
            <input type="number" min="2" max="8" class="form-control" name="grid_columns" value="{{ old('grid_columns', $data->grid_columns ?? 6) }}">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">排序</label>
            <input type="number" class="form-control" name="seq" value="{{ old('seq', $data->seq ?? 0) }}">
        </div>
        <div class="col-md-4 mb-3">
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
