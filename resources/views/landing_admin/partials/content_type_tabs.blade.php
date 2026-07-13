@php
    use App\Models\LandingContentItem;

    $contentType = $type ?? request('type', 'stat');
    $typeLabels = $typeLabels ?? LandingContentItem::typeLabels();
    $typeGroups = LandingContentItem::typeGroups();
@endphp

<div class="landing-type-tabs">
    @foreach ($typeGroups as $groupName => $types)
        <div class="mb-3">
            <div class="text-muted small fw-semibold mb-2">{{ $groupName }}</div>
            <div class="d-flex flex-wrap gap-2">
                @foreach ($types as $key)
                    <a href="{{ route('landing.content-items', ['type' => $key]) }}"
                        class="btn btn-sm {{ $contentType === $key ? 'btn-primary' : 'btn-light border' }}">
                        {{ $typeLabels[$key] ?? $key }}
                    </a>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
