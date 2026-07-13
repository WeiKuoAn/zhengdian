@extends('layouts.vertical', ['title' => '刪除產業類別'])

@section('content')
    <div class="container-fluid">
        @include('layouts.shared.page-title', ['title' => '刪除產業類別', 'subtitle' => '前端管理'])
        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <p>確定要刪除「{{ $data->name }}」及其所有合作客戶嗎？</p>
                        <form action="{{ route('landing.industry-categories.del.data', $data->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger m-1">確認刪除</button>
                            <button type="button" class="btn btn-secondary m-1" onclick="history.go(-1)">取消</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
