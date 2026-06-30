@php
    $selectedUserId = $selectedUserId ?? null;
    $context = $context ?? '';
    $contextRequired = !empty($contextRequired);
@endphp
<div class="executor-entry border rounded p-3 mb-3 bg-light">
    <div class="d-flex justify-content-end mb-2">
        <button type="button" class="btn btn-danger btn-sm remove-executor" aria-label="移除執行人員">
            <i class="mdi mdi-trash-can-outline"></i>
        </button>
    </div>
    <div class="mb-3">
        <label class="d-block small text-muted mb-1">執行人員</label>
        <select class="form-control w-100" data-toggle="select" data-width="100%" name="user_ids[]" required>
            @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ (string) $selectedUserId === (string) $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
            @endforeach
            <option value="">無</option>
        </select>
    </div>
    <div>
        <label class="d-block small text-muted mb-1">派工項目</label>
        <textarea class="form-control w-100 executor-context-input" name="contexts[]" rows="4"
            placeholder="派工項目（選派工項目後自動帶入項目名稱，可修改）" @if ($contextRequired) required @endif>{{ $context }}</textarea>
    </div>
</div>
