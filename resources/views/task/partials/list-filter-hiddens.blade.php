@php
    $listQuery = $listQuery ?? session('task_list_filters', []);
    if (! is_array($listQuery)) {
        $listQuery = [];
    }
@endphp
@foreach (['project_name', 'task_template_id', 'status', 'user_id', 'page'] as $filterKey)
    @if (!empty($listQuery[$filterKey]))
        <input type="hidden" name="{{ $filterKey }}" value="{{ $listQuery[$filterKey] }}">
    @endif
@endforeach
