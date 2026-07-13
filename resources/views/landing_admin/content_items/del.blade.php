@extends('layouts.vertical', ['title' => '刪除官網區塊項目'])

@section('content')
    <div class="container-fluid">
        @include('layouts.shared.page-title', ['title' => '刪除項目', 'subtitle' => '前端管理'])

        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <p>確定要刪除「{{ $data->title }}」嗎？</p>
                        <form action="{{ route('landing.content-items.del.data', $data->id) }}" method="POST">
                            @csrf
                            @if (!empty($sectionKey))
                                <input type="hidden" name="section" value="{{ $sectionKey }}">
                            @endif
                            <button type="submit" class="btn btn-danger m-1">確認刪除</button>
                            @if (!empty($sectionKey))
                                <a href="{{ route('landing.sections', ['section' => $sectionKey]) }}" class="btn btn-secondary m-1">取消</a>
                            @else
                                <button type="button" class="btn btn-secondary m-1" onclick="history.go(-1)">取消</button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
