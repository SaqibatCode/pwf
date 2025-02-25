<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>@yield('pageTitle') - Playware</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="MyraStudio" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- App css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/theme.min.css') }}" rel="stylesheet" type="text/css" />

    @yield('additionsStyles')

    <style>
        .skeleton {
            position: relative;
        }

        .skeleton::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 10;
            background: linear-gradient(90deg, #eee, #f9f9f9, #eee);
            background-size: 200%;
            animation: skeleton 1s infinite reverse;
        }

        @keyframes skeleton {
            0% {
                background-position: -100% 0;
            }

            100% {
                background-position: 100% 0;
            }
        }
    </style>


</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
            <div class="navbar-header">

                <div class="d-flex align-items-left">
                    <button type="button" class="btn btn-sm mr-2 d-lg-none px-3 font-size-16 header-item waves-effect"
                        id="vertical-menu-btn">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>


                </div>

                <div class="d-flex align-items-center">




                    <div class="dropdown d-inline-block ml-2">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user"
                                src="{{ asset('assets/images/users/avatar-3.jpg') }}" alt="Header Avatar">
                            <span class="d-none d-sm-inline-block ml-1">{{ Auth::user()->first_name }}</span>
                            <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item d-flex align-items-center justify-content-between"
                                    type="submit">Log Out</button>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </header>

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu py-5">

            <div data-simplebar class="h-100">

                <div class="navbar-brand-box">
                    <a href="/" class="logo">
                        <img style="height: 50px;" src="{{ asset('assets/images/logo/logo.svg') }}" />
                    </a>
                </div>

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    @if (Auth::user()->type == 'seller')
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li class="menu-title">Menu</li>
                            <li class="menu-item">
                                <a href="{{ route('portal') }}" data-bs-toggle="collapse" class="menu-link waves-effect"
                                    aria-expanded="true">
                                    <span class="menu-icon"><i class="bx bx-file"></i></span>
                                    <span class="menu-text"> Dashboard </span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="#menuExpages" data-bs-toggle="collapse" class="menu-link waves-effect"
                                    aria-expanded="true">
                                    <span class="menu-icon"><i class="bx bx-file"></i></span>
                                    <span class="menu-text"> Products </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse show" id="menuExpages" style="">
                                    <ul class="sub-menu">
                                        <li class="menu-item">
                                            <a class="menu-link" href="{{ route('product.index') }}">
                                                <span class="menu-text">Add Products</span>
                                            </a>
                                        </li>
                                        <li class="menu-item">
                                            <a class="menu-link" href="{{ route('seller.approved.products') }}">
                                                <span class="menu-text">Approved Products</span>
                                            </a>
                                        </li>
                                        <li class="menu-item">
                                            <a class="menu-link" href="{{ route('seller.pending.products') }}">
                                                <span class="menu-text">Pending Products</span>
                                            </a>
                                        </li>
                                        <li class="menu-item">
                                            <a class="menu-link" href="{{ route('seller.rejected.products') }}">
                                                <span class="menu-text">Rejected Products</span>
                                            </a>
                                        </li>
                                        {{-- <li class="menu-item">
                                            <a class="menu-link" href="#">
                                                <span class="menu-text">Add Packages</span>
                                            </a>
                                        </li> --}}

                                    </ul>
                                </div>
                            </li>
                            <li class="menu-item">
                                <a href="#menuExpages" data-bs-toggle="collapse" class="menu-link waves-effect"
                                    aria-expanded="true">
                                    <span class="menu-icon"><i class="bx bx-box"></i></span>
                                    <span class="menu-text"> Orders </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse show" id="menuExpages" style="">
                                    <ul class="sub-menu">
                                        <li class="menu-item">
                                            <a class="menu-link" href="{{ route('seller.all.orders') }}">
                                                <span class="menu-text">All Orders</span>
                                            </a>
                                        </li>

                                        <li class="menu-item">
                                            <a class="menu-link" href="{{ route('seller.pending.orders') }}">
                                                <span class="menu-text">Pending Orders</span>
                                            </a>
                                        </li>
                                        <li class="menu-item">
                                            <a class="menu-link" href="{{ route('seller.dispatched.orders') }}">
                                                <span class="menu-text">Dispatched Orders</span>
                                            </a>
                                        </li>
                                        <li class="menu-item">
                                            <a class="menu-link" href="{{ route('seller.completed.orders') }}">
                                                <span class="menu-text">Completed Order</span>
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('user.profile', Auth::user()->slug) }}" data-bs-toggle="collapse"
                                    class="menu-link waves-effect" aria-expanded="true">
                                    <span class="menu-icon"><i class="bx bx-user"></i></span>
                                    <span class="menu-text"> My Profile </span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('portal') }}" data-bs-toggle="collapse"
                                    class="menu-link waves-effect" aria-expanded="true">
                                    <span class="menu-icon"><i class="bx bx-support"></i></span>
                                    <span class="menu-text"> Seller Support </span>
                                </a>
                            </li>
                            @if (Auth::user()->verification == 'Unverified' || Auth::user()->verification == 'Pending')
                                <li class="menu-item">
                                    <a href="{{ route('verification') }}" data-bs-toggle="collapse"
                                        class="menu-link waves-effect" aria-expanded="true">
                                        <span class="menu-icon"><i class="bx bx-check"></i></span>
                                        <span class="menu-text"> Verfication </span>
                                    </a>
                                </li>
                            @endif

                        </ul>
                    @endif


                    <!---- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- --
                        -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- --
                                                            Admin Navigation
                        -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- --
                    -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -->
                    @if (Auth::user()->type == 'admin')
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li class="menu-title">Menu</li>
                            <li class="menu-item">
                                <a href="{{ route('portal') }}" data-bs-toggle="collapse"
                                    class="menu-link waves-effect" aria-expanded="true">
                                    <span class="menu-icon"><i class="bx bx-file"></i></span>
                                    <span class="menu-text"> Dashboard </span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="#menuExpages" data-bs-toggle="collapse" class="menu-link waves-effect"
                                    aria-expanded="true">
                                    <span class="menu-icon"><i class="bx bx-file"></i></span>
                                    <span class="menu-text"> Products </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse show" id="menuExpages" style="">
                                    <ul class="sub-menu">
                                        <li class="menu-item">
                                            <a class="menu-link" href="{{ route('admin.show.all.products') }}">
                                                <span class="menu-text">All Products</span>
                                            </a>
                                        </li>
                                        <li class="menu-item">
                                            <a class="menu-link" href="{{ route('admin.show.pending.products') }}">
                                                <span class="menu-text">Pending Products</span>
                                            </a>
                                        </li>
                                        <li class="menu-item">
                                            <a class="menu-link" href="{{ route('admin.show.approved.products') }}">
                                                <span class="menu-text">Approved Products</span>
                                            </a>
                                        </li>
                                        <li class="menu-item">
                                            <a class="menu-link" href="{{ route('admin.show.rejected.products') }}">
                                                <span class="menu-text">Rejected Products</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="menu-item">
                                <a href="#menuExpages" data-bs-toggle="collapse" class="menu-link waves-effect"
                                    aria-expanded="true">
                                    <span class="menu-icon"><i class="bx bx-file"></i></span>
                                    <span class="menu-text"> Products Management</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse show" id="menuExpages" style="">
                                    <ul class="sub-menu">
                                        <li class="menu-item">
                                            <a class="menu-link" href="{{ route('category') }}">
                                                <span class="menu-text">Categories</span>
                                            </a>
                                        </li>
                                        <li class="menu-item">
                                            <a class="menu-link" href="{{ route('brand.index') }}">
                                                <span class="menu-text">Brands</span>
                                            </a>
                                        </li>
                                        <li class="menu-item">
                                            <a class="menu-link" href="{{ route('attribute.index') }}">
                                                <span class="menu-text">Attributes</span>
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('admin.show.sellers') }}" data-bs-toggle="collapse"
                                    class="menu-link waves-effect" aria-expanded="true">
                                    <span class="menu-icon"><i class="bx bx-user"></i></span>
                                    <span class="menu-text"> Sellers </span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{ route('verification') }}" data-bs-toggle="collapse"
                                    class="menu-link waves-effect" aria-expanded="true">
                                    <span class="menu-icon"><i class="bx bx-check"></i></span>
                                    <span class="menu-text"> Verfication </span>
                                </a>

                            </li>
                            <li class="menu-item">
                                <a href="{{ route('admin.all.orders') }}" data-bs-toggle="collapse"
                                    class="menu-link waves-effect" aria-expanded="true">
                                    <span class="menu-icon"><i class="bx bx-box"></i></span>
                                    <span class="menu-text"> Orders </span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="#menuExpages" data-bs-toggle="collapse" class="menu-link waves-effect"
                                    aria-expanded="true">
                                    <span class="menu-icon"><i class="bx bx-file"></i></span>
                                    <span class="menu-text"> CMS - Website Manager </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse show" id="menuExpages" style="">
                                    <ul class="sub-menu">
                                        <li class="menu-item">
                                            <a class="menu-link" href="{{ route('slider.index') }}">
                                                <span class="menu-text">Home Page Sliders</span>
                                            </a>
                                        </li>
                                        <li class="menu-item">
                                            <a class="menu-link" href="{{ route('admin.terms.edit') }}">
                                                <span class="menu-text">Edit Terms & Condition</span>
                                            </a>
                                        </li>
                                        <li class="menu-item">
                                            <a class="menu-link" href="{{ route('admin.about.edit') }}">
                                                <span class="menu-text">Edit About Us</span>
                                            </a>
                                        </li>
                                        <li class="menu-item">
                                            <a class="menu-link" href="{{ route('admin.contact.edit') }}">
                                                <span class="menu-text">Edit Contact Us</span>
                                            </a>
                                        </li>
                                        <li class="menu-item">
                                            <a class="menu-link" href="{{ route('admin.faqs.index') }}">
                                                <span class="menu-text">Manage FAQS</span>
                                            </a>
                                        </li>
                                        <li class="menu-item">
                                            <a class="menu-link" href="{{ route('admin.bank_details.index') }}">
                                                <span class="menu-text">Manage Bank Accounts</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="menu-item">
                                <a href="#menuExpages" data-bs-toggle="collapse" class="menu-link waves-effect"
                                    aria-expanded="true">
                                    <span class="menu-icon"><i class="bx bx-file"></i></span>
                                    <span class="menu-text"> Requests </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse show" id="menuExpages" style="">
                                    <ul class="sub-menu">
                                        <li class="menu-item">
                                            <a class="menu-link" href="#">
                                                <span class="menu-text">User Requests</span>
                                            </a>
                                        </li>
                                        <li class="menu-item">
                                            <a class="menu-link" href="#">
                                                <span class="menu-text">Seller Requests</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    @endif
                </div>
                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            @yield('main-content')
            <!-- End Page-content -->

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            2024 © TeamDevs.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-right d-none d-sm-block">
                                Design & Develop by TeamDevs
                            </div>
                        </div>
                    </div>
                </div>
            </footer>

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Overlay-->
    <div class="menu-overlay"></div>


    <!-- jQuery  -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/metismenu.min.js') }}"></script>
    <script src="{{ asset('assets/js/waves.js') }}"></script>
    <script src="{{ asset('assets/js/simplebar.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('assets/js/theme.js') }}"></script>


    @yield('additionScript')

</body>

</html>
