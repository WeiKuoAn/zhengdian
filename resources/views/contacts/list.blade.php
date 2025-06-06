@extends('layouts.vertical', ['title' => 'Contacts & Members Listing'])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title' , ['title' => 'Contacts','subtitle' => 'Apps'])

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-between">
                            <div class="col-md-8">
                                <form class="d-flex flex-wrap align-items-center">
                                    <label for="inputPassword2" class="visually-hidden">Search</label>
                                    <div class="me-3">
                                        <input type="search" class="form-control my-1 my-md-0" id="inputPassword2" placeholder="Search...">
                                    </div>
                                    <label for="status-select" class="me-2">Sort By</label>
                                    <div class="me-sm-3">
                                        <select class="form-select my-1 my-md-0" id="status-select">
                                            <option selected="">All</option>
                                            <option value="1">Name</option>
                                            <option value="2">Post</option>
                                            <option value="3">Followers</option>
                                            <option value="4">Followings</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-4">
                                <div class="text-md-end mt-3 mt-md-0">
                                    <button type="button" class="btn btn-success waves-effect waves-light me-1"><i class="mdi mdi-cog"></i></button>
                                    <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#custom-modal"><i class="mdi mdi-plus-circle me-1"></i> Add New</button>
                                </div>
                            </div><!-- end col-->
                        </div> <!-- end row -->
                    </div>
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-4">
                <div class="text-center card">
                    <div class="card-body">
                        <div class="pt-2 pb-2">
                            <img src="/images/users/user-3.jpg" class="rounded-circle img-thumbnail avatar-xl" alt="profile-image">

                            <h4 class="mt-3"><a href="#" class="text-dark">Freddie J. Plourde</a></h4>
                            <p class="text-muted">@Founder <span> | </span> <span> <a href="#" class="text-pink">websitename.com</a> </span></p>

                            <button type="button" class="btn btn-primary btn-sm waves-effect waves-light">Message</button>
                            <button type="button" class="btn btn-light btn-sm waves-effect">Follow</button>

                            <div class="row mt-4">
                                <div class="col-4">
                                    <div class="mt-3">
                                        <h4>$2563</h4>
                                        <p class="mb-0 text-muted text-truncate">Post</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mt-3">
                                        <h4>$29.8k</h4>
                                        <p class="mb-0 text-muted text-truncate">Followers</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mt-3">
                                        <h4>1125</h4>
                                        <p class="mb-0 text-muted text-truncate">Followings</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->

                        </div> <!-- end .padding -->
                    </div>
                </div> <!-- end card-->
            </div> <!-- end col -->

            <div class="col-lg-4">
                <div class="text-center card">
                    <div class="card-body">
                        <div class="pt-2 pb-2">
                            <img src="/images/users/user-4.jpg" class="rounded-circle img-thumbnail avatar-xl" alt="profile-image">

                            <h4 class="mt-3"><a href="#" class="text-dark">Christopher Gallardo</a></h4>
                            <p class="text-muted">@Webdesigner <span> | </span> <span> <a href="#" class="text-pink">abcweb.com</a> </span></p>

                            <button type="button" class="btn btn-primary btn-sm waves-effect waves-light">Message</button>
                            <button type="button" class="btn btn-light btn-sm waves-effect">Follow</button>

                            <div class="row mt-4">
                                <div class="col-4">
                                    <div class="mt-3">
                                        <h4>$12.7k</h4>
                                        <p class="mb-0 text-muted text-truncate">Post</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mt-3">
                                        <h4>$65.3k</h4>
                                        <p class="mb-0 text-muted text-truncate">Followers</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mt-3">
                                        <h4>2184</h4>
                                        <p class="mb-0 text-muted text-truncate">Followings</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->

                        </div> <!-- end .padding -->
                    </div>
                </div> <!-- end card-->
            </div> <!-- end col -->

            <div class="col-lg-4">
                <div class="text-center card">
                    <div class="card-body">
                        <div class="pt-2 pb-2">
                            <img src="/images/users/user-5.jpg" class="rounded-circle img-thumbnail avatar-xl" alt="profile-image">

                            <h4 class="mt-3"><a href="#" class="text-dark">Joseph M. Rohr</a></h4>
                            <p class="text-muted">@Webdesigner <span> | </span> <span> <a href="#" class="text-pink">mywebs.com</a> </span></p>

                            <button type="button" class="btn btn-primary btn-sm waves-effect waves-light">Message</button>
                            <button type="button" class="btn btn-light btn-sm waves-effect">Follow</button>

                            <div class="row mt-4">
                                <div class="col-4">
                                    <div class="mt-3">
                                        <h4>$1021</h4>
                                        <p class="mb-0 text-muted text-truncate">Post</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mt-3">
                                        <h4>$25.6k</h4>
                                        <p class="mb-0 text-muted text-truncate">Followers</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mt-3">
                                        <h4>325</h4>
                                        <p class="mb-0 text-muted text-truncate">Followings</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->

                        </div> <!-- end .padding -->
                    </div>
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-4">
                <div class="text-center card">
                    <div class="card-body">
                        <div class="pt-2 pb-2">
                            <img src="/images/users/user-6.jpg" class="rounded-circle img-thumbnail avatar-xl" alt="profile-image">

                            <h4 class="mt-3"><a href="#" class="text-dark">Mark K. Horne</a></h4>
                            <p class="text-muted">@Director <span> | </span> <span> <a href="#" class="text-pink">profileq.com</a> </span></p>

                            <button type="button" class="btn btn-primary btn-sm waves-effect waves-light">Message</button>
                            <button type="button" class="btn btn-light btn-sm waves-effect">Follow</button>

                            <div class="row mt-4">
                                <div class="col-4">
                                    <div class="mt-3">
                                        <h4>$7845</h4>
                                        <p class="mb-0 text-muted text-truncate">Post</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mt-3">
                                        <h4>$16.7k</h4>
                                        <p class="mb-0 text-muted text-truncate">Followers</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mt-3">
                                        <h4>5846</h4>
                                        <p class="mb-0 text-muted text-truncate">Followings</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->

                        </div> <!-- end .padding -->
                    </div>
                </div> <!-- end card-->
            </div> <!-- end col -->

            <div class="col-lg-4">
                <div class="text-center card">
                    <div class="card-body">
                        <div class="pt-2 pb-2">
                            <img src="/images/users/user-7.jpg" class="rounded-circle img-thumbnail avatar-xl" alt="profile-image">

                            <h4 class="mt-3"><a href="#" class="text-dark">James M. Fonville</a></h4>
                            <p class="text-muted">@Manager <span> | </span> <span> <a href="#" class="text-pink">coolweb.com</a> </span></p>

                            <button type="button" class="btn btn-primary btn-sm waves-effect waves-light">Message</button>
                            <button type="button" class="btn btn-light btn-sm waves-effect">Follow</button>

                            <div class="row mt-4">
                                <div class="col-4">
                                    <div class="mt-3">
                                        <h4>$4851</h4>
                                        <p class="mb-0 text-muted text-truncate">Post</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mt-3">
                                        <h4>$10.2k</h4>
                                        <p class="mb-0 text-muted text-truncate">Followers</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mt-3">
                                        <h4>895</h4>
                                        <p class="mb-0 text-muted text-truncate">Followings</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->

                        </div> <!-- end .padding -->
                    </div>
                </div> <!-- end card-->
            </div> <!-- end col -->

            <div class="col-lg-4">
                <div class="text-center card">
                    <div class="card-body">
                        <div class="pt-2 pb-2">
                            <img src="/images/users/user-8.jpg" class="rounded-circle img-thumbnail avatar-xl" alt="profile-image">

                            <h4 class="mt-3"><a href="#" class="text-dark">Jade M. Walker</a></h4>
                            <p class="text-muted">@Programmer <span> | </span> <span> <a href="#" class="text-pink">supported.com</a> </span></p>

                            <button type="button" class="btn btn-primary btn-sm waves-effect waves-light">Message</button>
                            <button type="button" class="btn btn-light btn-sm waves-effect">Follow</button>

                            <div class="row mt-4">
                                <div class="col-4">
                                    <div class="mt-3">
                                        <h4>$4560</h4>
                                        <p class="mb-0 text-muted text-truncate">Post</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mt-3">
                                        <h4>$15.3k</h4>
                                        <p class="mb-0 text-muted text-truncate">Followers</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mt-3">
                                        <h4>742</h4>
                                        <p class="mb-0 text-muted text-truncate">Followings</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->

                        </div> <!-- end .padding -->
                    </div>
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->


        <div class="row">
            <div class="col-lg-4">
                <div class="text-center card">
                    <div class="card-body">
                        <div class="pt-2 pb-2">
                            <img src="/images/users/user-2.jpg" class="rounded-circle img-thumbnail avatar-xl" alt="profile-image">

                            <h4 class="mt-3"><a href="#" class="text-dark">Marie E. Tate</a></h4>
                            <p class="text-muted">@Webdeveloper <span> | </span> <span> <a href="#" class="text-pink">website.com</a> </span></p>

                            <button type="button" class="btn btn-primary btn-sm waves-effect waves-light">Message</button>
                            <button type="button" class="btn btn-light btn-sm waves-effect">Follow</button>

                            <div class="row mt-4">
                                <div class="col-4">
                                    <div class="mt-3">
                                        <h4>$3520</h4>
                                        <p class="mb-0 text-muted text-truncate">Post</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mt-3">
                                        <h4>$4587</h4>
                                        <p class="mb-0 text-muted text-truncate">Followers</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mt-3">
                                        <h4>423</h4>
                                        <p class="mb-0 text-muted text-truncate">Followings</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->

                        </div> <!-- end .padding -->
                    </div>
                </div> <!-- end card-->
            </div> <!-- end col -->

            <div class="col-lg-4">
                <div class="text-center card">
                    <div class="card-body">
                        <div class="pt-2 pb-2">
                            <img src="/images/users/user-9.jpg" class="rounded-circle img-thumbnail avatar-xl" alt="profile-image">

                            <h4 class="mt-3"><a href="#" class="text-dark">Elyse D. Davidson</a></h4>
                            <p class="text-muted">@Webdesigner <span> | </span> <span> <a href="#" class="text-pink">dumosite.com</a> </span></p>

                            <button type="button" class="btn btn-primary btn-sm waves-effect waves-light">Message</button>
                            <button type="button" class="btn btn-light btn-sm waves-effect">Follow</button>

                            <div class="row mt-4">
                                <div class="col-4">
                                    <div class="mt-3">
                                        <h4>$7851</h4>
                                        <p class="mb-0 text-muted text-truncate">Post</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mt-3">
                                        <h4>$16.8k</h4>
                                        <p class="mb-0 text-muted text-truncate">Followers</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mt-3">
                                        <h4>1036</h4>
                                        <p class="mb-0 text-muted text-truncate">Followings</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->

                        </div> <!-- end .padding -->
                    </div>
                </div> <!-- end card-->
            </div> <!-- end col -->

            <div class="col-lg-4">
                <div class="text-center card">
                    <div class="card-body">
                        <div class="pt-2 pb-2">
                            <img src="/images/users/user-10.jpg" class="rounded-circle img-thumbnail avatar-xl" alt="profile-image">

                            <h4 class="mt-3"><a href="#" class="text-dark">Sarah E. Goin</a></h4>
                            <p class="text-muted">@Manager <span> | </span> <span> <a href="#" class="text-pink">webion.com</a> </span></p>

                            <button type="button" class="btn btn-primary btn-sm waves-effect waves-light">Message</button>
                            <button type="button" class="btn btn-light btn-sm waves-effect">Follow</button>

                            <div class="row mt-4">
                                <div class="col-4">
                                    <div class="mt-3">
                                        <h4>$7421</h4>
                                        <p class="mb-0 text-muted text-truncate">Post</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mt-3">
                                        <h4>$29.5k</h4>
                                        <p class="mb-0 text-muted text-truncate">Followers</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mt-3">
                                        <h4>11k</h4>
                                        <p class="mb-0 text-muted text-truncate">Followings</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->

                        </div> <!-- end .padding -->
                    </div>
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-12">
                <div class="text-end">
                    <ul class="pagination pagination-rounded justify-content-end">
                        <li class="page-item">
                            <a class="page-link" href="javascript: void(0);" aria-label="Previous">
                                <span aria-hidden="true">«</span>
                                <span class="visually-hidden">Previous</span>
                            </a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="javascript: void(0);">1</a></li>
                        <li class="page-item"><a class="page-link" href="javascript: void(0);">2</a></li>
                        <li class="page-item"><a class="page-link" href="javascript: void(0);">3</a></li>
                        <li class="page-item"><a class="page-link" href="javascript: void(0);">4</a></li>
                        <li class="page-item"><a class="page-link" href="javascript: void(0);">5</a></li>
                        <li class="page-item">
                            <a class="page-link" href="javascript: void(0);" aria-label="Next">
                                <span aria-hidden="true">»</span>
                                <span class="visually-hidden">Next</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- end row -->

    </div> <!-- container -->
    <!-- Modal -->
    <div class="modal fade" id="custom-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Add New Member</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body p-4">
                    <form>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter name">
                        </div>
                        <div class="mb-3">
                            <label for="position" class="form-label">Position</label>
                            <input type="text" class="form-control" id="position" placeholder="Enter position">
                        </div>
                        <div class="mb-3">
                            <label for="company" class="form-label">Company</label>
                            <input type="text" class="form-control" id="company" placeholder="Enter company">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success waves-effect waves-light">Save</button>
                            <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-dismiss="modal">Continue</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
