@extends('layouts.vertical', ['title' => 'CRM Customers'])

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        @include('layouts.shared.page-title' , ['title' => 'Customers','subtitle' => 'CRM'])

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-4">
                                <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#custom-modal"><i class="mdi mdi-plus-circle me-1"></i> Add Customers</button>
                            </div>
                            <div class="col-sm-8">
                                <div class="text-sm-end mt-2 mt-sm-0">
                                    <button type="button" class="btn btn-success mb-2 me-1"><i class="mdi mdi-cog"></i></button>
                                    <button type="button" class="btn btn-light mb-2 me-1">Import</button>
                                    <button type="button" class="btn btn-light mb-2">Export</button>
                                </div>
                            </div><!-- end col-->
                        </div>

                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap table-striped" id="products-datatable">
                                <thead>
                                    <tr>
                                        <th style="width: 20px;">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="customCheck1">
                                                <label class="form-check-label" for="customCheck1">&nbsp;</label>
                                            </div>
                                        </th>
                                        <th>Customer</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Location</th>
                                        <th>Create Date</th>
                                        <th>Status</th>
                                        <th style="width: 85px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="customCheck2">
                                                <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td class="table-user">
                                            <img src="/images/users/user-4.jpg" alt="table-user" class="me-2 rounded-circle">
                                            <a href="javascript:void(0);" class="text-body fw-semibold">Paul J. Friend</a>
                                        </td>
                                        <td>
                                            937-330-1634
                                        </td>
                                        <td>
                                            pauljfrnd@jourrapide.com
                                        </td>
                                        <td>
                                            New York
                                        </td>
                                        <td>
                                            07/07/2018
                                        </td>
                                        <td>
                                            <span class="badge bg-soft-success text-success">Active</span>
                                        </td>

                                        <td>
                                            <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                            <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="customCheck3">
                                                <label class="form-check-label" for="customCheck3">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td class="table-user">
                                            <img src="/images/users/user-3.jpg" alt="table-user" class="me-2 rounded-circle">
                                            <a href="javascript:void(0);" class="text-body fw-semibold">Bryan J. Luellen</a>
                                        </td>
                                        <td>
                                            215-302-3376
                                        </td>
                                        <td>
                                            bryuellen@dayrep.com
                                        </td>
                                        <td>
                                            New York
                                        </td>
                                        <td>
                                            09/12/2018
                                        </td>
                                        <td>
                                            <span class="badge bg-soft-success text-success">Active</span>
                                        </td>

                                        <td>
                                            <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                            <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="customCheck4">
                                                <label class="form-check-label" for="customCheck4">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td class="table-user">
                                            <img src="/images/users/user-3.jpg" alt="table-user" class="me-2 rounded-circle">
                                            <a href="javascript:void(0);" class="text-body fw-semibold">Kathryn S. Collier</a>
                                        </td>
                                        <td>
                                            828-216-2190
                                        </td>
                                        <td>
                                            collier@jourrapide.com
                                        </td>
                                        <td>
                                            Canada
                                        </td>
                                        <td>
                                            06/30/2018
                                        </td>
                                        <td>
                                            <span class="badge bg-soft-danger text-danger">Blocked</span>
                                        </td>

                                        <td>
                                            <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                            <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="customCheck5">
                                                <label class="form-check-label" for="customCheck5">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td class="table-user">
                                            <img src="/images/users/user-1.jpg" alt="table-user" class="me-2 rounded-circle">
                                            <a href="javascript:void(0);" class="text-body fw-semibold">Timothy Kauper</a>
                                        </td>
                                        <td>
                                            (216) 75 612 706
                                        </td>
                                        <td>
                                            thykauper@rhyta.com
                                        </td>
                                        <td>
                                            Denmark
                                        </td>
                                        <td>
                                            09/08/2018
                                        </td>
                                        <td>
                                            <span class="badge bg-soft-danger text-danger">Blocked</span>
                                        </td>

                                        <td>
                                            <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                            <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="customCheck6">
                                                <label class="form-check-label" for="customCheck6">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td class="table-user">
                                            <img src="/images/users/user-5.jpg" alt="table-user" class="me-2 rounded-circle">
                                            <a href="javascript:void(0);" class="text-body fw-semibold">Zara Raws</a>
                                        </td>
                                        <td>
                                            (02) 75 150 655
                                        </td>
                                        <td>
                                            austin@dayrep.com
                                        </td>
                                        <td>
                                            Germany
                                        </td>
                                        <td>
                                            07/15/2018
                                        </td>
                                        <td>
                                            <span class="badge bg-soft-success text-success">Active</span>
                                        </td>

                                        <td>
                                            <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                            <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="customCheck7">
                                                <label class="form-check-label" for="customCheck7">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td class="table-user">
                                            <img src="/images/users/user-6.jpg" alt="table-user" class="me-2 rounded-circle">
                                            <a href="javascript:void(0);" class="text-body fw-semibold">Annette P. Kelsch</a>
                                        </td>
                                        <td>
                                            (+15) 73 483 758
                                        </td>
                                        <td>
                                            annette@email.net
                                        </td>
                                        <td>
                                            India
                                        </td>
                                        <td>
                                            09/05/2018
                                        </td>
                                        <td>
                                            <span class="badge bg-soft-success text-success">Active</span>
                                        </td>

                                        <td>
                                            <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                            <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="customCheck8">
                                                <label class="form-check-label" for="customCheck8">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td class="table-user">
                                            <img src="/images/users/user-7.jpg" alt="table-user" class="me-2 rounded-circle">
                                            <a href="javascript:void(0);" class="text-body fw-semibold">Jenny C. Gero</a>
                                        </td>
                                        <td>
                                            078 7173 9261
                                        </td>
                                        <td>
                                            jennygero@teleworm.us
                                        </td>
                                        <td>
                                            Lesotho
                                        </td>
                                        <td>
                                            08/02/2018
                                        </td>
                                        <td>
                                            <span class="badge bg-soft-danger text-danger">Blocked</span>
                                        </td>

                                        <td>
                                            <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                            <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="customCheck9">
                                                <label class="form-check-label" for="customCheck9">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td class="table-user">
                                            <img src="/images/users/user-8.jpg" alt="table-user" class="me-2 rounded-circle">
                                            <a href="javascript:void(0);" class="text-body fw-semibold">Edward Roseby</a>
                                        </td>
                                        <td>
                                            078 6013 3854
                                        </td>
                                        <td>
                                            edwardR@armyspy.com
                                        </td>
                                        <td>
                                            Monaco
                                        </td>
                                        <td>
                                            08/23/2018
                                        </td>
                                        <td>
                                            <span class="badge bg-soft-success text-success">Active</span>
                                        </td>

                                        <td>
                                            <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                            <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="customCheck10">
                                                <label class="form-check-label" for="customCheck10">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td class="table-user">
                                            <img src="/images/users/user-9.jpg" alt="table-user" class="me-2 rounded-circle">
                                            <a href="javascript:void(0);" class="text-body fw-semibold">Anna Ciantar</a>
                                        </td>
                                        <td>
                                            (216) 76 298 896
                                        </td>
                                        <td>
                                            annac@hotmai.us
                                        </td>
                                        <td>
                                            Philippines
                                        </td>
                                        <td>
                                            05/06/2018
                                        </td>
                                        <td>
                                            <span class="badge bg-soft-success text-success">Active</span>
                                        </td>

                                        <td>
                                            <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                            <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="customCheck11">
                                                <label class="form-check-label" for="customCheck11">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td class="table-user">
                                            <img src="/images/users/user-10.jpg" alt="table-user" class="me-2 rounded-circle">
                                            <a href="javascript:void(0);" class="text-body fw-semibold">Dean Smithies</a>
                                        </td>
                                        <td>
                                            077 6157 4248
                                        </td>
                                        <td>
                                            deanes@dayrep.com
                                        </td>
                                        <td>
                                            Singapore
                                        </td>
                                        <td>
                                            04/09/2018
                                        </td>
                                        <td>
                                            <span class="badge bg-soft-success text-success">Active</span>
                                        </td>

                                        <td>
                                            <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                            <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="customCheck12">
                                                <label class="form-check-label" for="customCheck12">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td class="table-user">
                                            <img src="/images/users/user-1.jpg" alt="table-user" class="me-2 rounded-circle">
                                            <a href="javascript:void(0);" class="text-body fw-semibold">Labeeb Ghali</a>
                                        </td>
                                        <td>
                                            050 414 8778
                                        </td>
                                        <td>
                                            labebswad@teleworm.us
                                        </td>
                                        <td>
                                            United Kingdom
                                        </td>
                                        <td>
                                            06/19/2018
                                        </td>
                                        <td>
                                            <span class="badge bg-soft-success text-success">Active</span>
                                        </td>

                                        <td>
                                            <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                            <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="customCheck13">
                                                <label class="form-check-label" for="customCheck13">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td class="table-user">
                                            <img src="/images/users/user-2.jpg" alt="table-user" class="me-2 rounded-circle">
                                            <a href="javascript:void(0);" class="text-body fw-semibold">Rory Seekamp</a>
                                        </td>
                                        <td>
                                            078 5054 8877
                                        </td>
                                        <td>
                                            roryamp@dayrep.com
                                        </td>
                                        <td>
                                            United States
                                        </td>
                                        <td>
                                            03/24/2018
                                        </td>
                                        <td>
                                            <span class="badge bg-soft-danger text-danger">Blocked</span>
                                        </td>

                                        <td>
                                            <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                            <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <ul class="pagination pagination-rounded justify-content-end mb-0">
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

                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->

    </div> <!-- container -->

    <!-- Modal -->
    <div class="modal fade" id="custom-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Add New Customers</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body p-4">
                    <form>
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter full name">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                        </div>
                        <div class="mb-3">
                            <label for="position" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="position" placeholder="Enter phone number">
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Location</label>
                            <input type="text" class="form-control" id="category" placeholder="Enter Location">
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success waves-effect waves-light">Save</button>
                            <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-dismiss="modal">Continue</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection
