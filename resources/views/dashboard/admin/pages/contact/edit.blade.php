{{-- resources/views/admin/contact/edit.blade.php --}}
@extends('dashboard.layout.layout')
@section('pageTitle')
    Edit Contact Us
@endsection
@section('main-content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Edit Contact Us Information</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                                <li class="breadcrumb-item active">Contact Us</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
             <div class="row">
                 <div class="col-md-12">
                     <form action="{{ route('admin.contact.update') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="address" class="font-medium text-gray-700">Address</label>
                            <textarea name="address" id="address" rows="3"
                                class="form-control @error('address') is-invalid @enderror">{!!
                                $contact->address ?? '' !!}</textarea>
                            @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone" class="font-medium text-gray-700">Phone Number</label>
                            <input type="text" name="phone" id="phone"
                                class="form-control @error('phone') is-invalid @enderror"
                                value="{{ $contact->phone ?? '' }}">
                            @error('phone')
                             <div class="invalid-feedback">{{ $message }}</div>
                             @enderror
                        </div>
                        <div class="form-group">
                            <label for="email" class="font-medium text-gray-700">Email Address</label>
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ $contact->email ?? '' }}">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                     </form>
                 </div>
             </div>
        </div>
    </div>
@endsection
