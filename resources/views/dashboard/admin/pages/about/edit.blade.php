{{-- resources/views/admin/about/edit.blade.php --}}
@extends('dashboard.layout.layout')
@section('pageTitle')
    Edit About Us
@endsection
@section('main-content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Edit About Us Content</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                                <li class="breadcrumb-item active">About Us</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                 <div class="col-md-12">
                     <form action="{{ route('admin.about.update') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="content" class="font-medium text-gray-700">Content</label>
                             <textarea name="content" id="content" rows="10"
                                class="form-control @error('content') is-invalid @enderror">{!!
                            $about->content ?? '' !!}</textarea>
                             @error('content')
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
