@extends('dashboard.layout.layout')

@section('pageTitle', 'Manage Attribute Values')

@section('main-content')
    <div class="page-content">
        <div class="container-fluid">

            <h4>Manage Values for Attribute: {{ $attribute->name }}</h4>

            <form action="{{ route('attribute.storeValues', $attribute->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="values" class="form-label">Values</label>
                    <input type="text" name="values[]" class="form-control mb-2 daZ" placeholder="Enter a value">
                    <button type="button" class="btn btn-secondary" id="add-value">Add More</button>
                </div>
                <button type="submit" class="btn btn-success">Save Values</button>
            </form>

            <ul class="list-group mt-3">
                @foreach ($values as $value)
                    <li class="list-group-item">
                        {{ $value->value }}

                        <form action="{{ route('attribute.destroyValue', [$attribute->id, $value->id]) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm float-right">Delete</button>
                        </form>
                    </li>
                @endforeach
            </ul>

            {{ $values->links() }}
        </div>
    </div>
@endsection

@section('additionScript')
    <script>
        $('#add-value').on('click', function() {
            // Create a new input field
            var inputField = $('<input>', {
                type: 'text',
                name: 'values[]',
                class: 'form-control mb-2',
                placeholder: 'Enter a value'
            });

            // Append the input field before the Save button
            $(this).closest('form').find('input[type="text"]').last().after(inputField);
        });
    </script>
@endsection
