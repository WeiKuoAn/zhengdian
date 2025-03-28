@extends('layouts.vertical', ['title' => 'Ribbons'])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title' , ['title' => 'Ribbons','subtitle' => 'UI'])

        <div class="row">
            <div class="col-lg-4">
                <div class="card ribbon-box">
                    <div class="card-body">
                        <div class="ribbon ribbon-blue float-start"><i class="mdi mdi-access-point me-1"></i> Blue</div>
                        <h5 class="text-blue float-end mt-0">Blue Header</h5>
                        <div class="ribbon-content">
                            <p class="mb-0">Quisque nec turpis at urna dictum luctus. Suspendisse convallis dignissim eros at volutpat. In egestas
                                mattis dui. Aliquam mattis dictum aliquet. Nulla sapien mauris, eleifend et sem ac, commodo dapibus odio.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card ribbon-box">
                    <div class="card-body">
                        <div class="ribbon ribbon-primary float-end"><i class="mdi mdi-access-point me-1"></i> Primary</div>
                        <h5 class="text-primary float-start mt-0">Primary Header</h5>
                        <div class="ribbon-content">
                            <p class="mb-0">Quisque nec turpis at urna dictum luctus. Suspendisse convallis dignissim eros at volutpat. In egestas
                                mattis dui. Aliquam mattis dictum aliquet. Nulla sapien mauris, eleifend et sem ac, commodo dapibus odio.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card ribbon-box">
                    <div class="card-body">
                        <div class="ribbon ribbon-success float-end"><i class="mdi mdi-access-point me-1"></i> Success</div>
                        <h5 class="text-success float-start mt-0">Success Header</h5>
                        <div class="ribbon-content">
                            <p class="mb-0">Quisque nec turpis at urna dictum luctus. Suspendisse convallis dignissim eros at volutpat. In egestas
                                mattis dui. Aliquam mattis dictum aliquet. Nulla sapien mauris, eleifend et sem ac, commodo dapibus odio.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->


        <div class="row">
            <div class="col-lg-4">
                <div class="card ribbon-box">
                    <div class="card-body">
                        <div class="ribbon ribbon-info float-start"><i class="mdi mdi-access-point me-1"></i> Info</div>
                        <h5 class="text-info float-end mt-0">Info Header</h5>
                        <div class="ribbon-content">
                            <p class="mb-0">Quisque nec turpis at urna dictum luctus. Suspendisse convallis dignissim eros at volutpat. In egestas
                                mattis dui. Aliquam mattis dictum aliquet. Nulla sapien mauris, eleifend et sem ac, commodo dapibus odio.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card ribbon-box">
                    <div class="card-body">
                        <div class="ribbon ribbon-warning float-end"><i class="mdi mdi-access-point me-1"></i> Warning</div>
                        <h5 class="text-warning float-start mt-0">Warning Header</h5>
                        <div class="ribbon-content">
                            <p class="mb-0">Quisque nec turpis at urna dictum luctus. Suspendisse convallis dignissim eros at volutpat. In egestas
                                mattis dui. Aliquam mattis dictum aliquet. Nulla sapien mauris, eleifend et sem ac, commodo dapibus odio.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card ribbon-box">
                    <div class="card-body">
                        <div class="ribbon ribbon-danger float-end"><i class="mdi mdi-access-point me-1"></i> Danger</div>
                        <h5 class="text-danger float-start mt-0">Danger Header</h5>
                        <div class="ribbon-content">
                            <p class="mb-0">Quisque nec turpis at urna dictum luctus. Suspendisse convallis dignissim eros at volutpat. In egestas
                                mattis dui. Aliquam mattis dictum aliquet. Nulla sapien mauris, eleifend et sem ac, commodo dapibus odio.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-4">
                <div class="card ribbon-box">
                    <div class="card-body">
                        <div class="ribbon ribbon-pink float-start"><i class="mdi mdi-access-point me-1"></i> Pink</div>
                        <h5 class="text-pink float-end mt-0">Pink Header</h5>
                        <div class="ribbon-content">
                            <p class="mb-0">Quisque nec turpis at urna dictum luctus. Suspendisse convallis dignissim eros at volutpat. In egestas
                                mattis dui. Aliquam mattis dictum aliquet. Nulla sapien mauris, eleifend et sem ac, commodo dapibus odio.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card ribbon-box">
                    <div class="card-body">
                        <div class="ribbon ribbon-secondary float-end"><i class="mdi mdi-access-point me-1"></i> Secondary</div>
                        <h5 class="text-secondary float-start mt-0">Secondary Header</h5>
                        <div class="ribbon-content">
                            <p class="mb-0">Quisque nec turpis at urna dictum luctus. Suspendisse convallis dignissim eros at volutpat. In egestas
                                mattis dui. Aliquam mattis dictum aliquet. Nulla sapien mauris, eleifend et sem ac, commodo dapibus odio.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card ribbon-box">
                    <div class="card-body">
                        <div class="ribbon ribbon-dark text-light float-end"><i class="mdi mdi-access-point me-1"></i> Dark</div>
                        <h5 class="text-dark float-start mt-0">Dark Header</h5>
                        <div class="ribbon-content">
                            <p class="mb-0">Quisque nec turpis at urna dictum luctus. Suspendisse convallis dignissim eros at volutpat. In egestas
                                mattis dui. Aliquam mattis dictum aliquet. Nulla sapien mauris, eleifend et sem ac, commodo dapibus odio.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->


        <div class="row">
            <div class="col-lg-4">
                <div class="card ribbon-box">
                    <div class="card-body">
                        <div class="ribbon-two ribbon-two-secondary"><span>Secondary</span></div>
                        <p class="mb-0">Quisque nec turpis at urna dictum luctus. Suspendisse convallis dignissim eros at volutpat. In egestas mattis dui. Aliquam mattis dictum aliquet. Nulla sapien mauris, eleifend et sem ac, commodo dapibus odio. Vivamus pretium nec odio cursus elementum. Suspendisse molestie ullamcorper ornare.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card ribbon-box">
                    <div class="card-body">
                        <div class="ribbon-two ribbon-two-primary"><span>Primary</span></div>
                        <p class="mb-0">Quisque nec turpis at urna dictum luctus. Suspendisse convallis dignissim eros at volutpat. In egestas mattis dui. Aliquam mattis dictum aliquet. Nulla sapien mauris, eleifend et sem ac, commodo dapibus odio. Vivamus pretium nec odio cursus elementum. Suspendisse molestie ullamcorper ornare.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card ribbon-box">
                    <div class="card-body">
                        <div class="ribbon-two ribbon-two-success"><span>Success</span></div>
                        <p class="mb-0">Quisque nec turpis at urna dictum luctus. Suspendisse convallis dignissim eros at volutpat. In egestas mattis dui. Aliquam mattis dictum aliquet. Nulla sapien mauris, eleifend et sem ac, commodo dapibus odio. Vivamus pretium nec odio cursus elementum. Suspendisse molestie ullamcorper ornare.</p>
                    </div>
                </div>
            </div>

        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-4">
                <div class="card ribbon-box">
                    <div class="card-body">
                        <div class="ribbon-two ribbon-two-info"><span>Info</span></div>
                        <p class="mb-0">Quisque nec turpis at urna dictum luctus. Suspendisse convallis dignissim eros at volutpat. In egestas mattis dui. Aliquam mattis dictum aliquet. Nulla sapien mauris, eleifend et sem ac, commodo dapibus odio. Vivamus pretium nec odio cursus elementum. Suspendisse molestie ullamcorper ornare.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card ribbon-box">
                    <div class="card-body">
                        <div class="ribbon-two ribbon-two-warning"><span>Warning</span></div>
                        <p class="mb-0">Quisque nec turpis at urna dictum luctus. Suspendisse convallis dignissim eros at volutpat. In egestas mattis dui. Aliquam mattis dictum aliquet. Nulla sapien mauris, eleifend et sem ac, commodo dapibus odio. Vivamus pretium nec odio cursus elementum. Suspendisse molestie ullamcorper ornare.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card ribbon-box">
                    <div class="card-body">
                        <div class="ribbon-two ribbon-two-danger"><span>Danger</span></div>
                        <p class="mb-0">Quisque nec turpis at urna dictum luctus. Suspendisse convallis dignissim eros at volutpat. In egestas mattis dui. Aliquam mattis dictum aliquet. Nulla sapien mauris, eleifend et sem ac, commodo dapibus odio. Vivamus pretium nec odio cursus elementum. Suspendisse molestie ullamcorper ornare.</p>
                    </div>
                </div>
            </div>

        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-4">
                <div class="card ribbon-box">
                    <div class="card-body">
                        <div class="ribbon-two ribbon-two-pink"><span>Pink</span></div>
                        <p class="mb-0">Quisque nec turpis at urna dictum luctus. Suspendisse convallis dignissim eros at volutpat. In egestas mattis dui. Aliquam mattis dictum aliquet. Nulla sapien mauris, eleifend et sem ac, commodo dapibus odio. Vivamus pretium nec odio cursus elementum. Suspendisse molestie ullamcorper ornare.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card ribbon-box">
                    <div class="card-body">
                        <div class="ribbon-two ribbon-two-blue"><span>Blue</span></div>
                        <p class="mb-0">Quisque nec turpis at urna dictum luctus. Suspendisse convallis dignissim eros at volutpat. In egestas mattis dui. Aliquam mattis dictum aliquet. Nulla sapien mauris, eleifend et sem ac, commodo dapibus odio. Vivamus pretium nec odio cursus elementum. Suspendisse molestie ullamcorper ornare.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card ribbon-box">
                    <div class="card-body">
                        <div class="ribbon-two ribbon-two-dark"><span class="text-light">Dark</span></div>
                        <p class="mb-0">Quisque nec turpis at urna dictum luctus. Suspendisse convallis dignissim eros at volutpat. In egestas mattis dui. Aliquam mattis dictum aliquet. Nulla sapien mauris, eleifend et sem ac, commodo dapibus odio. Vivamus pretium nec odio cursus elementum. Suspendisse molestie ullamcorper ornare.</p>
                    </div>
                </div>
            </div>

        </div>
        <!-- end row -->

    </div> <!-- container -->
@endsection
