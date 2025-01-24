@extends('dashboard.layout.layout')
@section('pageTitle')
    Seller Verification
@endsection
@section('main-content')
    <div class="page-content">
        <div class="container-fluid">


            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Verification</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Playware</a></li>
                                <li class="breadcrumb-item active">Verfication</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="table-responsive">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Seller Type</th>
                            <th>Request Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($verification as $ver)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $ver->first_name }}</td>
                                <td>{{ $ver->last_name }}</td>
                                <td>{{ $ver->email }}</td>
                                <td>{{ $ver->phone }}</td>
                                <td>{{ $ver->seller_type }}</td>
                                <td>{{ $ver->created_at }}</td>
                                <td><button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModalCenter{{ $ver->id }}">View Details</button></td>


                                <div class="modal fade" id="exampleModalCenter{{ $ver->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="container">
                                                    <!-- Personal Information -->
                                                    <h5>Personal Information:</h5>
                                                    <ul>
                                                        <li><strong>First Name:</strong> {{ $ver->first_name }}</li>
                                                        <li><strong>Last Name:</strong> {{ $ver->last_name }}</li>
                                                        <li><strong>Father's Name:</strong> {{ $ver->father_name }}</li>
                                                        <li><strong>Email:</strong> {{ $ver->email }}</li>
                                                        <li><strong>Date of Birth:</strong> {{ $ver->dob }}</li>
                                                        <li><strong>Address:</strong> {{ $ver->address }}</li>
                                                        <li><strong>CNIC:</strong> {{ $ver->cnic }}</li>
                                                        <li><strong>Phone:</strong> {{ $ver->phone }}</li>
                                                    </ul>

                                                    <!-- Verification Details -->
                                                    <h5>Verification Details:</h5>
                                                    @if ($ver->seller_type !== 'Individual')
                                                        <ul>
                                                            <li><strong>Shop Name:</strong>
                                                                {{ $ver->user_verification->shop_name }}
                                                            </li>
                                                            <li><strong>Shop Address:</strong>
                                                                {{ $ver->user_verification->shop_address }}</li>
                                                            <li><strong>Shop Picture:</strong> <img
                                                                    src="{{ asset($ver->user_verification->shop_picture) }}"
                                                                    alt="Shop Picture" class="img-fluid"></li>
                                                            <li><strong>Shop Business Card:</strong> <img
                                                                    src="{{ asset($ver->user_verification->shop_business_card_picture) }}"
                                                                    alt="Business Card" class="img-fluid"></li>
                                                            <li><strong>Cnic Front:</strong> <img
                                                                    src="{{ asset($ver->user_verification->cnic_front_picture) }}"
                                                                    alt="cnic_front_picture Picture" class="img-fluid"></li>
                                                            <li><strong>Cnic Back:</strong> <img
                                                                    src="{{ asset($ver->user_verification->cnic_back_picture) }}"
                                                                    alt="cnic_back_picture Card" class="img-fluid"></li>
                                                            <li><strong>Cnic Holding Selfie:</strong> <img
                                                                    src="{{ $ver->user_verification->cnic_holding_selfie }}"
                                                                    alt="cnic_back_picture Card" class="img-fluid"></li>
                                                        </ul>
                                                    @else
                                                        <ul>
                                                            <li><strong>Cnic Front:</strong> <img
                                                                    src="{{ $ver->user_verification->cnic_front_picture }}"
                                                                    alt="cnic_front_picture Picture" class="img-fluid"></li>
                                                            <li><strong>Cnic Back:</strong> <img
                                                                    src="{{ $ver->user_verification->cnic_back_picture }}"
                                                                    alt="cnic_back_picture Card" class="img-fluid"></li>
                                                            <li><strong>Cnic Holding Selfie:</strong> <img
                                                                    src="{{ $ver->user_verification->cnic_holding_selfie }}"
                                                                    alt="cnic_back_picture Card" class="img-fluid"></li>
                                                        </ul>
                                                    @endif
                                                    <!-- Account Information -->
                                                    <h5>Account Information:</h5>
                                                    <ul>
                                                        <li><strong>Type:</strong> {{ $ver->type }}</li>
                                                        <li><strong>Seller Type:</strong> {{ $ver->seller_type }}</li>
                                                        <li><strong>Terms Accepted:</strong>
                                                            {{ $ver->terms == 1 ? 'Yes' : 'No' }}</li>
                                                        <li><strong>Created At:</strong> {{ $ver->created_at }}</li>
                                                        <li><strong>Updated At:</strong> {{ $ver->updated_at }}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <form method="POST" action="{{ route('verification.reject') }}">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $ver->id }}">
                                                    <button type="submit" class="btn btn-secondary">Reject</button>
                                                </form>
                                                <form method="POST" action="{{ route('verification.approve') }}">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $ver->id }}">
                                                    <button type="submit" class="btn btn-primary">Approve</button>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Include Bootstrap CSS (e.g., in your layout) -->





        </div>
    </div>
@endsection
@section('additionScript')
    <script>
        $(document).ready(function() {
            function updateVerificationForm() {
                if ($('#seller_type').val() === 'Shop Keeper') { // Check if 'Shop Keeper' is selected
                    $('.shopKeeper').removeClass('d-none'); // Show the shopKeeper div
                } else {
                    $('.shopKeeper').addClass('d-none'); // Hide the shopKeeper div
                }
            }

            $('#seller_type').on('change', updateVerificationForm); // Pass the function reference
            updateVerificationForm(); // Initialize the form on page load
        });
    </script>
@endsection
