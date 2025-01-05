@extends('dashboard.layout.layout')
@section('pageTitle')
    Brand Dashboard
@endsection
@section('main-content')
    <div class="page-content">
        <div class="container-fluid">


            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Brand</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Playware</a></li>
                                <li class="breadcrumb-item active">Brand</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <h2>Add New Brand</h2>
                    <form action="{{ route('brand.add') }}" method="POST" enctype="multipart/form-data">
                        @csrf
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
                            <input type="file" name="image" id="image" accept="image/*" class="form-control">
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Brand Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="form-control">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-6">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Brand Name</th>
                                <th>Brand Slug</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($brands as $cat)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td><img src="{{ asset($cat->image) }}" width="100" class="img-fluid" alt="">
                                    </td>
                                    <td>{{ $cat->name }}</td>
                                    <td>{{ $cat->slug }}</td>
                                    <td>
                                        <a href="{{ route('brand.edit', $cat->slug) }}"> <button type="button"
                                                class="btn btn-primary" data-toggle="modal"
                                                data-target="#exampleModalCenter{{ $cat->id }}">Edit</button></a>
                                        <form action="{{ route('brand.delete', $cat->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this brand?')">Delete</button>
                                        </form>


                                    </td>
                                </tr>
                            @endforeach

                        </tbody>

                    </table>
                    <div class="pagination">
                        {{ $brands->onEachSide(1)->links('pagination::simple-bootstrap-4') }}
                    </div>

                </div>

            </div>

        </div>

    </div>
    </div>
@endsection
