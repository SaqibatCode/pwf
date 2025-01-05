@extends('dashboard.layout.layout')

@section('pageTitle', 'Manage Attributes')

@section('main-content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Attributes</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Attributes</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add New Attribute -->
        <a href="{{ route('attribute.create') }}" class="btn btn-primary mb-3">Add New Attribute</a>

        <!-- Attributes Table -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attributes as $attribute)
                    <tr>
                        <td>{{ $attribute->name }}</td>
                        <td>{{ $attribute->type }}</td>
                        <td>
                            <a href="{{ route('attribute.edit', $attribute->id) }}" class="btn btn-warning btn-sm">Manage</a>
                            <form action="{{ route('attribute.destroy', $attribute->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                            <a href="{{ route('attribute.assignCategory', $attribute->id) }}" class="btn btn-info btn-sm">Assign to Category</a>
                            <a href="{{ route('attribute.manageValues', $attribute->id) }}">Manage Values</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $attributes->links() }}
    </div>
</div>
@endsection
