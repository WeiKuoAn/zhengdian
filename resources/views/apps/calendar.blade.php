@extends('layouts.vertical', ['title' => '行事曆'])

@section('css')
    @vite(['node_modules/fullcalendar/main.min.css'])
@endsection

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title' , ['title' => '行事曆','subtitle' => '排程管理'])

        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div id="calendar"></div>
                            </div> <!-- end col -->

                        </div> <!-- end row -->
                    </div> <!-- end card body-->
                </div> <!-- end card -->

                <!-- Add New Event MODAL -->
                <div class="modal fade" id="event-modal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header py-3 px-4 border-bottom-0 d-block">
                                <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
                                <h5 class="modal-title" id="modal-title">行事曆事件</h5>
                            </div>
                            <div class="modal-body px-4 pb-4 pt-0">
                                <form class="needs-validation" name="event-form" id="form-event" novalidate>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="form-label">行事曆名稱</label>
                                                <input class="form-control" placeholder="請輸入事件名稱" type="text" name="title" id="event-title" required />
                                                <div class="invalid-feedback">請輸入行事曆名稱</div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="form-label">行事曆類別</label>
                                                <select class="form-select" name="category" id="event-category" required>
                                                    <option value="bg-danger" selected>紅色</option>
                                                    <option value="bg-success">綠色</option>
                                                    <option value="bg-primary">藍色</option>
                                                    <option value="bg-info">青色</option>
                                                    <option value="bg-dark">深色</option>
                                                    <option value="bg-warning">黃色</option>
                                                </select>
                                                <div class="invalid-feedback">請選擇事件類別</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-6 col-4">
                                            <button type="button" class="btn btn-danger" id="btn-delete-event">刪除</button>
                                        </div>
                                        <div class="col-md-6 col-8 text-end">
                                            <button type="button" class="btn btn-light me-1" data-bs-dismiss="modal">關閉</button>
                                            <button type="submit" class="btn btn-success" id="btn-save-event">儲存</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div> <!-- end modal-content-->
                    </div> <!-- end modal dialog-->
                </div>
                <!-- end modal-->
            </div>
            <!-- end col-12 -->
        </div> <!-- end row -->

    </div> <!-- container -->
@endsection

@section('script')
    @vite(['resources/js/pages/calendar.init.js'])
@endsection
