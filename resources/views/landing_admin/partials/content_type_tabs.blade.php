@php
    $contentType = $type ?? request('type', 'stat');
@endphp
<div class="landing-type-tabs d-flex flex-wrap gap-2">
    @foreach ($typeLabels as $key => $label)
        <a href="{{ route('landing.content-items', ['type' => $key]) }}"
            class="btn btn-sm {{ $contentType === $key ? 'btn-primary' : 'btn-light border' }}">{{ $label }}</a>
    @endforeach
</div>
