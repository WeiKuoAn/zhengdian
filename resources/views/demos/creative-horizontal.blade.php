@extends('layouts.horizontal', ['title' => 'Creative (Horizontal Layout)', 'mode' => $mode ?? '', 'demo' => $demo ?? 'creative'])

@section('css')
    @vite('node_modules/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css')
@endsection

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title' , ['title' => 'Creative','subtitle' => 'Demo'])

        <div class="row">
            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-sm bg-blue rounded">
                                    <i class="fe-aperture avatar-title font-22 text-white"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-end">
                                    <h3 class="text-dark my-1">$<span data-plugin="counterup">12,145</span></h3>
                                    <p class="text-muted mb-1 text-truncate">Income status</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <h6 class="text-uppercase">Target <span class="float-end">60%</span></h6>
                            <div class="progress progress-sm m-0">
                                <div class="progress-bar bg-blue" role="progressbar" aria-valuenow="60"
                                     aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                    <span class="visually-hidden">60% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end card-->
            </div> <!-- end col -->

            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-sm bg-success rounded">
                                    <i class="fe-shopping-cart avatar-title font-22 text-white"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-end">
                                    <h3 class="text-dark my-1"><span data-plugin="counterup">1576</span></h3>
                                    <p class="text-muted mb-1 text-truncate">January's Sales</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <h6 class="text-uppercase">Target <span class="float-end">49%</span></h6>
                            <div class="progress progress-sm m-0">
                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="49"
                                     aria-valuemin="0" aria-valuemax="100" style="width: 49%">
                                    <span class="visually-hidden">49% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end card-->
            </div> <!-- end col -->

            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-sm bg-warning rounded">
                                    <i class="fe-bar-chart-2 avatar-title font-22 text-white"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-end">
                                    <h3 class="text-dark my-1">$<span data-plugin="counterup">8947</span></h3>
                                    <p class="text-muted mb-1 text-truncate">Payouts</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <h6 class="text-uppercase">Target <span class="float-end">18%</span></h6>
                            <div class="progress progress-sm m-0">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="18"
                                     aria-valuemin="0" aria-valuemax="100" style="width: 18%">
                                    <span class="visually-hidden">18% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end card-->
            </div> <!-- end col -->

            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-sm bg-info rounded">
                                    <i class="fe-cpu avatar-title font-22 text-white"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-end">
                                    <h3 class="text-dark my-1"><span data-plugin="counterup">178</span></h3>
                                    <p class="text-muted mb-1 text-truncate">Available Stores</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <h6 class="text-uppercase">Target <span class="float-end">74%</span></h6>
                            <div class="progress progress-sm m-0">
                                <div class="progress-bar bg-info" role="progressbar" aria-valuenow="74"
                                     aria-valuemin="0" aria-valuemax="100" style="width: 74%">
                                    <span class="visually-hidden">74% Complete</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-4">
                <!-- Portlet card -->
                <div class="card">
                    <div class="card-body">
                        <div class="card-widgets">
                            <a href="javascript: void(0);" data-bs-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                            <a data-bs-toggle="collapse" href="#cardCollpase1" role="button" aria-expanded="false"
                               aria-controls="cardCollpase1"><i class="mdi mdi-minus"></i></a>
                            <a href="javascript: void(0);" data-bs-toggle="remove"><i class="mdi mdi-close"></i></a>
                        </div>
                        <h4 class="header-title mb-0">Lifetime Sales</h4>

                        <div id="cardCollpase1" class="collapse pt-3 show">
                            <div class="text-center">
                                <div id="lifetime-sales" data-colors="#00acc1,#f1556c"></div>

                                <div class="row mt-3">
                                    <div class="col-4">
                                        <p class="text-muted font-15 mb-1 text-truncate">Target</p>
                                        <h4><i class="fe-arrow-down text-danger me-1"></i>$7.8k</h4>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-muted font-15 mb-1 text-truncate">Last week</p>
                                        <h4><i class="fe-arrow-up text-success me-1"></i>$1.4k</h4>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-muted font-15 mb-1 text-truncate">Last Month</p>
                                        <h4><i class="fe-arrow-down text-danger me-1"></i>$9.8k</h4>
                                    </div>
                                </div> <!-- end row -->

                            </div>
                        </div> <!-- collapsed end -->
                    </div> <!-- end card-body -->
                </div> <!-- end card-->
            </div> <!-- end col-->

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-widgets">
                            <a href="javascript: void(0);" data-bs-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                            <a data-bs-toggle="collapse" href="#cardCollpase2" role="button" aria-expanded="false"
                               aria-controls="cardCollpase2"><i class="mdi mdi-minus"></i></a>
                            <a href="javascript: void(0);" data-bs-toggle="remove"><i class="mdi mdi-close"></i></a>
                        </div>
                        <h4 class="header-title mb-0">Income Amounts</h4>

                        <div id="cardCollpase2" class="collapse pt-3 show">
                            <div class="text-center">
                                <div id="income-amounts" data-colors="#00acc1"></div>
                                <div class="row mt-3">
                                    <div class="col-4">
                                        <p class="text-muted font-15 mb-1 text-truncate">Target</p>
                                        <h4><i class="fe-arrow-up text-success me-1"></i>641</h4>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-muted font-15 mb-1 text-truncate">Last week</p>
                                        <h4><i class="fe-arrow-down text-danger me-1"></i>234</h4>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-muted font-15 mb-1 text-truncate">Last Month</p>
                                        <h4><i class="fe-arrow-up text-success me-1"></i>3201</h4>
                                    </div>
                                </div> <!-- end row -->
                            </div>
                        </div> <!-- collapsed end -->
                    </div> <!-- end card-body -->
                </div> <!-- end card-->
            </div> <!-- end col-->

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-widgets">
                            <a href="javascript: void(0);" data-bs-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                            <a data-bs-toggle="collapse" href="#cardCollpase3" role="button" aria-expanded="false"
                               aria-controls="cardCollpase3"><i class="mdi mdi-minus"></i></a>
                            <a href="javascript: void(0);" data-bs-toggle="remove"><i class="mdi mdi-close"></i></a>
                        </div>
                        <h4 class="header-title mb-0">Total Users</h4>

                        <div id="cardCollpase3" class="collapse pt-3 show">
                            <div class="text-center">
                                <div id="total-users" data-colors="#00acc1,#4b88e4,#e3eaef,#fd7e14"></div>
                                <div class="row mt-3">
                                    <div class="col-4">
                                        <p class="text-muted font-15 mb-1 text-truncate">Target</p>
                                        <h4><i class="fe-arrow-down text-danger me-1"></i>18k</h4>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-muted font-15 mb-1 text-truncate">Last week</p>
                                        <h4><i class="fe-arrow-up text-success me-1"></i>3.25k</h4>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-muted font-15 mb-1 text-truncate">Last Month</p>
                                        <h4><i class="fe-arrow-up text-success me-1"></i>28k</h4>
                                    </div>
                                </div> <!-- end row -->
                            </div>
                        </div> <!-- collapsed end -->
                    </div> <!-- end card-body -->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div>
        <!-- end row -->

        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="card-widgets">
                            <a href="javascript: void(0);" data-bs-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                            <a data-bs-toggle="collapse" href="#cardCollpase4" role="button" aria-expanded="false"
                               aria-controls="cardCollpase4"><i class="mdi mdi-minus"></i></a>
                            <a href="javascript: void(0);" data-bs-toggle="remove"><i class="mdi mdi-close"></i></a>
                        </div>
                        <h4 class="header-title mb-0">Revenue By Location</h4>

                        <div id="cardCollpase4" class="collapse pt-3 show">
                            <div id="world-map-markers" style="height: 433px"></div>
                        </div> <!-- collapsed end -->
                    </div> <!-- end card-body -->
                </div> <!-- end card-->
            </div> <!-- end col -->

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="card-widgets">
                            <a href="javascript: void(0);" data-bs-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                            <a data-bs-toggle="collapse" href="#cardCollpase5" role="button" aria-expanded="false"
                               aria-controls="cardCollpase5"><i class="mdi mdi-minus"></i></a>
                            <a href="javascript: void(0);" data-bs-toggle="remove"><i class="mdi mdi-close"></i></a>
                        </div>
                        <h4 class="header-title mb-0">Top Selling Products</h4>

                        <div id="cardCollpase5" class="collapse pt-3 show">
                            <div class="table-responsive">
                                <table class="table table-hover table-centered mb-0">
                                    <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>ASOS Ridley High Waist</td>
                                        <td>$79.49</td>
                                        <td>82</td>
                                        <td>$6,518.18</td>
                                    </tr>
                                    <tr>
                                        <td>Marco Lightweight Shirt</td>
                                        <td>$128.50</td>
                                        <td>37</td>
                                        <td>$4,754.50</td>
                                    </tr>
                                    <tr>
                                        <td>Half Sleeve Shirt</td>
                                        <td>$39.99</td>
                                        <td>64</td>
                                        <td>$2,559.36</td>
                                    </tr>
                                    <tr>
                                        <td>Lightweight Jacket</td>
                                        <td>$20.00</td>
                                        <td>184</td>
                                        <td>$3,680.00</td>
                                    </tr>
                                    <tr>
                                        <td>Marco Shoes</td>
                                        <td>$28.49</td>
                                        <td>69</td>
                                        <td>$1,965.81</td>
                                    </tr>
                                    <tr>
                                        <td>ASOS Ridley High Waist</td>
                                        <td>$79.49</td>
                                        <td>82</td>
                                        <td>$6,518.18</td>
                                    </tr>
                                    <tr>
                                        <td>Half Sleeve Shirt</td>
                                        <td>$39.99</td>
                                        <td>64</td>
                                        <td>$2,559.36</td>
                                    </tr>
                                    <tr>
                                        <td>Lightweight Jacket</td>
                                        <td>$20.00</td>
                                        <td>184</td>
                                        <td>$3,680.00</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div> <!-- end table responsive-->
                        </div> <!-- collapsed end -->
                    </div> <!-- end card-body -->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->

    </div> <!-- container -->
@endsection

@section('script')
    @vite('resources/js/pages/dashboard-2.init.js')
@endsection
