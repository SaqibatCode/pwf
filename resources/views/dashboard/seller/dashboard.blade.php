@extends('dashboard.layout.layout')
@section('pageTitle')
    Seller Dashboard
@endsection
@section('main-content')
    <style>
        .profile-header {
            position: relative;
            text-align: center;
        }

        .cover-photo {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }

        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid white;
            position: absolute;
            top: 200px;
            left: 50%;
            transform: translateX(-50%);
        }

        .profile-form {
            margin-top: 80px;
        }
    </style>
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
                    You are not verifed, <a href="{{ route('verification') }}" class="alert-link">Click Here</a> to verify
                    yourself.
                </div>
            @elseif(Auth::user()->verification == 'Pending')
                <div class="alert alert-warning" role="alert">
                    Your Verification Request Has Been Sent and Its Pending Approval From Playware. Please Be Patient.
                </div>
            @endif
            <!-- end page title -->
            <h1>THis IS Seller Login</h1>
            <div class="row mb-5 pb-5">
                <div class="col-md-12">
                    <div class="profile-header">
                        @if (Auth::user()->userProfile && Auth::user()->userProfile->cover_photo)
                            <img src="{{ asset(Auth::user()->userProfile->cover_photo) }}" class="cover-photo"
                                alt="Cover Photo">
                        @endif
                        @if (Auth::user()->userProfile && Auth::user()->userProfile->profile_photo)
                            <img src="{{ asset(Auth::user()->userProfile->profile_photo) }}" class="profile-picture"
                                alt="Profile Picture">
                        @endif

                    </div>
                </div>
            </div>
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
            <div class="row ">
                <div class="col-md-6">
                    <a href="{{ route('product.add.new') }}">
                        <div class="card">
                            <div class="card-body d-flex justify-content-center align-items-center flex-column">
                                <img src="{{ asset('assets/images/box.png') }}" width="150" alt=""
                                    class="img-fluid">
                                <h3>Add New Product</h3>
                            </div>
                        </div>
                    </a>

                </div>
                <div class="col-md-6">
                    <a href="{{ route('product.add.used') }}">
                        <div class="card">
                            <div class="card-body d-flex justify-content-center align-items-center flex-column">
                                <img src="{{ asset('assets/images/box.png') }}" width="150" alt=""
                                    class="img-fluid">
                                <h3>Add Used Product</h3>
                            </div>
                        </div>
                    </a>

                </div>
                <div class="col-md-6">
                    <a href="{{ route('product.add.completepc') }}">
                        <div class="card">
                            <div class="card-body d-flex justify-content-center align-items-center flex-column">
                                <img src="{{ asset('assets/images/computer.png') }}" width="150" alt=""
                                    class="img-fluid">
                                <h3>Complete Pc Builds</h3>
                            </div>
                        </div>
                    </a>

                </div>
                <div class="col-md-6">
                    <a href="{{ route('product.add.laptop') }}">
                        <div class="card">
                            <div class="card-body d-flex justify-content-center align-items-center flex-column">
                                <img src="{{ asset('assets/images/laptop.png') }}" width="150" alt=""
                                    class="img-fluid">
                                <h3>Add Laptops</h3>
                            </div>
                        </div>
                    </a>

                </div>

            </div>
        </div> <!-- container-fluid -->
    </div>
@endsection
