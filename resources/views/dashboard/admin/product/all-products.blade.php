@extends('dashboard.layout.layout')
@section('pageTitle')
    Admin Dashboard
@endsection
@section('main-content')
    <div class="page-content">
        <div class="container-fluid">



            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Add Products</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Playware</a></li>
                                <li class="breadcrumb-item active">Products</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>

            <form method="GET" action="{{ url()->current() }}" class="mb-3">
                <div class="row">
                    <div class="col-md-3">
                        <input type="text" name="seller_name" id="seller_name" placeholder="Seller Name"
                            class="form-control">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="seller_phone" id="seller_phone" placeholder="Seller Name"
                            class="form-control">
                    </div>

                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ url()->current() }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>

            <div class="row">
                <div class="col-md-12">
                    <h2>All Products</h2>
                    <table class="table table-stripped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>Seller Name</th>
                                <th>Seller Phone Number</th>
                                <th>Stock</th>
                                <th>Sku</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product as $pro)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($pro->pictures->isNotEmpty())
                                            <img src="{{ asset($pro->pictures->first()->image) }}" alt="Product Image"
                                                width="100">
                                        @else
                                            <span>No Image</span>
                                        @endif
                                    </td>
                                    <td>{{ $pro->product_name }}</td>
                                    <td>Rs.
                                        @if (!is_null($pro->sale_price))
                                            <!-- Check if sale_price is not null -->
                                            {{ $pro->sale_price }}
                                        @else
                                            {{ $pro->price }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($pro->category)
                                            {{ $pro->category->name }}
                                        @else
                                            Complete Pc Build
                                        @endif
                                    </td>
                                    <td>
                                        {{ $pro->user->first_name }} {{ $pro->user->last_name }}
                                    </td>
                                    <td>
                                        {{ $pro->user->phone }}
                                    </td>
                                    <td>
                                        {{ $pro->stock_quanity }}
                                    </td>
                                    <td>
                                        {{ $pro->sku }}
                                    </td>
                                    <td>
                                        {{ $pro->status }}
                                    </td>
                                    <td>
                                        <a class="btn btn-info" href="{{ route('show.product', $pro->slug) }}">View Product</a>
                                        <a
                                            href="
                                            @if ($pro->product_type == 'new') {{ route('product.edit', $pro->id) }}
                                            @elseif($pro->product_type == 'used')
                                                {{ route('product.used.edit', $pro->id) }}
                                            @elseif($pro->product_type == 'complete_pc')
                                                {{ route('product.complete.pc.edit', $pro->id) }}
                                            @elseif($pro->product_type == 'laptop')
                                                TEST @endif
                                        "><button
                                                class="btn btn-primary">Edit</button></a>
                                        <form class="d-inline" action="{{ route('product.destroy', $pro->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this product?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                        @if ($pro->status !== 'approved')
                                            <form action="{{ route('admin.approve.product', $pro->id) }}" method="POST"
                                                style="display:inline;"
                                                onsubmit="return confirm('Are you sure you want to Approve this product?');">
                                                @csrf
                                                <button type="submit" class="btn btn-success">Approve</button>
                                            </form>
                                        @endif

                                        <!-- Reject Button -->
                                        @if ($pro->status !== 'rejected')
                                            <form action="{{ route('admin.reject.product', $pro->id) }}" method="POST"
                                                style="display:inline;"
                                                onsubmit="return confirm('Are you sure you want to Reject this product?');">
                                                @csrf
                                                <button type="submit" class="btn btn-warning">Reject</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $product->links('pagination::bootstrap-4') }}

                </div>
            </div>
        </div>
    </div>
@endsection
