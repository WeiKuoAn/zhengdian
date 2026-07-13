@extends('layouts.vertical', ['title' => '新增產業類別'])

@section('content')
    <div class="container-fluid">
        @include('layouts.shared.page-title', ['title' => '新增產業類別', 'subtitle' => '前端管理'])
        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        @include('landing_admin.industry_categories._form', [
                            'action' => route('landing.industry-categories.create.data'),
                            'data' => null,
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
