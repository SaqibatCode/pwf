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
                                            <label for="product_name" class="form-label">Build Title</label>
                                            <input type="text" name="product_name" id="product_name"
                                                class="form-control">
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
                                                            <label for="process_gen" class="form-label">Processor Generation
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
                                                            <label for="process_gen" class="form-label">Processor
                                                                Condition</label>
                                                            <select name="process_gen" id="process_gen"
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

                                            <!-- Motherboard -->
                                            <div class="col-md-12">
                                                <h4>Motherboard</h4>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="motherboard_name" class="form-label">Motherboard
                                                                Name</label>
                                                            <input type="text" name="motherboard_name"
                                                                id="motherboard_name" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="motherboard_brand" class="form-label">Motherboard
                                                                Brand</label>
                                                            <select name="motherboard_brand" id="motherboard_brand"
                                                                data-slug="motherboards" class="form-control">
                                                                <option value="">Select Motherboard Brand</option>
                                                                <option value="ASUS">ASUS</option>
                                                                <option value="MSI">MSI</option>
                                                                <!-- Add more brands as needed -->
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="motherboard_condition"
                                                                class="form-label">Condition</label>
                                                            <select name="motherboard_condition"
                                                                id="motherboard_condition" class="form-control">
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
                                                            <label for="ram_condition"
                                                                class="form-label">Condition</label>
                                                            <select name="ram_condition" id="ram_condition"
                                                                class="form-control">
                                                                <option value="">Select Condition</option>
                                                                <option value="New">New</option>
                                                                <option value="Used">Used</option>
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

                                            <!-- Case -->
                                            <div class="col-md-12">
                                                <h4>Case</h4>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="case_name" class="form-label">Case Name</label>
                                                            <input type="text" name="case_name" id="case_name"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="case_brand" class="form-label">Case Brand</label>
                                                            <select name="case_brand" data-slug="cases" id="case_brand"
                                                                class="form-control">
                                                                <option value="">Select Case Brand</option>
                                                                <option value="NZXT">NZXT</option>
                                                                <option value="Corsair">Corsair</option>
                                                                <!-- Add more brands as needed -->
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="case_condition"
                                                                class="form-label">Condition</label>
                                                            <select name="case_condition" id="case_condition"
                                                                class="form-control">
                                                                <option value="">Select Condition</option>
                                                                <option value="New">New</option>
                                                                <option value="Used">Used</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Cooler -->
                                            <div class="col-md-12">
                                                <h4>Cooler</h4>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="cooler_name" class="form-label">Cooler
                                                                Name</label>
                                                            <input type="text" name="cooler_name" id="cooler_name"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="cooler_brand" class="form-label">Cooler
                                                                Brand</label>
                                                            <select name="cooler_brand" data-slug="cooling"
                                                                id="cooler_brand" class="form-control">
                                                                <option value="">Select Cooler Brand</option>
                                                                <option value="Cooler Master">Cooler Master</option>
                                                                <option value="Corsair">Corsair</option>
                                                                <!-- Add more brands as needed -->
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="cooler_condition"
                                                                class="form-label">Condition</label>
                                                            <select name="cooler_condition" id="cooler_condition"
                                                                class="form-control">
                                                                <option value="">Select Condition</option>
                                                                <option value="New">New</option>
                                                                <option value="Used">Used</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 my-5">
                                                <h4>Add More Component</h4>
                                                <select name="add_component" class="form-control" id="add_component">
                                                    <option value="Keyboard">Keyboard</option>
                                                    <option value="Monitor">Monitor</option>
                                                    <option value="Mouse">Mouse</option>
                                                    <option value="Headpone">Headpones</option>
                                                </select>
                                                <button class="btn btn-success" id="add-more-component">Add
                                                    Component</button>
                                            </div>
                                            <!-- Additonal Components -->
                                            <div id="additional_component" class="row">

                                            </div>
                                            <!-- Additional Parts -->

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
    <script>
        function renderYearSelectBox() {
            // Get the current year
            var currentYear = new Date().getFullYear();

            // Get the select elements
            var yearSelect = document.getElementById('year');
            var yearSelect2 = document.getElementById('process_gen_year');

            // Clear any existing options in the select boxes
            yearSelect.innerHTML = '<option value="">Select Year</option>';
            yearSelect2.innerHTML = '<option value="">Select Year</option>';

            // Loop from 2010 to the current year and append options
            for (var year = 2010; year <= currentYear; year++) {
                // Create and append options for the first select box
                var option1 = document.createElement('option');
                option1.value = year;
                option1.text = year;
                yearSelect.appendChild(option1);

                // Create and append options for the second select box
                var option2 = document.createElement('option');
                option2.value = year;
                option2.text = year;
                yearSelect2.appendChild(option2);
            }
        }

        // Call the function to render the year select boxes when the page loads
        document.addEventListener('DOMContentLoaded', renderYearSelectBox);
    </script>
    <script>
        function getCategoriesBySlug(slug, compid) {
            $.ajax({
                url: '/categoryget/' + slug, // API endpoint to get category by slug
                method: 'GET',
                success: function(data) {
                    console.log(data);
                    // Check if the category and its brands exist in the response
                    if (data && data.category && data.category.brands && data.category.brands
                        .length > 0) {
                        $('#' + compid).empty();
                        $('#' + compid).append('<option value="">Select Brand</option>');

                        // Iterate through the brands array
                        $.each(data.category.brands, function(index, brand) {
                            $('#' + compid).append('<option value="' + brand.name + '">' +
                                brand.name + '</option>');
                        });
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
            getCategoriesBySlug('motherboards', 'motherboard_brand');
            getCategoriesBySlug('rams', 'ram_brand');
            getCategoriesBySlug('storage', 'storage_brand');
            getCategoriesBySlug('cases', 'case_brand');
            getCategoriesBySlug('cooling', 'cooler_brand');
        });
    </script>

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
    <!-- JavaScript to Add and Remove Components -->
    <script>
        document.getElementById('add-more-component').addEventListener('click', function() {
            const selectedComponent = document.getElementById('add_component').value;
            const additionalComponentDiv = document.getElementById('additional_component');
            const addComponentSelect = document.getElementById('add_component');

            // Skip if no component is selected
            if (!selectedComponent) return;

            // Remove the selected option from the dropdown
            for (let i = 0; i < addComponentSelect.options.length; i++) {
                if (addComponentSelect.options[i].value === selectedComponent) {
                    addComponentSelect.options[i].setAttribute('disabled', true);
                    break;
                }
            }

            let componentForm = '';

            // Form structure based on selected component
            if (selectedComponent === 'Keyboard') {
                componentForm = `
                    <div class="col-md-12" id="keyboard-form">
                        <h4>Keyboard</h4>
                        <div class="row">
                            <!-- Keyboard Form Fields -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="keyboard_name" class="form-label">Keyboard Name</label>
                                    <input type="text" name="keyboard_name" id="keyboard_name" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="keyboard_brand" class="form-label">Keyboard Brand</label>
                                    <select name="keyboard_brand" id="keyboard_brand" class="form-control">
                                        <option value="">Select Keyboard Brand</option>
                                        <option value="Logitech">Logitech</option>
                                        <option value="Razer">Razer</option>
                                        <option value="Corsair">Corsair</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="keyboard_condition" class="form-label">Keyboard Condition</label>
                                    <select name="keyboard_condition" id="keyboard_condition" class="form-control">
                                        <option value="">Select Condition</option>
                                        <option value="New">New</option>
                                        <option value="Used">Used</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-danger delete-btn" data-component="Keyboard">Delete</button>
                            </div>
                        </div>
                    </div>
                `;
            } else if (selectedComponent === 'Monitor') {
                componentForm = `
                    <div class="col-md-12" id="monitor-form">
                        <h4>Monitor</h4>
                        <div class="row">
                            <!-- Monitor Form Fields -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="monitor_name" class="form-label">Monitor Name</label>
                                    <input type="text" name="monitor_name" id="monitor_name" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="monitor_brand" class="form-label">Monitor Brand</label>
                                    <select name="monitor_brand" id="monitor_brand" class="form-control">
                                        <option value="">Select Monitor Brand</option>
                                        <option value="Samsung">Samsung</option>
                                        <option value="LG">LG</option>
                                        <option value="Dell">Dell</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="monitor_size" class="form-label">Monitor Size</label>
                                    <select name="monitor_size" id="monitor_size" class="form-control">
                                        <option value="">Select Size</option>
                                        <option value="24in">24 inches</option>
                                        <option value="27in">27 inches</option>
                                        <option value="32in">32 inches</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-danger delete-btn" data-component="Monitor">Delete</button>
                            </div>
                        </div>
                    </div>
                `;
            } else if (selectedComponent === 'Mouse') {
                componentForm = `
                    <div class="col-md-12" id="mouse-form">
                        <h4>Mouse</h4>
                        <div class="row">
                            <!-- Mouse Form Fields -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="mouse_name" class="form-label">Mouse Name</label>
                                    <input type="text" name="mouse_name" id="mouse_name" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="mouse_brand" class="form-label">Mouse Brand</label>
                                    <select name="mouse_brand" id="mouse_brand" class="form-control">
                                        <option value="">Select Mouse Brand</option>
                                        <option value="Logitech">Logitech</option>
                                        <option value="Razer">Razer</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="mouse_type" class="form-label">Mouse Type</label>
                                    <select name="mouse_type" id="mouse_type" class="form-control">
                                        <option value="">Select Mouse Type</option>
                                        <option value="Wireless">Wireless</option>
                                        <option value="Wired">Wired</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-danger delete-btn" data-component="Mouse">Delete</button>
                            </div>
                        </div>
                    </div>
                `;
            } else if (selectedComponent === 'Headphones') {
                componentForm = `
                    <div class="col-md-12" id="headphones-form">
                        <h4>Headphones</h4>
                        <div class="row">
                            <!-- Headphones Form Fields -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="headphones_name" class="form-label">Headphones Name</label>
                                    <input type="text" name="headphones_name" id="headphones_name" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="headphones_brand" class="form-label">Headphones Brand</label>
                                    <select name="headphones_brand" id="headphones_brand" class="form-control">
                                        <option value="">Select Headphones Brand</option>
                                        <option value="Sony">Sony</option>
                                        <option value="Bose">Bose</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="headphones_condition" class="form-label">Headphones Condition</label>
                                    <select name="headphones_condition" id="headphones_condition" class="form-control">
                                        <option value="">Select Condition</option>
                                        <option value="New">New</option>
                                        <option value="Used">Used</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-danger delete-btn" data-component="Headphones">Delete</button>
                            </div>
                        </div>
                    </div>
                `;
            }

            // Append the selected component form to the additional component section
            additionalComponentDiv.innerHTML += componentForm;
        });

        // Event delegation for delete button functionality
        document.getElementById('additional_component').addEventListener('click', function(event) {
            if (event.target && event.target.classList.contains('delete-btn')) {
                // Find the form to delete based on the data-component attribute
                const componentType = event.target.getAttribute('data-component').toLowerCase();
                const formToDelete = document.getElementById(`${componentType}-form`);

                // Remove the form from the DOM
                formToDelete.remove();

                // Re-enable the corresponding option in the dropdown
                const addComponentSelect = document.getElementById('add_component');
                for (let i = 0; i < addComponentSelect.options.length; i++) {
                    if (addComponentSelect.options[i].value === componentType) {
                        addComponentSelect.options[i].removeAttribute('disabled');
                        break;
                    }
                }
            }
        });
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
                    url: '/add-new-product', // Your URL for handling uploads
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
