@extends('dashboard.layout.layout')

@section('pageTitle', 'Edit Attribute')

@section('main-content')
<div class="page-content">
    <div class="container-fluid">

        <h4>Edit Attribute</h4>

        <form action="{{ route('attribute.update', $attribute->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Attribute Name</label>
                <input type="text" name="name" class="form-control" value="{{ $attribute->name }}" required>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Attribute Type</label>
                <input type="text" name="type" class="form-control" value="{{ $attribute->type }}" required>
            </div>
            <button type="submit" class="btn btn-success">Update Attribute</button>
        </form>

    </div>
</div>
@endsection
