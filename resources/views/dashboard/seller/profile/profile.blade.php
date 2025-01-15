@extends('dashboard.layout.layout')
@section('pageTitle')
    Seller Profile
@endsection
@section('main-content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Seller Profile</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Playware</a></li>
                                <li class="breadcrumb-item active">Seller Profile</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
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
                    <div class="container">
                        <h2>Update Profile</h2>
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @elseif(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="profile-header">
                            @if ($user->userProfile && $user->userProfile->cover_photo)
                                <img src="{{ asset($user->userProfile->cover_photo) }}" class="cover-photo"
                                    alt="Cover Photo">
                            @endif
                            @if ($user->userProfile && $user->userProfile->profile_photo)
                                <img src="{{ asset($user->userProfile->profile_photo) }}" class="profile-picture"
                                    alt="Profile Picture">
                            @endif

                        </div>
                        <form action="{{ route('profile.update') }}" class="form mt-5" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- First Name -->
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" name="first_name" class="form-control"
                                    value="{{ old('first_name', $user->first_name) }}" required>
                            </div>

                            <!-- Last Name -->
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" name="last_name" class="form-control"
                                    value="{{ old('last_name', $user->last_name) }}" required>
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', $user->email) }}" required>
                            </div>

                            <!-- Description -->
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control">{{ old('description', $user->userProfile->seller_description ?? '') }}</textarea>
                            </div>

                            <!-- Profile Picture Upload -->
                            <div class="form-group">
                                <label for="profile_photo">Profile Picture</label>
                                <input type="file" name="profile_photo" id="profile_picture" />

                            </div>

                            <!-- Cover Photo Upload -->
                            <div class="form-group">
                                <label for="cover_photo">Cover Photo</label>
                                <input type="file" name="cover_photo" id="cover_photo" />

                            </div>

                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </form>
                    </div>
                    <div class="container mt-5">
                        <h3>Payment Methods</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Bank Name</th>
                                    <th>Account Number</th>
                                    <th>Branch Code</th>
                                    <th>IBAN</th>
                                    <th>Account Title</th>
                                    <th>Swift Code</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!$user->payment_methods->isEmpty())
                                    @foreach ($user->payment_methods as $method)
                                        <tr>
                                            <td>{{ $method->bank_name }}</td>
                                            <td>{{ $method->account_number }}</td>
                                            <td>{{ $method->branch_code }}</td>
                                            <td>{{ $method->iban }}</td>
                                            <td>{{ $method->account_title }}</td>
                                            <td>{{ $method->swift_code }}</td>
                                            <td>
                                                <form action="{{ route('payment_methods.destroy', $method->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this payment method?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7">No Payment Methods Added.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                        @if (Auth::user()->type == 'seller')
                            <button class="btn btn-primary" id="add_new_method">Add New Method</button>
                        @endif

                        <form action="{{ route('payment_methods.store') }}" method="POST" id="pMtd" class="form"
                            style="display:none;">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="bank_name" class="form-label">Bank Name</label>
                                    <input type="text" name="bank_name" class="form-control" id="bank_name">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="account_number" class="form-label">Account Number</label>
                                    <input type="text" name="account_number" class="form-control" id="account_number">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="branch_code" class="form-label">Branch Code</label>
                                    <input type="text" name="branch_code" class="form-control" id="branch_code">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="iban" class="form-label">IBAN</label>
                                    <input type="text" name="iban" class="form-control" id="iban">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="account_title" class="form-label">Account Title</label>
                                    <input type="text" name="account_title" class="form-control" id="account_title">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="swift_code" class="form-label">Swift Code</label>
                                    <input type="text" name="swift_code" class="form-control" id="swift_code">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">Add Payment Method</button>
                        </form>
                    </div>

                    <script>
                        document.getElementById('add_new_method').addEventListener('click', function() {
                            document.getElementById('pMtd').style.display = 'block';
                        });
                    </script>


                </div>
            </div>
        </div>
    </div>
@endsection
