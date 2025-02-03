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

            <!-- Filter Form -->
            <form method="GET" action="{{ route('admin.all.orders') }}" class="mb-3">
                <div class="row">
                    <div class="col-md-3">
                        <input type="text" name="seller_name" id="seller_name" placeholder="Seller Name"
                            class="form-control" value="{{ request('seller_name') }}">
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="date_from" id="date_from" class="form-control"
                            value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="date_to" id="date_to" class="form-control"
                            value="{{ request('date_to') }}">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('admin.all.orders') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>

            <!-- Export Button -->
            <!-- Export Button -->
            <button id="exportBtn" class="btn btn-success mb-3">Export to CSV</button>


            <!-- Orders Table -->
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
                                <th>Price</th>
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

                    {{ $orders->links() }}
                </div>
            </div>

        </div>
    </div>
@endsection

@section('additionScript')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modal-image');
            const openButtons = document.querySelectorAll('.open-modal-btn');

            openButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    const imageUrl = this.getAttribute('data-image-url');
                    modalImage.src = imageUrl;
                });
            });

            $(modal).on('hidden.bs.modal', function() {
                modalImage.src = "";
            });
        });
    </script>

    <script>
        document.getElementById('exportBtn').addEventListener('click', function() {
            // Get the table
            const table = document.querySelector('table');

            // Prepare the CSV content
            let csvContent =
                "Order Id,Product Name,Product SKU,Seller,Quantity,Buyer Name,Address,Email,Phone,Order Date,Order Status,Payment Type\n";

            // Loop through each row and extract data
            const rows = table.querySelectorAll('tr');
            rows.forEach((row, index) => {
                const cols = row.querySelectorAll('td, th');
                const rowData = [];
                cols.forEach(col => {
                    rowData.push(col.innerText.replace(/\n/g, '')
                .trim()); // Remove extra spaces and newlines
                });
                if (rowData.length > 0) {
                    csvContent += rowData.join(',') + "\n";
                }
            });

            // Create a temporary link to download the CSV file
            const link = document.createElement('a');
            link.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csvContent);
            link.target = '_blank';
            link.download = 'orders.csv';

            // Trigger the download
            link.click();
        });
    </script>
@endsection
