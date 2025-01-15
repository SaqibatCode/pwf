{{-- resources/views/dashboard/admin/sliders/edit.blade.php --}}
@extends('dashboard.layout.layout')

@section('pageTitle')
    Edit Slider
@endsection

@section('main-content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Edit Slider</h4>
                         <div class="page-title-right">
                             <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                                 <li class="breadcrumb-item active">Sliders</li>
                            </ol>
                        </div>
                     </div>
                 </div>
             </div>
             <div class="row">
                 <div class="col-md-12">
                     <form action="{{ route('slider.update', $homePageSlider) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            @method('PUT')
                         <div class="form-group">
                            <label for="sub_heading" class="font-medium text-gray-700">Sub Heading</label>
                             <input type="text" name="sub_heading" id="sub_heading" class="form-control" value="{{ old('sub_heading', $homePageSlider->sub_heading) }}">
                          </div>
                         <div class="form-group">
                              <label for="heading" class="font-medium text-gray-700">Heading</label>
                              <input type="text" name="heading" id="heading" class="form-control @error('heading') is-invalid @enderror" value="{{ old('heading', $homePageSlider->heading) }}" required>
                             @error('heading')
                                 <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                         </div>
                         <div class="form-group">
                            <label for="description" class="font-medium text-gray-700">Description</label>
                             <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $homePageSlider->description) }}</textarea>
                             @error('description')
                                 <div class="invalid-feedback">{{ $message }}</div>
                             @enderror
                         </div>
                         <div class="form-group">
                             <label for="another_heading" class="font-medium text-gray-700">Another Heading</label>
                              <input type="text" name="another_heading" id="another_heading" class="form-control" value="{{ old('another_heading', $homePageSlider->another_heading) }}">
                         </div>
                         <div class="form-group">
                            <label for="button_text" class="font-medium text-gray-700">Button Text</label>
                           <input type="text" name="button_text" id="button_text" class="form-control @error('button_text') is-invalid @enderror" value="{{ old('button_text', $homePageSlider->button_text) }}" required>
                           @error('button_text')
                              <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                             <label for="button_url" class="font-medium text-gray-700">Button Url</label>
                            <input type="text" name="button_url" id="button_url" class="form-control @error('button_url') is-invalid @enderror" value="{{ old('button_url', $homePageSlider->button_url) }}" required>
                            @error('button_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                         <div class="form-group">
                            <label for="image_desktop" class="font-medium text-gray-700">Desktop Image</label>
                            <input type="file" name="image_desktop" id="image_desktop" class="form-control-file @error('image_desktop') is-invalid @enderror">
                             @error('image_desktop')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if($homePageSlider->image_desktop)
                                  <img src="{{ asset($homePageSlider->image_desktop) }}" alt="Current Desktop Image" width="100">
                            @endif
                         </div>
                        <div class="form-group">
                            <label for="image_mobile" class="font-medium text-gray-700">Mobile Image</label>
                             <input type="file" name="image_mobile" id="image_mobile" class="form-control-file  @error('image_mobile') is-invalid @enderror">
                             @error('image_mobile')
                               <div class="invalid-feedback">{{ $message }}</div>
                           @enderror
                            @if($homePageSlider->image_mobile)
                                   <img src="{{ asset($homePageSlider->image_mobile) }}" alt="Current Mobile Image" width="100">
                            @endif
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">Update Slider</button>
                           <a href="{{ route('slider.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                 </div>
             </div>
        </div>
     </div>
 @endsection
