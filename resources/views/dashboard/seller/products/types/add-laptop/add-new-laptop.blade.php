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
                                            <label for="product_name" class="form-label">Laptop Name</label>
                                            <input type="text" name="product_name" id="product_name"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="laptop_condition" class="form-label">Laptop Condition</label>
                                            <select name="laptop_condition" class="form-control" id="laptop_condition">
                                                <option value="">Select Condition</option>
                                                <option value="New">New</option>
                                                <option value="Used">Used</option>
                                            </select>
                                        </div>
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
                                            <label for="sku" class="form-label">Product SKU</label>
                                            <input type="text" name="sku" id="sku" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="process_gen" class="form-label">Build Year</label>
                                            <select name="year" id="year" class="form-control">
                                                <option value="">Build Year</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="laptop_brand" class="form-label">Laptop Brand</label>
                                            <select name="laptop_brand" id="laptop_brand" class="form-control">
                                                <option value="">Select Laptop Brand</option>
                                            </select>
                                        </div>
                                    </div>

                                    {{-- -

                                    ==============================================================================
                                                            Components Start
                                    ==============================================================================

                                    - --}}

                                    <div class="col-md-12" id="component">
                                        <div class="row">
                                            <!-- Processor -->
                                            <div class="col-md-12">
                                                <h4>Processor</h4>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="process_name" class="form-label">Processor
                                                                Name</label>
                                                            <input type="text" name="process_name" id="processor_name"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="process_brand" class="form-label">Processor
                                                                Brand</label>
                                                            <select name="process_brand" id="process_brand"
                                                                class="form-control">
                                                                <option value="">Select Processor Brand</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="process_gen" class="form-label">Processor
                                                                Generation
                                                                Year</label>
                                                            <select name="process_gen_year" id="process_gen_year"
                                                                class="form-control">
                                                                <option value="">Select Processor Generation Year
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="process_condition" class="form-label">Processor
                                                                Condition</label>
                                                            <select name="process_condition" id="process_condition"
                                                                class="form-control">
                                                                <option value="">Select Condition</option>
                                                                <option value="New">New</option>
                                                                <option value="Used">Used</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- Graphics Card -->
                                            <div class="col-md-12">
                                                <h4>Graphics Card</h4>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="graphics_card_name" class="form-label">Graphics
                                                                Card
                                                                Name</label>
                                                            <input type="text" data-slug="Processors"
                                                                name="graphics_card_name" id="graphics_card_name"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="graphics_card_brand" class="form-label">Graphics
                                                                Card
                                                                Brand</label>
                                                            <select name="graphics_card_brand" data-slug="graphic-cards"
                                                                id="graphics_card_brand" class="form-control">
                                                                <option value="">Select Graphics Card Brand</option>
                                                                <option value="NVIDIA">NVIDIA</option>
                                                                <option value="AMD">AMD</option>
                                                                <!-- Add more brands as needed -->
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="graphics_card_memory" class="form-label">Memory
                                                                Bandwidth</label>
                                                            <select name="graphics_card_memory" id="graphics_card_memory"
                                                                class="form-control">
                                                                <option value="">Select Memory Bandwidth</option>
                                                                <option value="1GB">1GB</option>
                                                                <option value="2GB">2GB</option>
                                                                <option value="3GB">3GB</option>
                                                                <option value="24GB">24GB</option>
                                                                <!-- Add more options if needed -->
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="graphics_card_condition"
                                                                class="form-label">Condition</label>
                                                            <select name="graphics_card_condition"
                                                                id="graphics_card_condition" class="form-control">
                                                                <option value="">Select Condition</option>
                                                                <option value="New">New</option>
                                                                <option value="Used">Used</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- RAM -->
                                            <div class="col-md-12">
                                                <h4>RAM</h4>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="ram_name" class="form-label">RAM Name</label>
                                                            <input type="text" name="ram_name" id="ram_name"
                                                                data-slug="rams" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="ram_brand" class="form-label">RAM Brand</label>
                                                            <select name="ram_brand" id="ram_brand" class="form-control">
                                                                <option value="">Select RAM Brand</option>
                                                                <option value="Corsair">Corsair</option>
                                                                <option value="G.SKILL">G.SKILL</option>
                                                                <!-- Add more brands as needed -->
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="ram_memory" class="form-label">Memory
                                                                Bandwidth</label>
                                                            <select name="ram_memory" id="ram_memory"
                                                                class="form-control">
                                                                <option value="">Select Memory Bandwidth</option>
                                                                <option value="1GB">1GB</option>
                                                                <option value="2GB">2GB</option>
                                                                <option value="3GB">3GB</option>
                                                                <!-- Add more options as needed -->
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="ram_dimm" class="form-label">Ram Dimm Type</label>
                                                            <select name="ram_dimm" id="ram_dimm" class="form-control">
                                                                <option value="">Select Dimm Type</option>
                                                                <option value="DDR1">DDR1</option>
                                                                <option value="DDR2">DDR2</option>
                                                                <option value="DDR2">DDR3</option>
                                                                <option value="DDR2">DDR4</option>
                                                                <option value="DDR2">DDR5</option>
                                                                <option value="DDR2">DDR6</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Storage -->
                                            <div class="col-md-12">
                                                <h4>Storage</h4>
                                                <div id="storage-container">
                                                    <div class="row storage" data-id="1" id="storage_row_1">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="storage_name_1" class="form-label">Storage
                                                                    Device Name</label>
                                                                <input type="text" name="storage_name[]"
                                                                    id="storage_name_1" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="storage_brand_1" class="form-label">Storage
                                                                    Brand</label>
                                                                <select name="storage_brand[]" id="storage_brand_1"
                                                                    class="form-control">
                                                                    <option value="">Select Brands</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="storage_type_1" class="form-label">Storage
                                                                    Type</label>
                                                                <select name="storage_type[]" id="storage_type_1"
                                                                    class="form-control">
                                                                    <option value="">Select Storage Type</option>
                                                                    <option value="NVMe">NVMe</option>
                                                                    <option value="SSD">SSD</option>
                                                                    <option value="HDD">HDD</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label for="storage_capacity_1" class="form-label">Storage
                                                                    Capacity</label>
                                                                <select name="storage_capacity[]" id="storage_capacity_1"
                                                                    class="form-control">
                                                                    <option value="">Select Storage Capacity</option>
                                                                    <option value="128GB">128GB</option>
                                                                    <option value="256GB">256GB</option>
                                                                    <option value="512GB">512GB</option>
                                                                    <option value="1TB">1TB</option>
                                                                    <option value="2TB">2TB</option>
                                                                    <option value="3TB">3TB</option>
                                                                    <option value="4TB">4TB</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <button class="btn btn-success" id="add-more-storage">Add More
                                                    Storage</button>

                                            </div>
                                        </div>
                                    </div>


                                    {{-- -

                                    ==============================================================================
                                                            Components End
                                    ==============================================================================

                                    - --}}

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
    {{-- Script To Render Year --}}
    <script>
        function renderYearSelectBox() {
            // Get the current year
            var currentYear = new Date().getFullYear();

            // Get the select elements
            var yearSelect = document.getElementById('year');


            // Clear any existing options in the select boxes
            yearSelect.innerHTML = '<option value="">Select Year</option>';


            // Loop from 2010 to the current year and append options
            for (var year = 2010; year <= currentYear; year++) {
                // Create and append options for the first select box
                var option1 = document.createElement('option');
                option1.value = year;
                option1.text = year;
                yearSelect.appendChild(option1);

            }
        }

        // Call the function to render the year select boxes when the page loads
        document.addEventListener('DOMContentLoaded', renderYearSelectBox);
    </script>

    {{-- Script For Getting Categories By Slug --}}
    <script>
        function getCategoriesBySlug(slug, compid) {
            $.ajax({
                url: '/categoryget/' + slug, // API endpoint to get category by slug
                method: 'GET',
                success: function(data) {
                    // Check if the category and its brands exist in the response
                    if (data && data.category && data.category.brands && data.category.brands.length > 0) {
                        $('#' + compid).empty();
                        $('#' + compid).append('<option value="">Select Brand</option>');

                        // Check if the category is 'laptop' or similar
                        if (slug.toLowerCase() === 'laptops') {
                            // If the category is laptop, use brand id as the value
                            $.each(data.category.brands, function(index, brand) {
                                $('#' + compid).append('<option value="' + brand.id + '">' + brand
                                    .name + '</option>');
                            });
                        } else {
                            // Otherwise, keep the name as the value
                            $.each(data.category.brands, function(index, brand) {
                                $('#' + compid).append('<option value="' + brand.name + '">' + brand
                                    .name + '</option>');
                            });
                        }
                    } else {
                        $('#' + compid).empty();
                        $('#' + compid).append(
                            '<option value="">No Brand Associated With This Category</option>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('An error occurred:', error);
                    $('#' + compid).empty();
                    $('#' + compid).append('<option value="">Error fetching brands</option>');
                }
            });
        }


        $(document).ready(function() {


            // Trigger the function for the "processors" category
            getCategoriesBySlug('processors', 'process_brand');
            getCategoriesBySlug('graphic-cards', 'graphics_card_brand');
            getCategoriesBySlug('rams', 'ram_brand');
            getCategoriesBySlug('storage', 'storage_brand_1');
            getCategoriesBySlug('laptops', 'laptop_brand');
        });
    </script>


    {{-- Script For Storage --}}
    <script>
        let storageCounter = 1; // Counter to keep track of unique IDs

        document.getElementById("add-more-storage").addEventListener("click", function(e) {
            e.preventDefault();

            // Check if the maximum limit of 3 rows is reached
            const storageRows = document.querySelectorAll(".storage");
            if (storageRows.length >= 3) {
                alert("You can only add up to 3 storage options.");
                return;
            }

            storageCounter++;

            // Create a new storage row
            const newStorageRow = `
        <div class="row storage" data-id="${storageCounter}" id="storage_row_${storageCounter}">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="storage_name_${storageCounter}" class="form-label">Storage Device Name</label>
                    <input type="text" name="storage_name[]" id="storage_name_${storageCounter}" class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="storage_brand_${storageCounter}" class="form-label">Storage Brand</label>
                    <select name="storage_brand[]" id="storage_brand_${storageCounter}" class="form-control">
                        <option value="">Select Brands</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="storage_type_${storageCounter}" class="form-label">Storage Type</label>
                    <select name="storage_type[]" id="storage_type_${storageCounter}" class="form-control">
                        <option value="">Select Storage Type</option>
                        <option value="NVMe">NVMe</option>
                        <option value="SSD">SSD</option>
                        <option value="HDD">HDD</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="storage_capacity_${storageCounter}" class="form-label">Storage Capacity</label>
                    <select name="storage_capacity[]" id="storage_capacity_${storageCounter}" class="form-control">
                        <option value="">Select Storage Capacity</option>
                        <option value="128GB">128GB</option>
                        <option value="256GB">256GB</option>
                        <option value="512GB">512GB</option>
                        <option value="1TB">1TB</option>
                        <option value="2TB">2TB</option>
                        <option value="3TB">3TB</option>
                        <option value="4TB">4TB</option>
                    </select>
                </div>
            </div>
            <div class="col-md-1 d-flex align-items-center">
                <button type="button" class="btn btn-danger remove-storage" data-id="${storageCounter}">X</button>
            </div>
        </div>`;

            // Append the new row to the container
            document.getElementById("storage-container").insertAdjacentHTML("beforeend", newStorageRow);

            // Call getCategoriesBySlug for the new storage_brand select field
            getCategoriesBySlug('storage', `storage_brand_${storageCounter}`);
        });

        // Event delegation to handle dynamic "Remove" button clicks
        document.getElementById("storage-container").addEventListener("click", function(e) {
            if (e.target && e.target.classList.contains("remove-storage")) {
                const rowId = e.target.getAttribute("data-id");
                document.getElementById(`storage_row_${rowId}`).remove();
            }
        });
    </script>


    {{-- FilePond Script --}}
    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>


    {{-- Script To Upload Product --}}
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
                    url: '/add-laptop', // Your URL for handling uploads
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
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
