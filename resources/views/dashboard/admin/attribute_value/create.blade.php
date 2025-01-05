@extends('dashboard.layout.layout')

@section('pageTitle', 'Assign Attribute to Category')

@section('main-content')
<div class="page-content">
    <div class="container-fluid">

        <h4>Assign Attribute: {{ $attribute->name }} to Categories</h4>

        <form action="{{ route('attribute.storeCategoryAssignment', $attribute->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="categories">Select Categories</label>
                <select name="categories[]" class="form-control" multiple>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success mt-3">Assign Categories</button>
        </form>

    </div>
</div>
@endsection
