@extends('layouts.vertical', ['title' => 'Calendar'])

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['node_modules/fullcalendar/main.min.css'])
@endsection

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title', ['title' => 'Calendar', 'subtitle' => 'Apps'])

        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <button class="btn btn-lg font-16 btn-primary w-100" id="btn-new-event"><i
                                        class="mdi mdi-plus-circle-outline"></i> Create New Event</button>

                                <div id="external-events">
                                    <br>
                                    <p class="text-muted">Drag and drop your event or click in the calendar</p>
                                    <div class="external-event bg-success" data-class="bg-success">
                                        <i class="mdi mdi-checkbox-blank-circle me-2 vertical-middle"></i>New Theme Release
                                    </div>
                                    <div class="external-event bg-info" data-class="bg-info">
                                        <i class="mdi mdi-checkbox-blank-circle me-2 vertical-middle"></i>My Event
                                    </div>
                                    <div class="external-event bg-warning" data-class="bg-warning">
                                        <i class="mdi mdi-checkbox-blank-circle me-2 vertical-middle"></i>Meet manager
                                    </div>
                                    <div class="external-event bg-danger" data-class="bg-danger">
                                        <i class="mdi mdi-checkbox-blank-circle me-2 vertical-middle"></i>Create New theme
                                    </div>
                                </div>


                                <div class="mt-5 d-none d-xl-block">
                                    <h5 class="text-center">How It Works ?</h5>

                                    <ul class="ps-3">
                                        <li class="text-muted mb-3">
                                            It has survived not only five centuries, but also the leap into electronic
                                            typesetting, remaining essentially unchanged.
                                        </li>
                                        <li class="text-muted mb-3">
                                            Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia,
                                            looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum
                                            passage.
                                        </li>
                                        <li class="text-muted mb-3">
                                            It has survived not only five centuries, but also the leap into electronic
                                            typesetting, remaining essentially unchanged.
                                        </li>
                                    </ul>
                                </div>

                            </div> <!-- end col-->

                            <div class="col-lg-9">
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
                                <button type="button" class="btn-close float-end" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                                <h5 class="modal-title" id="modal-title">Event</h5>
                            </div>
                            <div class="modal-body px-4 pb-4 pt-0">
                                <form class="needs-validation" name="event-form" id="form-event" novalidate>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="form-label">行事曆名稱</label>
                                                <input class="form-control" placeholder="Insert Event Name" type="text"
                                                    name="title" id="event-title" required />
                                                <div class="invalid-feedback">請輸入行事曆名稱</div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="form-label">行事曆類別</label>
                                                <select class="form-select" name="category_id" id="event-category" required>
                                                    @foreach ($calendar_categorys as $category)
                                                        <option value="{{ $category->classname }}">{{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">Please select a valid event category</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-6 col-4">
                                            <button type="button" class="btn btn-danger"
                                                id="btn-delete-event">Delete</button>
                                        </div>
                                        <div class="col-md-6 col-8 text-end">
                                            <button type="button" class="btn btn-light me-1"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-success" id="btn-save-event">Save</button>
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
