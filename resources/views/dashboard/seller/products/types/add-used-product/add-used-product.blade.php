@extends('dashboard.layout.layout')
@section('pageTitle')
    Admin Dashboard
@endsection
@section('main-content')
    <link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet" />
    <div class="page-content">
        <div class="container-fluid">



            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Add New Products</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Playware</a></li>
                                <li class="breadcrumb-item active">Products</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <form action="" id="productForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="product_name" class="form-label">Product Name</label>
                                            <input type="text" name="product_name" id="product_name"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="category_name" class="form-label">Category Name</label>
                                            <select name="category_name" id="category_name" class="form-control">
                                                <option value="">Select Your Category</option>
                                                @foreach ($category as $cat)
                                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="brand_name" class="form-label">Brand Name</label>
                                            <select name="brand_name" id="brand_name" class="form-control">
                                                <option value="">No Category Selected</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row" id="attributes"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="warranty" class="form-label">Warranty</label>
                                            <select name="warranty" class="form-control" id="warranty">
                                                <option value="">Select Warranty</option>
                                                <option value="6 Months">6 Months</option>
                                                <option value="1 Year">1 Year</option>
                                                <option value="2 Year">2 Year</option>
                                                <option value="3 Year">3 Year</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="year" class="form-label">Year - Make of Product</label>
                                            <select name="year" class="form-control" id="year">
                                                <option value="">Select Year</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="price" class="form-label">Price</label>
                                            <input type="tel" name="price" id="price" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sp" class="form-label">Sale Price</label>
                                            <input type="text" name="sp" id="sp" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sku" class="form-label">Product SKU</label>
                                            <input type="text" name="sku" id="sku" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="stock" class="form-label">Stock</label>
                                            <input type="number" min="0" max="20" name="stock"
                                                id="stock" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="repairedc" class="form-label">Is Your Product Repaired?
                                                <input type="checkbox" name="" id="repariedc" style="margin-left: 10px;margin-top:10px;">
                                            </label>
                                        </div>
                                        <div class="form-group" id="rep" style="display:none;">
                                            <label for="repaired" class="form-label">Reason For Reparing</label>
                                            <textarea name="repaired" class="form-control" id="repaired" cols="30" rows="4"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="reason" class="form-label">Reason For Selling (Optional)</label>
                                            <textarea name="reason" class="form-control" id="reason" cols="30" rows="4"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea name="description" class="form-control" id="description" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <input type="file" class="filepond" name="file" id="images" multiple />
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-success">Submit Product</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('additionScript')
    <script>
        $(document).ready(function() {
            $('#repariedc').change(function() {
                if ($(this).is(':checked')) {
                    $('#rep').show();
                } else {
                    $('#rep').hide();
                }
            });


            $('#category_name').change(function() {
                var categoryId = $(this).val();

                if (categoryId) {
                    $.ajax({
                        url: '/brands/' + categoryId,
                        method: "GET",
                        success: function(data) {
                            console.log(data);
                            if (data && data.length > 0) {
                                $('#brand_name').empty();
                                $('#brand_name').append(
                                    '<option value="">Select Brand</option>');

                                $.each(data, function(index, brand) {
                                    $('#brand_name').append('<option value="' + brand
                                        .id + '">' + brand.name + '</option>');
                                });
                            } else {
                                $('#brand_name').empty();
                                $('#brand_name').append(
                                    '<option value="">No Brand Associated With This Category</option>'
                                );
                            }
                        }
                    });
                } else {
                    $('#brand_name').empty();
                    $('#brand_name').append('<option value="">No Category Selected</option>');
                }

                if (categoryId) {
                    $.ajax({
                        url: '/attributes-values/' + categoryId,
                        method: "GET",
                        success: function(data) {
                            console.log(data); // Check the returned data structure

                            $('#attributes').empty(); // Clear previous attributes

                            // Loop through the attributes and values
                            $.each(data, function(index, item) {
                                var attribute = item.attribute;
                                var attributeValues = item.values;

                                // Create a div to hold the select box for each attribute
                                var attributeDiv = $(
                                    '<div class="attribute-select-box form-group col-md-3">'
                                );

                                // Create the label for the attribute
                                var label = $('<label>').text(attribute.name).attr(
                                    'class', 'form-label');
                                attributeDiv.append(label);

                                // Create the select box for the attribute
                                var selectBox = $('<select>').attr('id', 'attribute_' +
                                        attribute.id)
                                    .attr('name', 'attribute[' + attribute.id + ']')
                                    .attr('class', 'form-control');
                                selectBox.append('<option value="">Select ' + attribute
                                    .name + '</option>');

                                // Add options for each attribute value
                                $.each(attributeValues, function(valIndex, value) {
                                    selectBox.append('<option value="' + value
                                        .id + '">' + value.value +
                                        '</option>');
                                });

                                // Append the select box to the container
                                attributeDiv.append(selectBox);
                                $('#attributes').append(
                                    attributeDiv
                                ); // Append each attribute div to the main container
                            });
                        }
                    });
                } else {
                    $('#attributes').empty(); // If no category is selected, clear the attributes section
                }
            });
        });

        function renderYearSelectBox() {
            // Get the current year
            var currentYear = new Date().getFullYear();

            // Get the select element
            var yearSelect = document.getElementById('year');

            // Clear any existing options in the select box
            yearSelect.innerHTML = '<option value="">Select Year</option>';

            // Loop from 2010 to the current year and append options
            for (var year = 2010; year <= currentYear; year++) {
                var option = document.createElement('option');
                option.value = year;
                option.text = year;
                yearSelect.appendChild(option);
            }
        }

        // Call the function to render the year select box when the page loads
        document.addEventListener('DOMContentLoaded', renderYearSelectBox);
    </script>
    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>



    <script>
        $(document).ready(function() {
            // Initialize FilePond
            const pond = FilePond.create(document.querySelector('input[type="file"]'));

            // AJAX Form Submission
            $('#productForm').submit(function(e) {
                e.preventDefault(); // Prevent default form submission

                // Clear previous errors
                $('.error').remove();

                // Get the form data
                var formData = new FormData(this);

                // Append files from FilePond to FormData
                let files = pond.getFiles();
                files.forEach(function(fileItem) {
                    formData.append('file[]', fileItem.file); // Add each file from FilePond
                });

                // Send AJAX request
                $.ajax({
                    url: '/add-used-product', // Your URL for handling uploads
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            alert('Product added successfully!');
                            window.location.href =
                                '/products'; // Redirect to the product list or desired page
                        }
                    },
                    error: function(xhr) {
                        // Handle errors
                        console.log(xhr.responseText); // Log the error response from the server

                        if (xhr.status === 422) {
                            // Validation error, display errors under corresponding fields
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(field, messages) {
                                var targetElement;

                                // If the error is related to the file input
                                if (field === 'file') {
                                    targetElement = $(
                                        '#images'); // File input field (FilePond)
                                } else {
                                    // For other fields, we target by ID (e.g., product_name, category_name)
                                    targetElement = $('#' + field);
                                }

                                // If the target element exists, append the error message
                                if (targetElement.length > 0) {
                                    targetElement.after(
                                        '<div class="error alert alert-danger">' +
                                        messages[0] + '</div>');
                                }
                            });
                        } else {
                            // Display a generic error message
                            var errorMessage = xhr.responseJSON.error ||
                                'Something went wrong. Please try again later.';
                            $('#productForm').prepend('<div class="alert alert-danger error">' +
                                errorMessage + '</div>');
                        }
                    }
                });
            });
        });
    </script>
@endsection
