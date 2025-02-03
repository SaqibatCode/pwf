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
                        <h4 class="mb-0 font-size-18">All Orders</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Playware</a></li>
                                <li class="breadcrumb-item active">Orders</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            {{-- Display success message --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Display error message --}}
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Order Id</th>
                                <th>Product Name</th>
                                <th>Product SKU</th>
                                <th>Quantity</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Order Date</th>
                                <th>Order Status</th>
                                <th>Payment Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                @foreach ($order->childOrders as $chorder)
                                    @if ($chorder->seller_id == Auth::user()->id)
                                        <tr>
                                            <td> {{ $chorder->order_id }}</td>
                                            <td>{{ $chorder->product->product_name }}</td>
                                            <td>{{ $chorder->product->sku }}</td>
                                            <td>{{ $chorder->quantity }}</td>
                                            <td>{{ $order->user->first_name }} {{ $order->user->last_name }}</td>
                                            <td>{{ $order->address }}</td>
                                            <td>{{ $order->email }}</td>
                                            <td>{{ $order->phone }}</td>
                                            <td> {{ $chorder->created_at->format('Y-m-d') }}</td>
                                            <td> {{ $chorder->status }}</td>
                                            <td> {{ $chorder->payment_type }}</td>
                                            <td>
                                                @if ($chorder->seller->verification !== 'Unverified' && $chorder->seller->verification !== 'Pending')
                                                    @if ($chorder->payment_type == 'Online')
                                                        {{-- Online Payment Workflow --}}
                                                        @if ($chorder->payment_screenshot)
                                                            @if ($chorder->status !== 'Delivered & Completed')
                                                                @if ($chorder->status !== 'Order Dispatched')
                                                                    <button
                                                                        class="btn btn-sm btn-outline-primary open-modal-btn"
                                                                        data-toggle="modal" data-target="#imageModal"
                                                                        data-image-url="{{ asset($chorder->payment_screenshot) }}">
                                                                        View Image
                                                                    </button>
                                                                @else
                                                                    Waiting for Buyer to Confirm Order Received. If no
                                                                    confirmation is received within 10 days, the order will
                                                                    be automatically marked as completed.
                                                                @endif
                                                            @else
                                                                Order Completed
                                                            @endif
                                                            @if ($chorder->status == 'Pending Approval')
                                                                <form
                                                                    action="{{ route('orders.payment.received', $chorder->id) }}"
                                                                    class="d-inline" method="POST">
                                                                    @csrf
                                                                    <button class="btn sm btn-info" type="submit">Payment
                                                                        Received</button>
                                                                </form>
                                                            @elseif ($chorder->status == 'Payment Received')
                                                                <form action="{{ route('orders.dispatch', $chorder->id) }}"
                                                                    class="d-inline" method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <input type="text" name="tracking_id"
                                                                        placeholder="Enter Order Tracking Id" required>
                                                                    <input type="file" name="tracking_img" required>
                                                                    <button class="btn sm btn-info" type="submit">Dispatch
                                                                        Order</button>
                                                                </form>
                                                            @endif
                                                        @else
                                                            <span class="text-muted">No Screenshot</span>
                                                        @endif
                                                    @elseif ($chorder->payment_type == 'COD')
                                                        {{-- COD Workflow --}}
                                                        @if ($chorder->seller->verification == 'Verified')
                                                            {{-- Verified Sellers Only --}}
                                                            @if ($chorder->status == 'Pending Approval')
                                                                <form action="{{ route('orders.dispatch', $chorder->id) }}"
                                                                    class="d-inline" method="POST">
                                                                    @csrf
                                                                    <input type="text" name="tracking_id"
                                                                        placeholder="Enter Order Tracking Id" required>
                                                                    <button class="btn sm btn-info" type="submit">Dispatch
                                                                        Order</button>
                                                                </form>
                                                            @elseif ($chorder->status == 'Payment Received')
                                                                <form action="{{ route('orders.dispatch', $chorder->id) }}"
                                                                    class="d-inline" method="POST"
                                                                    enctype="multipart/form-data">
                                                                    @csrf
                                                                    <input type="text" name="tracking_id"
                                                                        placeholder="Enter Order Tracking Id" required>
                                                                    <input type="text" name="tracking_img" required>
                                                                    <button class="btn sm btn-info" type="submit">Dispatch
                                                                        Order</button>
                                                                </form>
                                                            @elseif ($chorder->status == 'Order Dispatched')
                                                                <p>Waiting for Buyer to Confirm Order Received. If no
                                                                    confirmation is received within 10 days, the order will
                                                                    be automatically marked as completed.</p>
                                                            @elseif ($chorder->status == 'Delivered & Completed')
                                                                <p>Order Completed</p>
                                                            @endif
                                                        @else
                                                            {{-- Unverified or Pending Sellers --}}
                                                            <p>COD Orders are only available for verified sellers. Please
                                                                verify your account to access this feature.</p>
                                                            <a href="{{ route('verification') }}">Verify Yourself to Start
                                                                Receiving Orders</a>
                                                        @endif
                                                    @endif
                                                @else
                                                    {{-- General Message for Unverified Sellers --}}
                                                    <p>Waiting for Admin to Approve Verification</p>
                                                    <a href="{{ route('verification') }}">Verify Yourself to Start
                                                        Receiving Orders</a>
                                                @endif
                                            </td>



                                        </tr>
                                    @endif
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>

                    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="imageModalLabel">Payment Screenshot</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <img id="modal-image" src="" alt="Product Image"
                                        style="max-width: 100%; display:block;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('additionScript')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('imageModal'); // Get the modal id
            const modalImage = document.getElementById('modal-image'); // Get image id
            const openButtons = document.querySelectorAll('.open-modal-btn');

            openButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    const imageUrl = this.getAttribute('data-image-url');
                    modalImage.src = imageUrl; // set modal image source
                });
            });

            // Use the "hidden.bs.modal" for Bootstrap 4 as well
            $(modal).on('hidden.bs.modal', function() {
                modalImage.src = ""; // Reset the src to hide the previous image.
            });
        });
    </script>
@endsection
