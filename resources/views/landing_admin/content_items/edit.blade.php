@extends('layouts.vertical', ['title' => '編輯官網區塊項目'])

@section('content')
    <div class="container-fluid">
        @include('layouts.shared.page-title', ['title' => '編輯' . ($typeLabels[$data->type] ?? ''), 'subtitle' => '前端管理'])

        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        @include('landing_admin.content_items._form', [
                            'action' => route('landing.content-items.edit.data', $data->id),
                            'type' => $data->type,
                            'sectionKey' => $sectionKey ?? null,
                            'data' => $data,
                            'typeLabels' => $typeLabels,
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
