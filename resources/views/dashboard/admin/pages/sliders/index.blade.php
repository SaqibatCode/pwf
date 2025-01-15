{{-- resources/views/dashboard/admin/sliders/index.blade.php --}}
@extends('dashboard.layout.layout')

@section('pageTitle')
    Home Page Sliders
@endsection

@section('main-content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Home Page Sliders</h4>

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
                     <div class="mb-3">
                          <a href="{{ route('slider.create') }}" class="btn btn-primary">Add New Slider</a>
                     </div>

                     @if(session('success'))
                         <div class="alert alert-success">{{ session('success') }}</div>
                     @endif

                     <div class="table-responsive">
                         <table class="table">
                             <thead>
                                 <tr>
                                     <th>ID</th>
                                     <th>Sub Heading</th>
                                     <th>Heading</th>
                                     <th>Description</th>
                                     <th>Another Heading</th>
                                     <th>Button Text</th>
                                      <th>Button Url</th>
                                     <th>Desktop Image</th>
                                     <th>Mobile Image</th>
                                     <th>Actions</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 @foreach($sliders as $slider)
                                     <tr>
                                         <td>{{ $slider->id }}</td>
                                          <td>{{ $slider->sub_heading }}</td>
                                         <td>{{ $slider->heading }}</td>
                                         <td>{{ $slider->description }}</td>
                                         <td>{{ $slider->another_heading }}</td>
                                          <td>{{ $slider->button_text }}</td>
                                          <td>{{ $slider->button_url }}</td>
                                         <td>
                                             <img src="{{ asset($slider->image_desktop) }}" alt="Desktop Image" width="100">
                                         </td>
                                         <td>
                                             <img src="{{ asset($slider->image_mobile) }}" alt="Mobile Image" width="100">
                                         </td>
                                         <td>
                                             <a href="{{ route('slider.edit', $slider) }}" class="btn btn-sm btn-secondary">Edit</a>
                                              <form action="{{ route('slider.destroy', $slider) }}" method="POST" style="display: inline-block;">
                                                     @csrf
                                                     @method('DELETE')
                                                     <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this slider?')">Delete</button>
                                             </form>
                                         </td>
                                     </tr>
                                 @endforeach
                             </tbody>
                         </table>
                     </div>
                </div>
            </div>
        </div>
    </div>
@endsection
