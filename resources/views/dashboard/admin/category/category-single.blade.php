@extends('dashboard.layout.layout')
@section('pageTitle')
    Category Dashboard
@endsection
@section('main-content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <div class="page-content">
        <div class="container-fluid">


            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Category</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Playware</a></li>
                                <li class="breadcrumb-item active">Category</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-5">
                    <h2>Edit Category</h2>
                    <form action="{{ route('category.update', $category[0]->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Make sure you use the PUT method for updates -->

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Category Picture -->
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <img class="d-block" src="{{ asset($category[0]->image) }}" width="100" alt="">
                            <input type="file" name="image" id="image" accept="image/*" class="form-control">
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Category Name</label>
                            <input type="text" name="name" id="name" value="{{ $category[0]->name }}"
                                class="form-control">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>


                    <div class="row mt-5">
                        <div class="col-md-12">
                            <h2>Add Brands</h2>
                            <form action="{{ route('category.update.brand') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $category[0]->id }}">
                                <div class="form-group">
                                    <select name="brands[]" class="form-control" id="brand-select" multiple>
                                        @foreach ($availableBrands as $brand)
                                            <option value="{{ $brand->id }}"
                                                @if ($category[0]->brands->contains($brand)) selected @endif>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <input class="btn btn-primary" type="submit" value="Add Brand">
                            </form>
                        </div>
                    </div>
                </div>







                <div class="col-md-1"></div>
                <div class="col-md-6">
                    <h2>Assigned Brands</h2>
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Category Name</th>
                                <th>Category Slug</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($category[0]->brands as $cat)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td><img src="{{ asset($cat->image) }}" width="100" class="img-fluid"
                                            alt="">
                                    </td>
                                    <td>{{ $cat->name }}</td>
                                    <td>{{ $cat->slug }}</td>
                                    <td>
                                        <form action="{{ route('category.remove.brand', [$category[0]->id, $cat->id]) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to remove this brand?')"
                                                class="btn btn-danger">Delete</button>
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
@section('additionScript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#brand-select').select2({
                placeholder: "Select brands",
                allowClear: true
            });
        });
    </script>
@endsection
