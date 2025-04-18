@extends('layouts.vertical', ['title' => 'Nestable List'])

@section('css')
    @vite(['node_modules/nestable2/dist/jquery.nestable.min.css'])
@endsection

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title' , ['title' => 'Nestable List','subtitle' => 'Extended UI'])

        <div class="row">
            <div class="col-lg-12">
                <div class="text-start" id="nestable_list_menu">
                    <button type="button" class="btn btn-blue btn-sm waves-effect mb-3 waves-light" data-action="expand-all">Expand All</button>
                    <button type="button" class="btn btn-pink btn-sm waves-effect mb-3 waves-light" data-action="collapse-all">Collapse All</button>
                </div>
            </div> <!-- end col -->
        </div>
        <!-- End row -->

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="header-title">Nestable Lists 1</h4>
                                <p class="sub-header">
                                    Drag & drop hierarchical list with mouse and touch compatibility (jQuery plugin).
                                </p>

                                <div class="custom-dd dd" id="nestable_list_1">
                                    <ol class="dd-list">
                                        <li class="dd-item" data-id="1">
                                            <div class="dd-handle">
                                                Choose a smartwatch
                                            </div>
                                        </li>
                                        <li class="dd-item" data-id="2">
                                            <div class="dd-handle">
                                                Send design for review
                                            </div>
                                            <ol class="dd-list">
                                                <li class="dd-item" data-id="3">
                                                    <div class="dd-handle">
                                                        Coffee with the team
                                                    </div>
                                                </li>
                                                <li class="dd-item" data-id="4">
                                                    <div class="dd-handle">
                                                        Ready my new work
                                                    </div>
                                                </li>
                                                <li class="dd-item" data-id="5">
                                                    <div class="dd-handle">
                                                        Make a wireframe
                                                    </div>
                                                    <ol class="dd-list">
                                                        <li class="dd-item" data-id="6">
                                                            <div class="dd-handle">
                                                                Video app redesign
                                                            </div>
                                                        </li>
                                                        <li class="dd-item" data-id="7">
                                                            <div class="dd-handle">
                                                                iOS apps design completed
                                                            </div>
                                                        </li>
                                                        <li class="dd-item" data-id="8">
                                                            <div class="dd-handle">
                                                                Dashboard design started
                                                            </div>
                                                        </li>
                                                    </ol>
                                                </li>
                                                <li class="dd-item" data-id="9">
                                                    <div class="dd-handle">
                                                        Homepage design
                                                    </div>
                                                </li>
                                                <li class="dd-item" data-id="10">
                                                    <div class="dd-handle">
                                                        Developed UI Kit
                                                    </div>
                                                </li>
                                            </ol>
                                        </li>

                                    </ol>
                                </div>
                            </div><!-- end col -->

                            <div class="col-md-6">
                                <h4 class="header-title mt-3 mt-md-0">Nestable Lists 2</h4>
                                <p class="sub-header">
                                    Drag & drop hierarchical list with mouse and touch compatibility (jQuery plugin).
                                </p>

                                <div class="custom-dd dd" id="nestable_list_2">
                                    <ol class="dd-list">
                                        <li class="dd-item" data-id="11">
                                            <div class="dd-handle">
                                                Item 11
                                            </div>
                                        </li>
                                        <li class="dd-item" data-id="12">
                                            <div class="dd-handle">
                                                Item 12
                                            </div>
                                        </li>
                                        <li class="dd-item" data-id="13">
                                            <div class="dd-handle">
                                                Item 13
                                            </div>
                                        </li>
                                        <li class="dd-item" data-id="14">
                                            <div class="dd-handle">
                                                Item 14
                                            </div>
                                        </li>
                                        <li class="dd-item" data-id="15">
                                            <div class="dd-handle">
                                                Item 15
                                            </div>
                                            <ol class="dd-list">
                                                <li class="dd-item" data-id="16">
                                                    <div class="dd-handle">
                                                        Item 16
                                                    </div>
                                                </li>
                                                <li class="dd-item" data-id="17">
                                                    <div class="dd-handle">
                                                        Item 17
                                                    </div>
                                                </li>
                                                <li class="dd-item" data-id="18">
                                                    <div class="dd-handle">
                                                        Item 18
                                                    </div>
                                                </li>
                                            </ol>
                                        </li>
                                    </ol>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->
                    </div>
                </div> <!-- end card -->
            </div> <!-- end col -->
        </div>
        <!-- end Row -->

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="header-title">Nestable Lists 3</h4>
                                <p class="sub-header">
                                    Drag & drop hierarchical list with mouse and touch compatibility (jQuery plugin).
                                </p>

                                <div class="custom-dd-empty dd" id="nestable_list_3">
                                    <ol class="dd-list">
                                        <li class="dd-item dd3-item" data-id="13">
                                            <div class="dd-handle dd3-handle"></div>
                                            <div class="dd3-content">
                                                Item 13
                                            </div>
                                        </li>
                                        <li class="dd-item dd3-item" data-id="14">
                                            <div class="dd-handle dd3-handle"></div>
                                            <div class="dd3-content">
                                                Item 14
                                            </div>
                                        </li>
                                        <li class="dd-item dd3-item" data-id="15">
                                            <div class="dd-handle dd3-handle"></div>
                                            <div class="dd3-content">
                                                Item 15
                                            </div>
                                            <ol class="dd-list">
                                                <li class="dd-item dd3-item" data-id="16">
                                                    <div class="dd-handle dd3-handle"></div>
                                                    <div class="dd3-content">
                                                        Item 16
                                                    </div>
                                                </li>
                                                <li class="dd-item dd3-item" data-id="17">
                                                    <div class="dd-handle dd3-handle"></div>
                                                    <div class="dd3-content">
                                                        Item 17
                                                    </div>
                                                </li>
                                                <li class="dd-item dd3-item" data-id="18">
                                                    <div class="dd-handle dd3-handle"></div>
                                                    <div class="dd3-content">
                                                        Item 18
                                                    </div>
                                                </li>
                                            </ol>
                                        </li>
                                    </ol>
                                </div>
                            </div><!-- end col -->
                        </div> <!-- end row -->
                    </div>
                </div> <!-- end card -->
            </div> <!-- end col -->
        </div>
        <!-- end Row -->

    </div> <!-- container -->
@endsection

@section('script')
    @vite(['resources/js/pages/nestable.init.js'])
@endsection
