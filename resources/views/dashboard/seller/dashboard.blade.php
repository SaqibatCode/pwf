@extends('dashboard.layout.layout')
@section('pageTitle')
    Seller Dashboard
@endsection
@section('main-content')
    <div class="page-content">
        <div class="container-fluid">


            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Dashboard</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Playware</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            @if (Auth::user()->verification == 'Unverified')
                <div class="alert alert-danger" role="alert">
                    You are not verifed, <a href="javascript: void(0);" class="alert-link">Click Here</a> to verify
                    yourself.
                </div>
            @elseif(Auth::user()->verification == 'Pending')
                <div class="alert alert-warning" role="alert">
                    Your Verification Request Has Been Sent and Its Pending Approval From Playware. Please Be Patient.
                </div>
            @endif
            <!-- end page title -->
            <h1>THis IS Seller Login</h1>
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <i class="bx bx-layer float-end m-0 h2 text-muted"></i>
                            <h6 class="text-muted text-uppercase mt-0">Orders</h6>
                            <h3 class="mb-3" data-plugin="counterup">1,587</h3>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <i class="bx bx-dollar-circle float-end m-0 h2 text-muted"></i>
                            <h6 class="text-muted text-uppercase mt-0">Revenue</h6>
                            <h3 class="mb-3">Rs.<span data-plugin="counterup">46,782</span></h3>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <i class="bx bx-basket float-end m-0 h2 text-muted"></i>
                            <h6 class="text-muted text-uppercase mt-0">Product Sold</h6>
                            <h3 class="mb-3" data-plugin="counterup">1,890</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- container-fluid -->
    </div>
@endsection
