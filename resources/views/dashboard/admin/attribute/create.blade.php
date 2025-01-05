@extends('dashboard.layout.layout')

@section('pageTitle', 'Create Attribute')

@section('main-content')
<div class="page-content">
    <div class="container-fluid">

        <h4>Create New Attribute</h4>

        <form action="{{ route('attribute.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Attribute Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Attribute Type</label>
                <input type="text" name="type" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Create Attribute</button>
        </form>

    </div>
</div>
@endsection
