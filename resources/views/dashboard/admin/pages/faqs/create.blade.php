{{-- resources/views/admin/faqs/create.blade.php --}}
@extends('dashboard.layout.layout')
@section('pageTitle')
    Create New FAQ
@endsection
@section('main-content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Create New FAQ</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                                <li class="breadcrumb-item active">FAQs</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                     <form action="{{ route('admin.faqs.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="form-group">
                            <label for="question" class="font-medium text-gray-700">Question</label>
                            <textarea name="question" id="question" rows="3"
                                class="form-control @error('question') is-invalid @enderror">{{ old('question') }}</textarea>
                            @error('question')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="answer" class="font-medium text-gray-700">Answer</label>
                             <textarea name="answer" id="answer" rows="5"
                                class="form-control @error('answer') is-invalid @enderror">{{ old('answer') }}</textarea>
                            @error('answer')
                             <div class="invalid-feedback">{{ $message }}</div>
                             @enderror
                        </div>
                        <div>
                             <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                     </form>
                </div>
            </div>
        </div>
    </div>
@endsection
