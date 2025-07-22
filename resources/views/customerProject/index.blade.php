@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', ['title' => '專案瀏覽', 'subtitle' => Auth::user()->name])

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap table-striped" id="products-datatable">
                                <thead>
                                    <tr align="center">
                                        <th scope="col">No</th>
                                        <th scope="col">申請年度</th>
                                        <th scope="col">客戶名稱</th>
                                        <th scope="col">專案名稱</th>
                                        <th scope="col" style="width: 200px;">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $key => $data)
                                        <tr align="center">
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $data->year }}年</td>
                                            <td>
                                                {{ $data->user_data->name }}
                                            </td>
                                            <td>
                                                {{ $data->name }}
                                            </td>
                                            <td align="center">
                                                @if ($data->type == 3)
                                                    <ul class="list-inline mb-0">
                                                        <li class="list-inline-item">
                                                            <a class="table-action-btn btn btn-outline-primary waves-effect"
                                                                href="{{ route('customer.project.sbir.appendix', \App\Services\EncryptionService::encryptProjectId($data->id)) }}">
                                                                瀏覽
                                                            </a>
                                                        </li>
                                                    </ul>
                                                @endif
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
