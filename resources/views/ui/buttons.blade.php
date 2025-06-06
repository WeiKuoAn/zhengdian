@extends('layouts.vertical', ['title' => 'Buttons'])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title' , ['title' => 'Buttons','subtitle' => 'UI'])

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-6">
                                <h4 class="header-title">Default Buttons</h4>
                                <p class="sub-header">
                                    Use the button classes on an <code>&lt;a&gt;</code>, <code>&lt;button&gt;</code>, or <code>&lt;input&gt;</code> element.
                                </p>

                                <div class="button-list">
                                    <button type="button" class="btn btn-primary waves-effect waves-light">Primary</button>
                                    <button type="button" class="btn btn-success waves-effect waves-light">Success</button>
                                    <button type="button" class="btn btn-info waves-effect waves-light">Info</button>
                                    <button type="button" class="btn btn-warning waves-effect waves-light">Warning</button>
                                    <button type="button" class="btn btn-danger waves-effect waves-light">Danger</button>
                                    <button type="button" class="btn btn-dark waves-effect waves-light">Dark</button>
                                    <button type="button" class="btn btn-blue waves-effect waves-light">Blue</button>
                                    <button type="button" class="btn btn-pink waves-effect waves-light">Pink</button>
                                    <button type="button" class="btn btn-secondary waves-effect">Secondary</button>
                                    <button type="button" class="btn btn-light waves-effect">Light</button>
                                    <button type="button" class="btn btn-white waves-effect">White</button>
                                    <button type="button" class="btn btn-link waves-effect">Link</button>
                                </div>
                            </div> <!-- end col -->

                            <div class="col-xl-6 mt-xl-0 mt-3">
                                <h4 class="header-title">Rounded Button</h4>
                                <p class="sub-header">
                                    Add <code>.rounded-pill</code> to default button to get rounded corners.
                                </p>

                                <div class="button-list">
                                    <button type="button" class="btn btn-primary rounded-pill waves-effect waves-light">Primary</button>
                                    <button type="button" class="btn btn-success rounded-pill waves-effect waves-light">Success</button>
                                    <button type="button" class="btn btn-info rounded-pill waves-effect waves-light">Info</button>
                                    <button type="button" class="btn btn-warning rounded-pill waves-effect waves-light">Warning</button>
                                    <button type="button" class="btn btn-danger rounded-pill waves-effect waves-light">Danger</button>
                                    <button type="button" class="btn btn-dark rounded-pill waves-effect waves-light">Dark</button>
                                    <button type="button" class="btn btn-blue rounded-pill waves-effect waves-light">Blue</button>
                                    <button type="button" class="btn btn-pink rounded-pill waves-effect waves-light">Pink</button>
                                    <button type="button" class="btn btn-secondary rounded-pill waves-effect">Secondary</button>
                                    <button type="button" class="btn btn-white rounded-pill waves-effect">White</button>
                                    <button type="button" class="btn btn-light rounded-pill waves-effect">Light</button>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                    </div>
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row-->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-6">
                                <h4 class="header-title">Outline Buttons</h4>
                                <p class="sub-header">
                                    Use a classes <code>.btn-outline-**</code> to quickly create a bordered buttons.
                                </p>

                                <div class="button-list">
                                    <button type="button" class="btn btn-outline-primary waves-effect waves-light">Primary</button>
                                    <button type="button" class="btn btn-outline-success waves-effect waves-light">Success</button>
                                    <button type="button" class="btn btn-outline-info waves-effect waves-light">Info</button>
                                    <button type="button" class="btn btn-outline-warning waves-effect waves-light">Warning</button>
                                    <button type="button" class="btn btn-outline-danger waves-effect waves-light">Danger</button>
                                    <button type="button" class="btn btn-outline-dark waves-effect waves-light">Dark</button>
                                    <button type="button" class="btn btn-outline-blue waves-effect waves-light">Blue</button>
                                    <button type="button" class="btn btn-outline-pink waves-effect waves-light">Pink</button>
                                    <button type="button" class="btn btn-outline-secondary waves-effect">Secondary</button>
                                    <button type="button" class="btn btn-outline-light waves-effect">Light</button>
                                </div>
                            </div> <!-- end col -->

                            <div class="col-xl-6 mt-xl-0 mt-3">
                                <h4 class="header-title">Outline Rounded Button</h4>
                                <p class="sub-header">
                                    Add <code>.rounded-pill</code> to default button to get rounded corners.
                                </p>

                                <div class="button-list">
                                    <button type="button" class="btn btn-outline-primary rounded-pill waves-effect waves-light">Primary</button>
                                    <button type="button" class="btn btn-outline-success rounded-pill waves-effect waves-light">Success</button>
                                    <button type="button" class="btn btn-outline-info rounded-pill waves-effect waves-light">Info</button>
                                    <button type="button" class="btn btn-outline-warning rounded-pill waves-effect waves-light">Warning</button>
                                    <button type="button" class="btn btn-outline-danger rounded-pill waves-effect waves-light">Danger</button>
                                    <button type="button" class="btn btn-outline-dark rounded-pill waves-effect waves-light">Dark</button>
                                    <button type="button" class="btn btn-outline-blue rounded-pill waves-effect waves-light">Blue</button>
                                    <button type="button" class="btn btn-outline-pink rounded-pill waves-effect waves-light">Pink</button>
                                    <button type="button" class="btn btn-outline-secondary rounded-pill waves-effect">Secondary</button>
                                    <button type="button" class="btn btn-outline-light rounded-pill waves-effect">Light</button>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                    </div>
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row-->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-6">
                                <h4 class="header-title">Soft Buttons</h4>
                                <p class="sub-header">
                                    Use a classes <code>.btn-soft-**</code> to quickly create buttons with soft background.
                                </p>

                                <div class="button-list">
                                    <button type="button" class="btn btn-soft-primary waves-effect waves-light">Primary</button>
                                    <button type="button" class="btn btn-soft-success waves-effect waves-light">Success</button>
                                    <button type="button" class="btn btn-soft-info waves-effect waves-light">Info</button>
                                    <button type="button" class="btn btn-soft-warning waves-effect waves-light">Warning</button>
                                    <button type="button" class="btn btn-soft-danger waves-effect waves-light">Danger</button>
                                    <button type="button" class="btn btn-soft-dark waves-effect waves-light">Dark</button>
                                    <button type="button" class="btn btn-soft-blue waves-effect waves-light">Blue</button>
                                    <button type="button" class="btn btn-soft-pink waves-effect waves-light">Pink</button>
                                    <button type="button" class="btn btn-soft-secondary waves-effect">Secondary</button>
                                </div>
                            </div> <!-- end col -->

                            <div class="col-xl-6 mt-xl-0 mt-3">
                                <h4 class="header-title">Soft Rounded Button</h4>
                                <p class="sub-header">
                                    Add <code>.rounded-pill</code> to default button to get rounded corners.
                                </p>

                                <div class="button-list">
                                    <button type="button" class="btn btn-soft-primary rounded-pill waves-effect waves-light">Primary</button>
                                    <button type="button" class="btn btn-soft-success rounded-pill waves-effect waves-light">Success</button>
                                    <button type="button" class="btn btn-soft-info rounded-pill waves-effect waves-light">Info</button>
                                    <button type="button" class="btn btn-soft-warning rounded-pill waves-effect waves-light">Warning</button>
                                    <button type="button" class="btn btn-soft-danger rounded-pill waves-effect waves-light">Danger</button>
                                    <button type="button" class="btn btn-soft-dark rounded-pill waves-effect waves-light">Dark</button>
                                    <button type="button" class="btn btn-soft-blue rounded-pill waves-effect waves-light">Blue</button>
                                    <button type="button" class="btn btn-soft-pink rounded-pill waves-effect waves-light">Pink</button>
                                    <button type="button" class="btn btn-soft-secondary rounded-pill waves-effect">Secondary</button>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                    </div>
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row-->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-6">
                                <h4 class="header-title">Buttons Labels</h4>
                                <p class="sub-header">
                                    Put <code>&lt;span&gt;</code> with class <code>.btn-label</code> and any <code>icon</code> inside it. If you want to
                                    put icon on right side then add class <code>.btn-label-right</code> in <code>&lt;span&gt;</code>
                                </p>

                                <div class="button-list">
                                    <button type="button" class="btn btn-success waves-effect waves-light">
                                        <span class="btn-label"><i class="mdi mdi-check-all"></i></span>Success
                                    </button>
                                    <button type="button" class="btn btn-danger waves-effect waves-light">
                                        <span class="btn-label"><i class="mdi mdi-close-circle-outline"></i></span>Danger
                                    </button>
                                    <button type="button" class="btn btn-info waves-effect waves-light">
                                        <span class="btn-label"><i class="mdi mdi-alert-circle-outline"></i></span>Info
                                    </button>
                                    <button type="button" class="btn btn-warning waves-effect waves-light">
                                        <span class="btn-label"><i class="mdi mdi-alert"></i></span>Warning
                                    </button>
                                </div>
                                <br />
                                <div class="button-list">
                                    <button type="button" class="btn btn-success waves-effect waves-light">
                                        Success<span class="btn-label-right"><i class="mdi mdi-check-all"></i></span>
                                    </button>
                                    <button type="button" class="btn btn-danger waves-effect waves-light">
                                        Danger<span class="btn-label-right"><i class="mdi mdi-close-circle-outline"></i></span>
                                    </button>
                                    <button type="button" class="btn btn-info waves-effect waves-light">
                                        Info<span class="btn-label-right"><i class="mdi mdi-alert-circle-outline"></i></span>
                                    </button>
                                    <button type="button" class="btn btn-warning waves-effect waves-light">
                                        Warning<span class="btn-label-right"><i class="mdi mdi-alert"></i></span>
                                    </button>
                                </div>
                            </div> <!-- end col -->

                            <div class="col-xl-6 mt-xl-0 mt-3">
                                <h4 class="header-title">Outline Rounded Button</h4>
                                <p class="sub-header">
                                    Add <code>.rounded-pill</code> to default button to get rounded corners.
                                </p>

                                <div class="button-list">
                                    <button type="button" class="btn btn-success rounded-pill waves-effect waves-light">
                                        <span class="btn-label"><i class="mdi mdi-check-all"></i></span>Success
                                    </button>
                                    <button type="button" class="btn btn-danger rounded-pill waves-effect waves-light">
                                        <span class="btn-label"><i class="mdi mdi-close-circle-outline"></i></span>Danger
                                    </button>
                                    <button type="button" class="btn btn-info rounded-pill waves-effect waves-light">
                                        <span class="btn-label"><i class="mdi mdi-alert-circle-outline"></i></span>Info
                                    </button>
                                    <button type="button" class="btn btn-warning rounded-pill waves-effect waves-light">
                                        <span class="btn-label"><i class="mdi mdi-alert"></i></span>Warning
                                    </button>
                                </div>
                                <br />
                                <div class="button-list">
                                    <button type="button" class="btn btn-success rounded-pill waves-effect waves-light">
                                        Success<span class="btn-label-right"><i class="mdi mdi-check-all"></i></span>
                                    </button>
                                    <button type="button" class="btn btn-danger rounded-pill waves-effect waves-light">
                                        Danger<span class="btn-label-right"><i class="mdi mdi-close-circle-outline"></i></span>
                                    </button>
                                    <button type="button" class="btn btn-info rounded-pill waves-effect waves-light">
                                        Info<span class="btn-label-right"><i class="mdi mdi-alert-circle-outline"></i></span>
                                    </button>
                                    <button type="button" class="btn btn-warning rounded-pill waves-effect waves-light">
                                        Warning<span class="btn-label-right"><i class="mdi mdi-alert"></i></span>
                                    </button>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                    </div>
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row-->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-4">
                                <h4 class="header-title">Button Width</h4>
                                <p class="sub-header">
                                    Create buttons with minimum width by adding add <code>.width-xs</code>, <code>.width-sm</code>, <code>.width-md</code>, <code>.width-lg</code> or <code>.width-xl</code>.
                                </p>

                                <div class="button-list">
                                    <button type="button" class="btn btn-primary width-xs waves-effect waves-light">xs</button>
                                    <button type="button" class="btn btn-success width-sm waves-effect waves-light">Small</button>
                                    <button type="button" class="btn btn-info width-md waves-effect waves-light">Middle</button>
                                    <button type="button" class="btn btn-warning width-lg waves-effect waves-light">Large</button>
                                    <button type="button" class="btn btn-danger width-xl waves-effect waves-light">Extra Large</button>
                                </div>
                            </div> <!-- end col -->

                            <div class="col-xl-4 mt-xl-0 mt-3">
                                <h4 class="header-title">Button Sizes</h4>
                                <p class="sub-header">
                                    Add <code>.btn-lg</code>, <code>.btn-sm</code>, or <code>.btn-xs</code> for additional sizes.
                                </p>

                                <div class="button-list">
                                    <button type="button" class="btn btn-pink btn-lg waves-effect waves-light">Btn Large</button>
                                    <button type="button" class="btn btn-secondary waves-effect waves-light">Btn Normal</button>
                                    <button type="button" class="btn btn-blue btn-sm waves-effect waves-light">Btn Small</button>
                                    <button type="button" class="btn btn-warning btn-xs waves-effect waves-light">Btn Xs</button>
                                </div>
                            </div> <!-- end col -->

                            <div class="col-xl-4 mt-xl-0 mt-3">
                                <h4 class="header-title">Button Disabled</h4>
                                <p class="sub-header">
                                    Add the <code>disabled</code> attribute to <code>&lt;button&gt;</code> buttons.
                                </p>

                                <div class="button-list">
                                    <button type="button" class="btn btn-primary disabled">Primary</button>
                                    <button type="button" class="btn btn-success disabled">Success</button>
                                    <button type="button" class="btn btn-info disabled">Info</button>
                                    <button type="button" class="btn btn-warning disabled">Warning</button>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                    </div>
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row-->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-6">
                                <h4 class="header-title">Icons Buttons</h4>
                                <p class="sub-header">
                                    Icon only button.
                                </p>

                                <div class="button-list">
                                    <button type="button" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-heart-half-full"></i></button>
                                    <button type="button" class="btn btn-danger waves-effect waves-light"><i class="mdi mdi-close"></i></button>
                                    <button type="button" class="btn btn-info waves-effect waves-light"><i class="mdi mdi-music"></i></button>
                                    <button type="button" class="btn btn-warning waves-effect waves-light"><i class="mdi mdi-star"></i></button>
                                    <button type="button" class="btn btn-blue waves-effect waves-light"><i class="mdi mdi-cog"></i></button>
                                </div>
                                <br />
                                <div class="button-list">
                                    <button type="button" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-heart me-1"></i> Like</button>
                                    <button type="button" class="btn btn-dark waves-effect waves-light"><i class="mdi mdi-email-outline me-1"></i> Share</button>
                                    <button type="button" class="btn btn-info waves-effect waves-light"><i class="mdi mdi-cloud-outline me-1"></i> Cloud Hosting</button>
                                    <button type="button" class="btn btn-warning waves-effect waves-light">Donate <i class="mdi mdi-currency-btc ms-1"></i></button>
                                </div>

                                <h4 class="header-title mt-4">Block Buttons</h4>
                                <p class="sub-header">
                                    Create block level buttons by adding class <code>.d-grid</code> to parent div.
                                </p>

                                <div class="button-list pe-xl-4 d-grid">
                                    <button type="button" class="btn btn-lg btn-primary waves-effect waves-light">Block Button</button>
                                    <button type="button" class="btn btn--md btn-pink waves-effect waves-light">Block Button</button>
                                    <button type="button" class="btn btn-sm btn-success waves-effect waves-light">Block Button</button>
                                </div>
                            </div> <!-- end col -->

                            <div class="col-xl-6 mt-xl-0 mt-3">
                                <h4 class="header-title">Button Group</h4>
                                <p class="sub-header">
                                    Wrap a series of buttons with <code>.btn</code> in <code>.btn-group</code>.
                                </p>

                                <div class="btn-group mb-2">
                                    <button type="button" class="btn btn-light">Left</button>
                                    <button type="button" class="btn btn-light">Middle</button>
                                    <button type="button" class="btn btn-light">Right</button>
                                </div>

                                <br>

                                <div class="btn-group mb-2">
                                    <button type="button" class="btn btn-light">1</button>
                                    <button type="button" class="btn btn-light">2</button>
                                    <button type="button" class="btn btn-light">3</button>
                                    <button type="button" class="btn btn-light">4</button>
                                </div>

                                <div class="btn-group mb-2">
                                    <button type="button" class="btn btn-light">5</button>
                                    <button type="button" class="btn btn-light">6</button>
                                    <button type="button" class="btn btn-light">7</button>
                                </div>

                                <div class="btn-group mb-2">
                                    <button type="button" class="btn btn-light">8</button>
                                </div>

                                <br>

                                <div class="btn-group mb-2">
                                    <button type="button" class="btn btn-light">1</button>
                                    <button type="button" class="btn btn-primary">2</button>
                                    <button type="button" class="btn btn-light">3</button>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"> Dropdown <i class="mdi mdi-chevron-down"></i> </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#">Dropdown link</a>
                                            <a class="dropdown-item" href="#">Dropdown link</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="btn-group-vertical mb-2">
                                            <button type="button" class="btn btn-light">Top</button>
                                            <button type="button" class="btn btn-light">Middle</button>
                                            <button type="button" class="btn btn-light">Bottom</button>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="btn-group-vertical mb-2">
                                            <button type="button" class="btn btn-light">Button 1</button>
                                            <button type="button" class="btn btn-light">Button 2</button>
                                            <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"> Button 3 <i class="mdi mdi-chevron-down"></i> </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#">Dropdown link</a>
                                                <a class="dropdown-item" href="#">Dropdown link</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div> <!-- end col -->
                        </div> <!-- end row -->
                    </div>
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row-->

    </div> <!-- container -->
@endsection
