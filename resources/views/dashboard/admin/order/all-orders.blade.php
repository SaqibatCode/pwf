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
                        <h4 class="mb-0 font-size-18">All Orders (Admin View)</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Playware</a></li>
                                <li class="breadcrumb-item active">Orders</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Order Id</th>
                                <th>Product Name</th>
                                <th>Product SKU</th>
                                <th>Seller</th>
                                <th>Quantity</th>
                                <th>Buyer Name</th>
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
                                    <tr>
                                        <td> {{ $chorder->order_id }}</td>
                                        <td>{{ $chorder->product->product_name }}</td>
                                        <td>{{ $chorder->product->sku }}</td>
                                        <td>{{ $chorder->seller->first_name }} {{ $chorder->seller->last_name }}</td>
                                        <td>{{ $chorder->quantity }}</td>
                                        <td>{{ $order->user->first_name }} {{ $order->user->last_name }}</td>
                                        <td>{{ $order->address }}</td>
                                        <td>{{ $order->email }}</td>
                                        <td>{{ $order->phone }}</td>
                                        <td> {{ $chorder->created_at->format('Y-m-d') }}</td>
                                        <td> {{ $chorder->status }}</td>
                                        <td> {{ $chorder->payment_type }}</td>
                                        <td>
                                            @if ($chorder->payment_type == 'Online')
                                                {{-- Online Payment Workflow --}}
                                                @if ($chorder->payment_screenshot)
                                                    <button class="btn btn-sm btn-outline-primary open-modal-btn"
                                                        data-toggle="modal" data-target="#imageModal"
                                                        data-image-url="{{ asset($chorder->payment_screenshot) }}">
                                                        View Image
                                                    </button>
                                                @else
                                                    <span class="text-muted">No Screenshot</span>
                                                @endif
                                            @endif

                                            <form action="{{ route('orders.status.update', $chorder->id) }}"
                                                class="d-inline" method="POST">
                                                @csrf
                                                <select name="status" class="form-control form-control-sm">
                                                    <option value="Pending Approval"
                                                        @if ($chorder->status == 'Pending Approval') selected @endif>Pending Approval
                                                    </option>
                                                    <option value="Payment Received"
                                                        @if ($chorder->status == 'Payment Received') selected @endif>Payment Received
                                                    </option>
                                                    <option value="Order Dispatched"
                                                        @if ($chorder->status == 'Order Dispatched') selected @endif>Order Dispatched
                                                    </option>

                                                    <option value="Delivered & Completed"
                                                        @if ($chorder->status == 'Delivered & Completed') selected @endif>Delivered &
                                                        Completed</option>


                                                </select>
                                                <button class="btn sm btn-info" type="submit">Update</button>
                                            </form>


                                        </td>
                                    </tr>
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
