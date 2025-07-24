@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', ['title' => '會議瀏覽', 'subtitle' => Auth::user()->name])

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap table-striped" id="products-datatable">
                                <thead>
                                    <tr align="center">
                                        <th scope="col">No</th>
                                        <th scope="col">會議時間</th>
                                        <th scope="col">會議名稱</th>
                                        <th scope="col">確認狀態</th>
                                        <th scope="col" style="width: 200px;">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $key=>$data)
                                        @php
                                            $encrypted_id = \App\Services\EncryptionService::encryptProjectId($data->id);
                                        @endphp
                                        <tr>
                                            <td align="center">{{ $key+1 }}</td>
                                            <td align="center">{{ $data->date }}</td>
                                            <td align="center">{{ $data->name }}</td>
                                            <td align="center">
                                                @if ($data->status == 1)
                                                    已確認 / {{ $data->confirm_time }}
                                                @else
                                                    未確認
                                                @endif
                                            </td>
                                            <td align="center">
                                                <a href="{{ route('customer.meet.check', $encrypted_id) }}" class="btn btn-sm btn-info">確認會議</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->

    </div> <!-- container -->
    <script>
        function deleteProject(id) {
            if (!confirm("確定要刪除嗎？")) return;
            fetch(`{{ url('/project') }}/${id}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    location.reload(); // 重新整理頁面
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
@endsection
