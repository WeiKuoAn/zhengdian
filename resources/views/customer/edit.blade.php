@extends('layouts.vertical', ['title' => '編輯客戶'])

@section('content')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twzipcode/1.7.14/jquery.twzipcode.min.js"></script>
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', [
            'title' => '編輯客戶',
            'subtitle' => '客戶管理',
        ])

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('customer.edit.data',$data->id) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="AddNew-Username">客戶名稱</label><span
                                            class="text-danger">*</span>
                                        <input type="text" class="form-control" name="name" value="{{$data->name}}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="AddNew-Username">客戶帳號</label><span
                                            class="text-danger">*</span>
                                        <input type="text" class="form-control" name="email" value="{{$data->email}}" required>
                                    </div>
                                </div>


                                <div class="col-md-6 ">
                                    <label class="form-label" for="AddNew-Username">客戶密碼</label><span
                                        class="text-danger">*</span>
                                    <div class="mb-3 row">
                                        <div class="col-9">
                                            <input class="form-control me-auto" type="password" value="{{$data->password}}" name="password"
                                                placeholder="請產生密碼" required>
                                        </div>
                                        <div class="col-3">
                                            <button type="bytton" id="pwd_create"
                                                class="btn btn-outline-danger">生成密碼</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="AddNew-Phone">公司統編</label>
                                        <input type="text" class="form-control" name="registration_no" value="{{$data->cust_data->registration_no }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="AddNew-Phone">公司負責人</label>
                                        <input type="text" class="form-control" name="principal_name" value="{{$data->cust_data->principal_name }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="AddNew-Phone">公司資本額</label>
                                        <input type="text" class="form-control" name="capital" value="{{$data->cust_data->capital }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="AddNew-Phone">檢附資料說明連結</label><span
                                            class="text-danger">*</span>
                                        <input type="text" class="form-control" name="attached_link" value="{{$data->cust_data->attached_link }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="AddNew-Phone">上傳附件連結</label><span
                                            class="text-danger">*</span>
                                        <input type="text" class="form-control" name="nas_link" value="{{$data->cust_data->nas_link }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="AddNew-Phone">計劃書下載連結</label><span
                                            class="text-danger">*</span>
                                        <input type="text" class="form-control" name="download_link" value="{{$data->cust_data->download_link }}" required>
                                    </div>
                                </div>




                                {{-- <div class="col-md-6">
                                    <label class="form-label">計劃案申報類別</label><span class="text-danger">*</span>
                                    <div class="row font-size-16 mt-2">
                                        <div class="col-md-3">
                                            <div class="form-check mb-3">
                                                <input class="form-check-input type" type="checkbox" name="types[]"
                                                    id="formCheck1" value="0">
                                                <label class="form-check-label" for="formCheck1">
                                                    商業服務業
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check mb-3">
                                                <input class="form-check-input type" type="checkbox" name="types[]"
                                                    id="formCheck2" value="1">
                                                <label class="form-check-label" for="formCheck2">
                                                    製造業
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">地址<span class="text-danger">*</span></label>
                                        <div class="twzipcode">
                                            <div class="col-3 d-inline-block">
                                                <select data-role="county" name="county" data-value="{{$data->cust_data->county}}"
                                                    class="form-select col-4 form-floating"></select>
                                            </div>
                                            <div class="col-3 d-inline-block">
                                                <select data-role="district" name="district" data-value="{{$data->cust_data->district}}"
                                                    class="form-select col-4"></select>
                                            </div>
                                            <input type="hidden" data-role="zipcode" name="zipcode" />
                                            <div class="col-4 d-inline-block">
                                                <input type="text" class="form-control" name="address"
                                                    placeholder="輸入地址" value="{{$data->cust_data->address}}">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">專案狀態</label>
                                        <select class="form-select" name="contract_status">
                                            <option value="0" @if($data->cust_data->contract_status == '0') selected @endif>尚未設定</option>
                                            @foreach ($contract_status as $status)
                                                <option value="{{ $status->id }}" @if($data->cust_data->contract_status == $status->id) selected @endif>{{ $status->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @if (Auth::user()->level != 2)
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">限制瀏覽</label>
                                            <select class="form-select" name="limit_status">
                                                @foreach ($groups as $group)
                                                    <option value="{{ $group->id }}" @if($data->cust_data->limit_status == $group->id) selected @endif>{{ $group->name }}</option>
                                                @endforeach
                                                <option value="all">不限</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">帳號權限</label>
                                            <select class="form-select" name="status">
                                                    <option value="0" @if($data->status == 0) selected @endif>開通</option>
                                                    <option value="1" @if($data->status == 1) selected @endif>封鎖</option>
                                            </select>
                                        </div>
                                    </div>
                                @endif
                            </div>

                    </div>
                </div>
                <!-- end row -->
                <div class="row mb-3">
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-success waves-effect waves-light m-1"><i
                                class="fe-check-circle me-1"></i>儲存</button>
                        <button type="reset" class="btn btn-secondary waves-effect waves-light m-1"
                            onclick="history.go(-1)"><i class="fe-x me-1"></i>回上一頁</button>
                    </div>
                </div>
                </form>
            </div> <!-- end card-body -->
        </div> <!-- end card-->
    </div> <!-- end col-->
    <!-- end row -->

    </div> <!-- container -->
@endsection
@section('script')
    <script src="https://code.essoduke.org/js/twzipcode/twzipcode.latest.js"></script>

    <script>
        // TWzipcode.js
        let twzipcode = new TWzipcode({
            district: {
                onChange: function(id) {
                    console.log(this.nth(id).get());
                }
            }
        });
        console.log(twzipcode.get());
    </script>
@endsection
