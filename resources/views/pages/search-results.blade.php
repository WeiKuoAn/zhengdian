@extends('layouts.vertical', ['title' => 'Search Results'])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title' , ['title' => 'Search Results','subtitle' => 'Pages'])


        <div class="row">
            <div class="col-lg-12">
                <div class="search-result-box card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <div class="pt-3 pb-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="Admin Dashboard">
                                        <button type="button" class="input-group-text btn waves-effect waves-light btn-blue"><i class="fa fa-search me-1"></i> Search</button>
                                    </div>
                                    <div class="mt-3 text-center">
                                        <h4>Search Results For "Admin Dashboard"</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                        <ul class="nav nav-tabs nav-bordered">
                            <li class="nav-item">
                                <a href="#home" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
                                    All results <span class="badge bg-success ms-1">325</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#users" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                    Users <span class="badge bg-danger ms-1">89</span>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="home">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="search-item">
                                            <h4 class="mb-1"><a href="#">Zircos - Responsive Admin Template</a></h4>
                                            <div class="font-13 text-success mb-2 text-truncate">
                                                http://coderthemes.com/zircos/index.html
                                            </div>
                                            <p class="mb-0 text-muted">
                                                Dolor posuere proin blandit accumsan senectus netus nullam curae, ornare laoreet adipiscing luctus mauris adipiscing pretium eget fermentum, tristique lobortis est ut metus lobortis tortor tincidunt himenaeos habitant quis dictumst proin odio sagittis purus mi, nec taciti vestibulum quis in sit varius lorem sit metus mi.
                                            </p>
                                        </div> <!-- end search item -->

                                        <div class="search-item">
                                            <h4 class="mb-1"><a href="#">Uplon - Responsive Bootstrap 5 Web App Kit</a></h4>
                                            <div class="font-13 text-success mb-2 text-truncate">
                                                http://themeforest.net/user/coderthemes/portfolio?ref=coderthemes
                                            </div>
                                            <p class="mb-0 text-muted">
                                                Dolor posuere proin blandit accumsan senectus netus nullam curae, ornare laoreet adipiscing luctus mauris adipiscing pretium eget fermentum, tristique lobortis est ut metus lobortis tortor tincidunt himenaeos habitant quis dictumst proin odio sagittis purus mi, nec taciti vestibulum quis in sit varius lorem sit metus mi.
                                            </p>
                                        </div> <!-- end search item -->

                                        <div class="search-item">
                                            <div class="d-flex align-items-start">
                                                <img class="d-flex me-3 rounded-circle" src="/images/users/user-1.jpg" alt="Generic placeholder image" height="54">
                                                <div class="w-100">
                                                    <h5 class="mt-0">
                                                        <a href="#" class="text-dark">Chadengle</a>
                                                    </h5>
                                                    <p class="font-13">
                                                        <b>Email:</b>
                                                        <span><a href="#" class="text-muted">mediaheader@mail.com</a></span>
                                                    </p>
                                                    <p class="mb-0 font-13">
                                                        <b>Bio:</b>
                                                        <br />
                                                        <span class="text-muted">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div> <!-- end search item -->

                                        <div class="search-item">
                                            <h4 class="mb-1"><a href="#">Zircos - Responsive Admin Template</a></h4>
                                            <div class="font-13 text-success mb-2 text-truncate">
                                                http://ubold.coderthemes.com/
                                            </div>
                                            <p class="mb-0 text-muted">
                                                Dolor posuere proin blandit accumsan senectus netus nullam curae, ornare laoreet adipiscing luctus mauris adipiscing pretium eget fermentum, tristique lobortis est ut metus lobortis tortor tincidunt himenaeos habitant quis dictumst proin odio sagittis purus mi, nec taciti vestibulum quis in sit varius lorem sit metus mi.
                                            </p>
                                        </div> <!-- end search item -->

                                        <div class="search-item">
                                            <h4 class="mb-1"><a href="#">Uplon - Responsive Bootstrap 5 Web App Kit</a></h4>
                                            <div class="font-13 text-success mb-2 text-truncate">
                                                http://themeforest.net/user/coderthemes/portfolio?ref=coderthemes
                                            </div>

                                            <div class="">
                                                <img src="/images/small/img-1.jpg" height="48" alt="image" />
                                                <img src="/images/small/img-2.jpg" height="48" alt="image" />
                                                <img src="/images/small/img-3.jpg" height="48" alt="image" />
                                                <img src="/images/small/img-4.jpg" height="48" alt="image" />
                                            </div>
                                        </div> <!-- end search item -->

                                        <div class="search-item">
                                            <h4 class="mb-1"><a href="#">Zircos - Responsive Admin Template</a></h4>
                                            <div class="font-13 text-success mb-2 text-truncate">
                                                http://ubold.coderthemes.com/
                                            </div>
                                            <p class="mb-0 text-muted">
                                                Dolor posuere proin blandit accumsan senectus netus nullam curae, ornare laoreet adipiscing luctus mauris adipiscing pretium eget fermentum, tristique lobortis est ut metus lobortis tortor tincidunt himenaeos habitant quis dictumst proin odio sagittis purus mi, nec taciti vestibulum quis in sit varius lorem sit metus mi.
                                            </p>
                                        </div> <!-- end search item -->

                                        <div class="search-item">
                                            <h4 class="mb-1"><a href="#">Uplon - Responsive Bootstrap 5 Web App Kit</a></h4>
                                            <div class="font-13 text-success mb-2 text-truncate">
                                                http://themeforest.net/user/coderthemes/portfolio?ref=coderthemes
                                            </div>
                                            <p class="mb-0 text-muted">
                                                Dolor posuere proin blandit accumsan senectus netus nullam curae, ornare laoreet adipiscing luctus mauris adipiscing pretium eget fermentum, tristique lobortis est ut metus lobortis tortor tincidunt himenaeos habitant quis dictumst proin odio sagittis purus mi, nec taciti vestibulum quis in sit varius lorem sit metus mi.
                                            </p>
                                            <div class="row mt-2">
                                                <div class="col-sm-4 col-xl-2">
                                                    <div class="ratio ratio-16x9">
                                                        <iframe src="https://www.youtube.com/embed/PrUxWZiQfy4?autohide=0&showinfo=0&controls=0"></iframe>
                                                    </div>
                                                </div> <!-- end col -->
                                            </div>
                                            <!-- end row -->
                                        </div> <!-- end search item -->


                                        <ul class="pagination justify-content-end pagination-rounded mt-0">
                                            <li class="page-item">
                                                <a class="page-link" href="#" aria-label="Previous">
                                                    <span aria-hidden="true">«</span>
                                                    <span class="visually-hidden">Previous</span>
                                                </a>
                                            </li>
                                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item active"><a class="page-link" href="#">2</a></li>
                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                            <li class="page-item"><a class="page-link" href="#">4</a></li>
                                            <li class="page-item"><a class="page-link" href="#">5</a></li>
                                            <li class="page-item">
                                                <a class="page-link" href="#" aria-label="Next">
                                                    <span aria-hidden="true">»</span>
                                                    <span class="visually-hidden">Next</span>
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- end All results tab -->


                            <!-- Users tab -->
                            <div class="tab-pane" id="users">
                                <div class="search-item">
                                    <div class="d-flex align-items-start">
                                        <img class="d-flex me-3 rounded-circle" src="/images/users/user-1.jpg" alt="Generic placeholder image" height="54">
                                        <div class="w-100">
                                            <h5 class="mt-0">
                                                <a href="#" class="text-dark">Halette Boivin</a>
                                            </h5>
                                            <p class="font-13">
                                                <b>Email:</b>
                                                <span><a href="#" class="text-muted">mediaheader@mail.com</a></span>
                                            </p>
                                            <p class="mb-0 font-13">
                                                <b>Bio:</b>
                                                <br />
                                                <span class="text-muted">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>


                                <div class="search-item">
                                    <div class="d-flex align-items-start">
                                        <img class="d-flex me-3 rounded-circle" src="/images/users/user-2.jpg" alt="Generic placeholder image" height="54">
                                        <div class="w-100">
                                            <h5 class="mt-0">
                                                <a href="#" class="text-dark">Durandana Jolicoeur</a>
                                            </h5>
                                            <p class="font-13">
                                                <b>Email:</b>
                                                <span><a href="#" class="text-muted">mediaheader@mail.com</a></span>
                                            </p>
                                            <p class="mb-0 font-13">
                                                <b>Bio:</b>
                                                <br />
                                                <span class="text-muted">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>


                                <div class="search-item">
                                    <div class="d-flex align-items-start">
                                        <img class="d-flex me-3 rounded-circle" src="/images/users/user-3.jpg" alt="Generic placeholder image" height="54">
                                        <div class="w-100">
                                            <h5 class="mt-0">
                                                <a href="#" class="text-dark">Lucas Sabourin</a>
                                            </h5>
                                            <p class="font-13">
                                                <b>Email:</b>
                                                <span><a href="#" class="text-muted">mediaheader@mail.com</a></span>
                                            </p>
                                            <p class="mb-0 font-13">
                                                <b>Bio:</b>
                                                <br />
                                                <span class="text-muted">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>


                                <div class="search-item">
                                    <div class="d-flex align-items-start">
                                        <img class="d-flex me-3 rounded-circle" src="/images/users/user-4.jpg" alt="Generic placeholder image" height="54">
                                        <div class="w-100">
                                            <h5 class="mt-0">
                                                <a href="#" class="text-dark">Donatien Brunelle</a>
                                            </h5>
                                            <p class="font-13">
                                                <b>Email:</b>
                                                <span><a href="#" class="text-muted">mediaheader@mail.com</a></span>
                                            </p>
                                            <p class="mb-0 font-13">
                                                <b>Bio:</b>
                                                <br />
                                                <span class="text-muted">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="search-item">
                                    <div class="d-flex align-items-start">
                                        <img class="d-flex me-3 rounded-circle" src="/images/users/user-5.jpg" alt="Generic placeholder image" height="54">
                                        <div class="w-100">
                                            <h5 class="mt-0">
                                                <a href="#" class="text-dark">Karel Auberjo</a>
                                            </h5>
                                            <p class="font-13">
                                                <b>Email:</b>
                                                <span><a href="#" class="text-muted">mediaheader@mail.com</a></span>
                                            </p>
                                            <p class="mb-0 font-13">
                                                <b>Bio:</b>
                                                <br />
                                                <span class="text-muted">Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <ul class="pagination justify-content-end pagination-rounded mt-0">
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Previous">
                                            <span aria-hidden="true">«</span>
                                            <span class="visually-hidden">Previous</span>
                                        </a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item active"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                                    <li class="page-item"><a class="page-link" href="#">5</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Next">
                                            <span aria-hidden="true">»</span>
                                            <span class="visually-hidden">Next</span>
                                        </a>
                                    </li>
                                </ul>


                                <div class="clearfix"></div>


                            </div>
                            <!-- end Users tab -->

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- container -->
@endsection
