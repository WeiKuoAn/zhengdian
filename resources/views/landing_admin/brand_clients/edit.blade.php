@extends('layouts.vertical', ['title' => '編輯合作客戶'])

@section('content')
    <div class="container-fluid">
        @include('layouts.shared.page-title', ['title' => '編輯合作客戶', 'subtitle' => '前端管理'])
        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        @include('landing_admin.brand_clients._form', [
                            'action' => route('landing.brand-clients.edit.data', $data->id),
                            'data' => $data,
                            'categories' => $categories,
                            'defaultCategoryId' => $data->category_id,
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
