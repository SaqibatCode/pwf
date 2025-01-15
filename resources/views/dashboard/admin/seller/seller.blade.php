@extends('dashboard.layout.layout')
@section('pageTitle')
    All Sellers
@endsection
@section('main-content')
    <div class="page-content">
        <div class="container-fluid">


            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">All Seller</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Playware</a></li>
                                <li class="breadcrumb-item active">All Seller</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>


            <form method="GET" action="{{ route('admin.show.sellers') }}" class="mb-3">
                <div class="row">
                    <div class="col-md-3">
                        <input type="text" name="seller_name" id="seller_name" placeholder="Seller Name"
                            class="form-control">
                    </div>
                    <div class="col-md-3">
                        <select name="seller_type" id="seller_type" class="form-control">
                            <option value="">Select Seller Type</option>
                            <option value="Individual">Individual</option>
                            <option value="Shop Keeper">Shop Keeper</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="seller_verification_type" id="seller_verification_type" class="form-control">
                            <option value="">Select Seller Type</option>
                            <option value="Unverified">Unverified</option>
                            <option value="Pending">Pending</option>
                            <option value="Verified">Verified</option>
                            <option value="Verified Plus">Verified Plus</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('admin.show.sellers') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>

            <div class="row">
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Seller Type</th>
                                <th>Seller Verification Type</th>
                                <th>Seller City</th>
                                <th>Seller Phone</th>
                                <th>Seller Email</th>
                                <th>Seller Since</th>
                                <th>Action</th>
                            </tr>
                            <tr>
                                @foreach ($sellers as $seller)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>{{ $seller->first_name }}</td>
                                <td>{{ $seller->seller_type }}</td>
                                <td>{{ $seller->verification }}</td>
                                <td>{{ $seller->city }}</td>
                                <td>{{ $seller->phone }}</td>
                                <td>{{ $seller->email }}</td>
                                <td>{{ $seller->created_at }}</td>
                                <td>
                                    <a href="{{ route('show.seller.portfolio', $seller->slug) }}" class="btn btn-primary">View Seller Profile</a>
                                    <a href="{{ route('user.profile', $seller->slug) }}" class="btn btn-primary">Edit Seller Profile</a>
                                    @if ($seller->verification !== 'Unverified')
                                        <form method="POST" action="{{ route('verification.reject') }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $seller->id }}">
                                            <button type="submit" class="btn btn-secondary">Reject Seller Profile</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            </tr>
                        </thead>
                    </table>
                    {{ $sellers->links() }}
                </div>
            </div>
        </div> <!-- container-fluid -->
    </div>
@endsection
