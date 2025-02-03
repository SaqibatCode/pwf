@extends('dashboard.layout.layout')

@section('pageTitle', 'Bank Details')

@section('main-content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">All Bank Details</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Playware</a></li>
                                <li class="breadcrumb-item active">All Bank Details</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ route('admin.bank_details.create') }}" class="btn btn-primary mb-3">Add Bank Detail</a>

            <div class="row">
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Bank Name</th>
                                <th>Account Number</th>
                                <th>Account Title</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bankDetails as $bankDetail)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $bankDetail->bank_name }}</td>
                                    <td>{{ $bankDetail->account_number }}</td>
                                    <td>{{ $bankDetail->account_title }}</td>
                                    <td>
                                        <a href="{{ route('admin.bank_details.edit', $bankDetail->id) }}" class="btn btn-warning">Edit</a>
                                        <form method="POST" action="{{ route('admin.bank_details.destroy', $bankDetail->id) }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
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
@endsection
