@extends('layouts.vertical', ['title' => 'Task Details'])

@section('css')
    @vite('node_modules/dropify/dist/css/dropify.min.css')
@endsection

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title' , ['title' => 'Task Detail','subtitle' => 'Apps'])

        <div class="row">
            <div class="col-xl-8 col-lg-7">
                <!-- project card -->
                <div class="card d-block">
                    <div class="card-body">
                        <div class="dropdown float-end">
                            <a href="#" class="dropdown-toggle arrow-none text-muted" data-bs-toggle="dropdown"
                               aria-expanded="false">
                                <i class="mdi mdi-dots-horizontal font-18"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item"> <i
                                        class="mdi mdi-attachment me-1"></i>Attachment </a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item"> <i
                                        class="mdi mdi-pencil-outline me-1"></i>Edit </a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item"> <i
                                        class="mdi mdi-content-copy me-1"></i>Mark as Duplicate </a>
                                <div class="dropdown-divider"></div>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item text-danger"> <i
                                        class="mdi mdi-delete-outline me-1"></i>Delete </a>
                            </div>
                            <!-- end dropdown menu-->
                        </div>
                        <!-- end dropdown-->

                        <div class="form-check float-start">
                            <input type="checkbox" class="form-check-input" id="completedCheck"/>
                            <label class="form-check-label" for="completedCheck">
                                Mark as completed
                            </label>
                        </div>
                        <!-- end form-check-->
                        <div class="clearfix"></div>

                        <h4>Simple Admin Dashboard Template Design</h4>

                        <div class="row">
                            <div class="col-md-4">
                                <!-- assignee -->
                                <p class="mt-2 mb-1 text-muted">Assigned To</p>
                                <div class="d-flex align-items-start">
                                    <img src="/images/users/user-9.jpg" alt="Arya S" class="rounded-circle me-2"
                                         height="24"/>
                                    <div class="w-100">
                                        <h5 class="mt-1 font-size-14">
                                            Jonathan Andrews
                                        </h5>
                                    </div>
                                </div>
                                <!-- end assignee -->
                            </div>
                            <!-- end col -->

                            <div class="col-md-4">
                                <!-- start due date -->
                                <p class="mt-2 mb-1 text-muted">Project Name</p>
                                <div class="d-flex align-items-start">
                                    <i class="mdi mdi-briefcase-check-outline font-18 text-success me-1"></i>
                                    <div class="w-100">
                                        <h5 class="mt-1 font-size-14">
                                            Examron Envirenment
                                        </h5>
                                    </div>
                                </div>
                                <!-- end due date -->
                            </div>

                            <div class="col-md-4">
                                <!-- start due date -->
                                <p class="mt-2 mb-1 text-muted">Due Date</p>
                                <div class="d-flex align-items-start">
                                    <i class="mdi mdi-calendar-month-outline font-18 text-success me-1"></i>
                                    <div class="w-100">
                                        <h5 class="mt-1 font-size-14">
                                            Today 10am
                                        </h5>
                                    </div>
                                </div>
                                <!-- end due date -->
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->

                        <h5 class="mt-3">Overview:</h5>

                        <p class="text-muted mb-4">
                            This is a wider card with supporting text below as a natural lead-in to additional content.
                            This content is a little bit longer. Some quick example text to build on the card title and
                            make up the bulk of the card's
                            content. Some quick example text to build on the card title and make up.
                        </p>

                        <!-- start sub tasks/checklists -->
                        <h5 class="mt-4 mb-2">Checklists/Sub-tasks</h5>
                        <div class="form-check mt-1">
                            <input type="checkbox" class="form-check-input" id="checklist1"/>
                            <label class="form-check-label strikethrough" for="checklist1">
                                Find out the old contract documents
                            </label>
                        </div>

                        <div class="form-check mt-1">
                            <input type="checkbox" class="form-check-input" id="checklist2"/>
                            <label class="form-check-label strikethrough" for="checklist2">
                                Organize meeting sales associates to understand need in detail
                            </label>
                        </div>

                        <div class="form-check mt-1">
                            <input type="checkbox" class="form-check-input" id="checklist3"/>
                            <label class="form-check-label strikethrough" for="checklist3">
                                Make sure to cover every small details
                            </label>
                        </div>
                        <!-- end sub tasks/checklists -->
                    </div>
                    <!-- end card-body-->
                </div>
                <!-- end card-->

                <div class="card">
                    <div class="card-body">
                        <div class="float-end">
                            <select class="form-select form-select-sm">
                                <option selected="">Recent</option>
                                <option value="1">Most Helpful</option>
                                <option value="2">High to Low</option>
                                <option value="3">Low to High</option>
                            </select>
                        </div>
                        <!-- end dropdown-->

                        <h4 class="mb-4 mt-0 font-16">Comments (51)</h4>

                        <div class="clerfix"></div>

                        <div class="d-flex align-items-start">
                            <img class="me-2 rounded-circle" src="/images/users/user-3.jpg"
                                 alt="Generic placeholder image" height="32"/>
                            <div class="w-100">
                                <h5 class="mt-0">Jeremy Tomlinson <small class="text-muted float-end">5 hours
                                        ago</small></h5>
                                Nice work, makes me think of The Money Pit.

                                <br/>
                                <a href="javascript: void(0);" class="text-muted font-13 d-inline-block mt-2"><i
                                        class="mdi mdi-reply"></i> Reply</a>

                                <div class="d-flex align-items-start mt-3">
                                    <a class="pe-2" href="#">
                                        <img src="/images/users/user-4.jpg" class="rounded-circle"
                                             alt="Generic placeholder image" height="32"/>
                                    </a>
                                    <div class="w-100">
                                        <h5 class="mt-0">Thelma Fridley <small class="text-muted float-end">3 hours
                                                ago</small></h5>
                                        i'm in the middle of a timelapse animation myself! (Very different though.)
                                        Awesome stuff.

                                        <br/>
                                        <a href="javascript: void(0);" class="text-muted font-13 d-inline-block mt-2">
                                            <i class="mdi mdi-reply"></i> Reply </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-start mt-3">
                            <img class="me-2 rounded-circle" src="/images/users/user-5.jpg"
                                 alt="Generic placeholder image" height="32"/>
                            <div class="w-100">
                                <h5 class="mt-0">Kevin Martinez <small class="text-muted float-end">1 day ago</small>
                                </h5>
                                It would be very nice to have.

                                <br/>
                                <a href="javascript: void(0);" class="text-muted font-13 d-inline-block mt-2"><i
                                        class="mdi mdi-reply"></i> Reply</a>
                            </div>
                        </div>

                        <div class="text-center mt-2">
                            <a href="javascript:void(0);" class="text-danger"><i
                                    class="mdi mdi-spin mdi-loading me-1"></i> Load more </a>
                        </div>

                        <div class="border rounded mt-4">
                            <form action="#" class="comment-area-box">
                                <textarea rows="3" class="form-control border-0 resize-none"
                                          placeholder="Your comment..."></textarea>
                                <div class="p-2 bg-light d-flex justify-content-between align-items-center">
                                    <div>
                                        <a href="#" class="btn btn-sm px-1 btn-light"><i class="mdi mdi-upload"></i></a>
                                        <a href="#" class="btn btn-sm px-1 btn-light"><i class="mdi mdi-at"></i></a>
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-success"><i
                                            class="uil uil-message me-1"></i>Submit
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!-- end .border-->
                    </div>
                    <!-- end card-body-->
                </div>
                <!-- end card-->
            </div>
            <!-- end col -->

            <div class="col-xl-4 col-lg-5">
                <div class="card">
                    <div class="card-body">
                        <div class="dropdown float-end">
                            <a href="#" class="dropdown-toggle arrow-none text-muted" data-bs-toggle="dropdown"
                               aria-expanded="false">
                                <i class="mdi mdi-dots-horizontal font-18"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item"> <i
                                        class="mdi mdi-attachment me-1"></i>Attachment </a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item"> <i
                                        class="mdi mdi-pencil-outline me-1"></i>Edit </a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item"> <i
                                        class="mdi mdi-content-copy me-1"></i>Mark as Duplicate </a>
                                <div class="dropdown-divider"></div>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item text-danger"> <i
                                        class="mdi mdi-delete-outline me-1"></i>Delete </a>
                            </div>
                            <!-- end dropdown menu-->
                        </div>
                        <!-- end dropdown-->

                        <h5 class="card-title font-16 mb-3">Attachments</h5>

                        <form action="/" method="post" class="dropzone" id="myAwesomeDropzone" data-plugin="dropzone"
                              data-previews-container="#file-previews"
                              data-upload-preview-template="#uploadPreviewTemplate">
                            <div class="fallback">
                                <input name="file" type="file"/>
                            </div>

                            <div class="dz-message needsclick">
                                <i class="h3 text-muted dripicons-cloud-upload"></i>
                                <h4>Drop files here or click to upload.</h4>
                            </div>
                        </form>

                        <!-- Preview -->
                        <div class="dropzone-previews mt-3" id="file-previews"></div>

                        <!-- file preview template -->
                        <div class="d-none" id="uploadPreviewTemplate">
                            <div class="card mt-1 mb-0 shadow-none border">
                                <div class="p-2">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <img data-dz-thumbnail src="#" class="avatar-sm rounded bg-light" alt=""/>
                                        </div>
                                        <div class="col ps-0">
                                            <a href="javascript:void(0);" class="text-muted fw-bold" data-dz-name></a>
                                            <p class="mb-0" data-dz-size></p>
                                        </div>
                                        <div class="col-auto">
                                            <!-- Button -->
                                            <a href="" class="btn btn-link btn-lg text-muted" data-dz-remove>
                                                <i class="dripicons-cross"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end file preview template -->

                        <div class="card mb-1 shadow-none border">
                            <div class="p-2">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="avatar-sm">
                                            <span class="avatar-title badge-soft-primary text-primary rounded">
                                                ZIP
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col ps-0">
                                        <a href="javascript:void(0);"
                                           class="text-muted fw-bold">Ubold-sketch-design.zip</a>
                                        <p class="mb-0 font-12">2.3 MB</p>
                                    </div>
                                    <div class="col-auto">
                                        <!-- Button -->
                                        <a href="javascript:void(0);" class="btn btn-link font-16 text-muted">
                                            <i class="dripicons-download"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-1 shadow-none border">
                            <div class="p-2">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="avatar-sm">
                                            <span class="avatar-title badge-soft-primary text-primary rounded">
                                                JPG
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col ps-0">
                                        <a href="javascript:void(0);"
                                           class="text-muted fw-bold">Dashboard-design.jpg</a>
                                        <p class="mb-0 font-12">3.25 MB</p>
                                    </div>
                                    <div class="col-auto">
                                        <!-- Button -->
                                        <a href="javascript:void(0);" class="btn btn-link font-16 text-muted">
                                            <i class="dripicons-download"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-0 shadow-none border">
                            <div class="p-2">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <div class="avatar-sm">
                                            <span class="avatar-title bg-secondary rounded">
                                                .MP4
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col ps-0">
                                        <a href="javascript:void(0);"
                                           class="text-muted fw-bold">Admin-bug-report.mp4</a>
                                        <p class="mb-0 font-12">7.05 MB</p>
                                    </div>
                                    <div class="col-auto">
                                        <!-- Button -->
                                        <a href="javascript:void(0);" class="btn btn-link font-16 text-muted">
                                            <i class="dripicons-download"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

    </div> <!-- container -->
@endsection

@section('script')
    @vite(['resources/js/pages/form-fileuploads.init.js'])
@endsection
