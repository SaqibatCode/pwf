{{-- resources/views/dashboard/seller/products/types/edit-product/edit-product.blade.php --}}
@extends('dashboard.layout.layout')

@section('pageTitle')
    Edit Product
@endsection

@section('main-content')
    <link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet" />

    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Edit Product</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Playware</a></li>
                                <li class="breadcrumb-item active">Products</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Display Existing Product Data in the Form --}}
            <div class="row">
                <div class="col-md-12">
                    {{-- Use PUT for update: --}}
                    <form action="{{ route('product.update', $product->id) }}" id="productEditForm" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT') {{-- Important for a PUT request --}}
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    {{-- Product Name --}}
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="product_name" class="form-label">Product Name</label>
                                            <input type="text" name="product_name" id="product_name" class="form-control"
                                                value="{{ old('product_name', $product->product_name) }}">
                                        </div>
                                    </div>

                                    {{-- Category --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="category_name" class="form-label">Category Name</label>
                                            <select name="category_name" id="category_name" class="form-control">
                                                <option value="">Select Your Category</option>
                                                @foreach ($categories as $cat)
                                                    <option value="{{ $cat->id }}"
                                                        {{ $cat->id == $product->category_id ? 'selected' : '' }}>
                                                        {{ $cat->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Brand --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="brand_name" class="form-label">Brand Name</label>
                                            <select name="brand_name" id="brand_name" class="form-control">
                                                <option value="">No Category Selected</option>
                                                {{-- Filled dynamically by JS if desired, or server-side if you prefer --}}
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Attributes --}}
                                    <div class="col-md-12">
                                        <div class="row" id="attributes"></div>
                                    </div>

                                    {{-- Warranty --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="warranty" class="form-label">Warranty</label>
                                            <select name="warranty" class="form-control" id="warranty">
                                                <option value="">Select Warranty</option>
                                                <option value="6 Months"
                                                    {{ $product->warranty == '6 Months' ? 'selected' : '' }}>6 Months
                                                </option>
                                                <option value="1 Year"
                                                    {{ $product->warranty == '1 Year' ? 'selected' : '' }}>1 Year</option>
                                                <option value="2 Year"
                                                    {{ $product->warranty == '2 Year' ? 'selected' : '' }}>2 Year</option>
                                                <option value="3 Year"
                                                    {{ $product->warranty == '3 Year' ? 'selected' : '' }}>3 Year</option>
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Year --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="year" class="form-label">Year - Make of Product</label>
                                            <select name="year" class="form-control" id="year">
                                                <option value="">Select Year</option>
                                                {{-- Filled by JS below (e.g., from 2010 - current year) --}}
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Price --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="price" class="form-label">Price</label>
                                            <input type="tel" name="price" id="price" class="form-control"
                                                value="{{ old('price', $product->price) }}">
                                        </div>
                                    </div>

                                    {{-- Sale Price --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sp" class="form-label">Sale Price</label>
                                            <input type="text" name="sp" id="sp" class="form-control"
                                                value="{{ old('sp', $product->sale_price) }}">
                                        </div>
                                    </div>

                                    {{-- SKU --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sku" class="form-label">Product SKU</label>
                                            <input type="text" name="sku" id="sku" class="form-control"
                                                value="{{ old('sku', $product->sku) }}">
                                        </div>
                                    </div>

                                    {{-- Stock --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="stock" class="form-label">Stock</label>
                                            <input type="number" min="0" max="10000" name="stock"
                                                id="stock" class="form-control"
                                                value="{{ old('stock', $product->stock_quanity) }}">
                                        </div>
                                    </div>

                                    {{-- Reason (Optional) --}}
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="reason" class="form-label">Reason For Selling (Optional)</label>
                                            <textarea name="reason" class="form-control" id="reason" cols="30" rows="4">{{ old('reason', $product->reason) }}</textarea>
                                        </div>
                                    </div>

                                    {{-- Description --}}
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea name="description" class="form-control" id="description" cols="30" rows="10">{{ old('description', $product->description) }}</textarea>
                                        </div>
                                    </div>


                                    <!-- Existing Photos Section -->
                                    <div class="card my-3 col-md-12">
                                        <div class="card-header">Existing Photos</div>
                                        <div class="card-body row">
                                            @forelse($product->pictures as $picture)
                                                <div class="mb-2 d-flex align-items-center col-md-3">
                                                    <img src="{{ asset($picture->image) }}" alt="Product Image"
                                                        style="width: 100px; height: auto; margin-right: 10px;">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" name="remove_images[]"
                                                            value="{{ $picture->id }}">
                                                        Remove this image
                                                    </label>
                                                </div>
                                            @empty
                                                <p>No existing images.</p>
                                            @endforelse
                                        </div>
                                    </div>

                                    <!-- Upload New Photos -->
                                    <div class="card my-3 col-md-12">
                                        <div class="card-header">Add / Replace Photos</div>
                                        <div class="card-body">
                                            <input type="file" class="filepond" name="file" id="images"
                                                multiple />
                                        </div>
                                    </div>

                                    {{-- Submit --}}
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">
                                            Update Product
                                        </button>
                                    </div>
                                </div> {{-- End row --}}
                            </div> {{-- End card-body --}}
                        </div> {{-- End card --}}
                    </form>
                </div> {{-- End col-md-12 --}}
            </div> {{-- End row --}}
        </div> {{-- End container-fluid --}}
    </div> {{-- End page-content --}}

    <div id="spinner" style="display: none;">
        <!-- Your spinner HTML or CSS animation here -->
        <p>Loading...</p>
    </div>
@endsection

@section('additionScript')
    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize FilePond
            const pond = FilePond.create(document.querySelector('input[type="file"]'));

            // Show a spinner if you want to load things on page load
            // (This is optional—just an example)
            $('#spinner').show();

            // Helper: Render years in the #year dropdown
            function renderYearSelectBox() {
                var currentYear = new Date().getFullYear();
                var yearSelect = document.getElementById('year');
                yearSelect.innerHTML = '<option value="">Select Year</option>';

                for (var year = 2010; year <= currentYear; year++) {
                    var option = document.createElement('option');
                    option.value = year;
                    option.text = year;
                    yearSelect.appendChild(option);
                }
            }
            renderYearSelectBox();

            // Pre-select the product's year if it exists
            var existingYear = "{{ $product->year_of_make }}";
            if (existingYear) {
                $('#year').val(existingYear);
            }

            // If the product has an existing category, we’ll trigger brand + attribute fetching.
            var existingCategoryId = "{{ $product->category_id }}";
            if (existingCategoryId) {
                $('#category_name').val(existingCategoryId).trigger('change');
            }

            // Populate the brand & attributes any time the category changes
            function getCatAndAtt() {
                var categoryId = $('#category_name').val();

                // Clear any existing brand or attribute data
                $('#brand_name').empty().append('<option value="">No Category Selected</option>');
                $('#attributes').empty();

                // If no category selected, hide spinner and exit
                if (!categoryId) {
                    $('#spinner').hide();
                    return;
                }

                // 1) Fetch brands
                $.ajax({
                    url: '/brands/' + categoryId,
                    method: 'GET',
                    success: function(data) {
                        $('#brand_name').empty();

                        if (data && data.length > 0) {
                            $('#brand_name').append('<option value="">Select Brand</option>');
                            $.each(data, function(index, brand) {
                                // If you want to pre-select the brand in edit mode:
                                let selectedBrandId = "{{ $product->brand_id }}";
                                let selected = (brand.id == selectedBrandId) ?
                                    'selected' : '';

                                $('#brand_name').append(`
                                    <option value="${brand.id}" ${selected}>${brand.name}</option>
                                `);
                            });
                        } else {
                            $('#brand_name').append(
                                '<option value="">No Brand Associated With This Category</option>'
                            );
                        }

                        // Hide spinner if only brand data is needed
                        // We'll hide it after attributes too in the next AJAX call
                    },
                    error: function() {
                        $('#spinner').hide();
                        alert('Error fetching brand data.');
                    }
                });

                // 2) Fetch attributes
                $.ajax({
                    url: '/attributes-values/' + categoryId,
                    method: 'GET',
                    success: function(data) {
                        $('#attributes').empty();

                        // Suppose $product->attributes is eager-loaded and
                        // we know pivot.attribute_value_id for each attribute
                        let selectedAttributeValues = @json($product->attributes->pluck('pivot.attribute_value_id', 'id'));

                        $.each(data, function(index, item) {
                            var attribute = item.attribute;
                            var attributeValues = item.values;

                            var attributeDiv = $(
                                '<div class="attribute-select-box form-group col-md-3">'
                            );
                            var label = $('<label>').text(attribute.name).addClass(
                                'form-label');
                            attributeDiv.append(label);

                            var selectBox = $('<select>')
                                .attr('id', 'attribute_' + attribute.id)
                                .attr('name', 'attribute[' + attribute.id + ']')
                                .addClass('form-control');

                            selectBox.append(
                                `<option value="">Select ${attribute.name}</option>`
                            );

                            $.each(attributeValues, function(valIndex, value) {
                                var selected = '';
                                // If the product->attributes pivot says attribute.id => attribute_value.id
                                if (selectedAttributeValues[attribute.id] ==
                                    value.id) {
                                    selected = 'selected';
                                }
                                selectBox.append(`
                                    <option value="${value.id}" ${selected}>${value.value}</option>
                                `);
                            });

                            attributeDiv.append(selectBox);
                            $('#attributes').append(attributeDiv);
                        });

                        // Finally, hide the spinner now that both brand & attributes are loaded
                        $('#spinner').hide();
                    },
                    error: function() {
                        $('#spinner').hide();
                        alert('Error fetching attribute data.');
                    }
                });
            };
            $('#category_name').change(getCatAndAtt);
            setTimeout(function() {
                getCatAndAtt();
            }, 1);
            // Handle form submission (AJAX)
            $('#productEditForm').submit(function(e) {
                e.preventDefault();
                // Clear old errors
                $('.error').remove();

                // Build FormData
                var formData = new FormData(this);

                // Add FilePond files
                let files = pond.getFiles();
                files.forEach(function(fileItem) {
                    formData.append('file[]', fileItem.file);
                });

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST', // We have @method('PUT') in the Blade, so this is fine for AJAX
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            window.location.href = '/products';
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(field, messages) {
                                var targetElement;
                                if (field === 'file') {
                                    targetElement = $('#images');
                                } else {
                                    targetElement = $('#' + field);
                                }
                                if (targetElement.length > 0) {
                                    targetElement.after(
                                        '<div class="error alert alert-danger">' +
                                        messages[0] + '</div>'
                                    );
                                }
                            });
                        } else {
                            var errorMessage = xhr.responseJSON.error ||
                                'Something went wrong. Please try again later.';
                            $('#productEditForm').prepend(
                                '<div class="alert alert-danger error">' + errorMessage +
                                '</div>');
                        }
                    }
                });
            });
        });
    </script>
@endsection
