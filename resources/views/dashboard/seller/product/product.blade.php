@extends('dashboard.layout.layout')
@section('pageTitle')
    Seller Products
@endsection
@section('main-content')
    <div class="page-content">
        <div class="container-fluid">


            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Products</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Playware</a></li>
                                <li class="breadcrumb-item active">Products</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->


           <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="#">
                                <img src="" alt="">
                                <p>Add New Product</p>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="#">
                                <img src="" alt="">
                                <p>Add Used Product</p>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="#">
                                <img src="" alt="">
                                <p>Add Complete Pc</p>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="#">
                                <img src="" alt="">
                                <p>Add Laptop</p>
                            </a>
                        </div>
                    </div>
                </div>
           </div>






        </div>
    </div>
@endsection
