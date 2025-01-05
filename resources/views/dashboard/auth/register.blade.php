<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Register - Playware</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- App css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/theme.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Flatpickr CSS (CDN) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
    <!-- (Optional) Bootstrap 5 theme for Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/bootstrap5/bootstrap5.min.css" />
</head>

<body class="bg-primary">

    <div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex align-items-center min-vh-100">
                        <div class="w-100 d-block my-5">
                            <div class="row justify-content-center">
                                <div class="col-md-8 col-lg-5">
                                    <div class="card">
                                        <div class="card-body p-4">
                                            <div class="text-center w-75 mx-auto auth-logo mb-4">
                                                <a class="logo-light" href="#">
                                                    <span><img src="assets/images/logo/logo.svg" alt=""
                                                            height="40"></span>
                                                </a>
                                            </div>
                                            <form action="{{ route('store.seller') }}" method="POST">
                                                @csrf
                                                @if ($errors->any())
                                                    <div class="alert alert-danger">
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                                <!-- First Name -->
                                                <div class="mb-3">
                                                    <label for="first_name" class="form-label">First Name</label>
                                                    <input type="text"
                                                        class="form-control @error('first_name') is-invalid @enderror"
                                                        id="first_name" name="first_name"
                                                        placeholder="Enter your first name"
                                                        value="{{ old('first_name') }}" required />
                                                    @error('first_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Last Name -->
                                                <div class="mb-3">
                                                    <label for="last_name" class="form-label">Last Name</label>
                                                    <input type="text"
                                                        class="form-control @error('last_name') is-invalid @enderror"
                                                        id="last_name" name="last_name"
                                                        placeholder="Enter your last name" value="{{ old('last_name') }}"
                                                        required />
                                                    @error('last_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Father Name -->
                                                <div class="mb-3">
                                                    <label for="father_name" class="form-label">Father Name</label>
                                                    <input type="text"
                                                        class="form-control @error('father_name') is-invalid @enderror"
                                                        id="father_name" name="father_name"
                                                        placeholder="Enter your father's name"
                                                        value="{{ old('father_name') }}" required />
                                                    @error('father_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Email -->
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        id="email" name="email" placeholder="example@domain.com"
                                                        value="{{ old('email') }}" required />
                                                    @error('email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Date Of Birth (Using Flatpickr) -->
                                                <div class="mb-3">
                                                    <label for="dob" class="form-label">Date Of Birth</label>
                                                    <input type="text"
                                                        class="form-control @error('dob') is-invalid @enderror"
                                                        id="dob" name="dob" placeholder="DD/MM/YYYY"
                                                        value="{{ old('dob') }}" required />
                                                    @error('dob')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- CNIC Number -->
                                                <div class="mb-3">
                                                    <label for="cnic" class="form-label">CNIC Number</label>
                                                    <input type="text"
                                                        class="form-control @error('cnic') is-invalid @enderror"
                                                        id="cnic" name="cnic"
                                                        placeholder="Enter your CNIC number"
                                                        value="{{ old('cnic') }}" required />
                                                    @error('cnic')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Phone Number (Format: +92-315-853-9620) -->
                                                <div class="mb-3">
                                                    <label for="phone" class="form-label">Phone Number</label>
                                                    <input type="tel"
                                                        class="form-control @error('phone') is-invalid @enderror"
                                                        id="phone" name="phone" placeholder="+92-315-853-9620"
                                                        pattern="^\+92-\d{3}-\d{3}-\d{4}$"
                                                        value="{{ old('phone') }}" required />
                                                    <div class="form-text">
                                                        Enter your phone number in the format
                                                        <code>+92-XXX-XXX-XXXX</code>.
                                                    </div>
                                                    @error('phone')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Address -->
                                                <div class="mb-3">
                                                    <label for="address" class="form-label">Address</label>
                                                    <input type="text"
                                                        class="form-control @error('address') is-invalid @enderror"
                                                        id="address" name="address"
                                                        placeholder="Enter your address" value="{{ old('address') }}"
                                                        required />
                                                    @error('address')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>


                                                <!-- Password -->
                                                <div class="mb-3">
                                                    <label for="password" class="form-label">Password</label>
                                                    <input type="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        id="password" name="password"
                                                        placeholder="Enter your password"
                                                        value="{{ old('password') }}" required />
                                                    @error('password')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>


                                                <!-- Terms and Conditions -->
                                                <div class="mb-3 form-check">
                                                    <input type="checkbox"
                                                        class="form-check-input @error('terms') is-invalid @enderror"
                                                        id="terms" name="terms"
                                                        {{ old('terms') ? 'checked' : '' }} required />
                                                    <label for="terms" class="form-check-label">
                                                        I accept the terms and conditions.
                                                    </label>
                                                    @error('terms')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Submit Button -->
                                                <button type="submit" class="btn btn-primary">Register</button>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->
                        </div> <!-- end .w-100 -->
                    </div> <!-- end .d-flex -->
                </div> <!-- end col-->
            </div> <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <!-- jQuery  -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/metismenu.min.js') }}"></script>
    <script src="{{ asset('assets/js/waves.js') }}"></script>
    <script src="{{ asset('assets/js/simplebar.min.js') }}"></script>

    <!-- Flatpickr JS (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr('#dob', {
                dateFormat: 'd/m/Y', // day-month-year
                allowInput: true, // allows manual typing
            });
        });
    </script>
    <!-- App js -->
    <script src="{{ asset('assets/js/theme.js') }}"></script>

</body>

</html>
