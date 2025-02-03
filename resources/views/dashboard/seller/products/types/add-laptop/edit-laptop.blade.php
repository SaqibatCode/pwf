@extends('dashboard.layout.layout')

@section('pageTitle')
    Edit Laptop
@endsection

@section('main-content')
    <!-- FilePond CSS -->
    <link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet" />

    <div class="page-content">
        <div class="container-fluid">
            <!-- Page Title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Edit Products</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Playware</a></li>
                                <li class="breadcrumb-item active">Products</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Page Title -->

            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('product.update.laptop', ['id' => $laptop->id]) }}" id="productForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <!-- Basic Product Info -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="product_name" class="form-label">Laptop Name</label>
                                            <input type="text" name="product_name" id="product_name" class="form-control" value="{{ $laptop->product_name }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="laptop_condition" class="form-label">Laptop Condition</label>
                                            <select name="laptop_condition" class="form-control" id="laptop_condition">
                                                <option value="">Select Condition</option>
                                                <option value="New" {{ $laptop->condition == 'New' ? 'selected' : '' }}>New</option>
                                                <option value="Used" {{ $laptop->condition == 'Used' ? 'selected' : '' }}>Used</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="warranty" class="form-label">Warranty</label>
                                            <select name="warranty" class="form-control" id="warranty">
                                                <option value="">Select Warranty</option>
                                                <option value="6 Months" {{ $laptop->warranty == '6 Months' ? 'selected' : '' }}>6 Months</option>
                                                <option value="1 Year" {{ $laptop->warranty == '1 Year' ? 'selected' : '' }}>1 Year</option>
                                                <option value="2 Year" {{ $laptop->warranty == '2 Year' ? 'selected' : '' }}>2 Year</option>
                                                <option value="3 Year" {{ $laptop->warranty == '3 Year' ? 'selected' : '' }}>3 Year</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sku" class="form-label">Product SKU</label>
                                            <input type="text" name="sku" id="sku" class="form-control" value="{{ $laptop->sku }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="year" class="form-label">Build Year</label>
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
                                    <!-- End Basic Product Info -->

                                    {{-- Components Start --}}
                                    <div class="col-md-12" id="component">
                                        <div class="row">
                                            <!-- Processor -->
                                            <div class="col-md-12">
                                                <h4>Processor</h4>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="processor_name" class="form-label">Processor Name</label>
                                                            <input type="text" name="process_name" id="processor_name" class="form-control" value="{{ $laptop->parts->where('key', 'process_name')->first()?->value }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="process_brand" class="form-label">Processor Brand</label>
                                                            <select name="process_brand" id="process_brand" class="form-control">
                                                                <option value="">Select Processor Brand</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="process_gen_year" class="form-label">Processor Generation Year</label>
                                                            <select name="process_gen_year" id="process_gen_year" class="form-control">
                                                                <option value="">Select Processor Generation Year</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="process_condition" class="form-label">Processor Condition</label>
                                                            <select name="process_condition" id="process_condition" class="form-control">
                                                                <option value="">Select Condition</option>
                                                                <option value="New" {{ $laptop->parts->where('key', 'process_condition')->first()?->value == 'New' ? 'selected' : '' }}>New</option>
                                                                <option value="Used" {{ $laptop->parts->where('key', 'process_condition')->first()?->value == 'Used' ? 'selected' : '' }}>Used</option>
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
                                                            <label for="graphics_card_name" class="form-label">Graphics Card Name</label>
                                                            <input type="text" name="graphics_card_name" id="graphics_card_name" class="form-control" value="{{ $laptop->parts->where('key', 'graphics_card_name')->first()?->value }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="graphics_card_brand" class="form-label">Graphics Card Brand</label>
                                                            <select name="graphics_card_brand" id="graphics_card_brand" class="form-control">
                                                                <option value="">Select Graphics Card Brand</option>
                                                                <option value="NVIDIA" {{ $laptop->parts->where('key', 'graphics_card_brand')->first()?->value == 'NVIDIA' ? 'selected' : '' }}>NVIDIA</option>
                                                                <option value="AMD" {{ $laptop->parts->where('key', 'graphics_card_brand')->first()?->value == 'AMD' ? 'selected' : '' }}>AMD</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="graphics_card_memory" class="form-label">Memory Bandwidth</label>
                                                            <select name="graphics_card_memory" id="graphics_card_memory" class="form-control">
                                                                <option value="">Select Memory Bandwidth</option>
                                                                <option value="1GB" {{ $laptop->parts->where('key', 'graphics_card_memory')->first()?->value == '1GB' ? 'selected' : '' }}>1GB</option>
                                                                <option value="2GB" {{ $laptop->parts->where('key', 'graphics_card_memory')->first()?->value == '2GB' ? 'selected' : '' }}>2GB</option>
                                                                <option value="3GB" {{ $laptop->parts->where('key', 'graphics_card_memory')->first()?->value == '3GB' ? 'selected' : '' }}>3GB</option>
                                                                <option value="24GB" {{ $laptop->parts->where('key', 'graphics_card_memory')->first()?->value == '24GB' ? 'selected' : '' }}>24GB</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="graphics_card_condition" class="form-label">Condition</label>
                                                            <select name="graphics_card_condition" id="graphics_card_condition" class="form-control">
                                                                <option value="">Select Condition</option>
                                                                <option value="New" {{ $laptop->parts->where('key', 'graphics_card_condition')->first()?->value == 'New' ? 'selected' : '' }}>New</option>
                                                                <option value="Used" {{ $laptop->parts->where('key', 'graphics_card_condition')->first()?->value == 'Used' ? 'selected' : '' }}>Used</option>
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
                                                            <input type="text" name="ram_name" id="ram_name" class="form-control" value="{{ $laptop->parts->where('key', 'ram_name')->first()?->value }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="ram_brand" class="form-label">RAM Brand</label>
                                                            <select name="ram_brand" id="ram_brand" class="form-control">
                                                                <option value="">Select RAM Brand</option>
                                                                <option value="Corsair" {{ $laptop->parts->where('key', 'ram_brand')->first()?->value == 'Corsair' ? 'selected' : '' }}>Corsair</option>
                                                                <option value="G.SKILL" {{ $laptop->parts->where('key', 'ram_brand')->first()?->value == 'G.SKILL' ? 'selected' : '' }}>G.SKILL</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="ram_memory" class="form-label">Memory Bandwidth</label>
                                                            <select name="ram_memory" id="ram_memory" class="form-control">
                                                                <option value="">Select Memory Bandwidth</option>
                                                                <option value="1GB" {{ $laptop->parts->where('key', 'ram_memory')->first()?->value == '1GB' ? 'selected' : '' }}>1GB</option>
                                                                <option value="2GB" {{ $laptop->parts->where('key', 'ram_memory')->first()?->value == '2GB' ? 'selected' : '' }}>2GB</option>
                                                                <option value="3GB" {{ $laptop->parts->where('key', 'ram_memory')->first()?->value == '3GB' ? 'selected' : '' }}>3GB</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="ram_dimm" class="form-label">RAM Dimm Type</label>
                                                            <select name="ram_dimm" id="ram_dimm" class="form-control">
                                                                <option value="">Select Dimm Type</option>
                                                                <option value="DDR1" {{ $laptop->parts->where('key', 'ram_dimm')->first()?->value == 'DDR1' ? 'selected' : '' }}>DDR1</option>
                                                                <option value="DDR2" {{ $laptop->parts->where('key', 'ram_dimm')->first()?->value == 'DDR2' ? 'selected' : '' }}>DDR2</option>
                                                                <option value="DDR3" {{ $laptop->parts->where('key', 'ram_dimm')->first()?->value == 'DDR3' ? 'selected' : '' }}>DDR3</option>
                                                                <option value="DDR4" {{ $laptop->parts->where('key', 'ram_dimm')->first()?->value == 'DDR4' ? 'selected' : '' }}>DDR4</option>
                                                                <option value="DDR5" {{ $laptop->parts->where('key', 'ram_dimm')->first()?->value == 'DDR5' ? 'selected' : '' }}>DDR5</option>
                                                                <option value="DDR6" {{ $laptop->parts->where('key', 'ram_dimm')->first()?->value == 'DDR6' ? 'selected' : '' }}>DDR6</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Storage -->
                                            <div class="col-md-12">
                                                <h4>Storage</h4>
                                                <div id="storage-container">
                                                    @php
                                                        // Retrieve storage parts arrays.
                                                        $storage_names = $laptop->parts->where('key', 'storage_name')->pluck('value')->values();
                                                        $storage_brands = $laptop->parts->where('key', 'storage_brand')->pluck('value')->values();
                                                        $storage_types = $laptop->parts->where('key', 'storage_type')->pluck('value')->values();
                                                        $storage_capacities = $laptop->parts->where('key', 'storage_capacity')->pluck('value')->values();

                                                        // Determine the maximum number of storage entries.
                                                        $storageCount = max(
                                                            $storage_names->count(),
                                                            $storage_brands->count(),
                                                            $storage_types->count(),
                                                            $storage_capacities->count()
                                                        );
                                                        if ($storageCount === 0) {
                                                            $storageCount = 1;
                                                        }
                                                    @endphp

                                                    @for ($i = 0; $i < $storageCount; $i++)
                                                        <div class="row storage" data-id="{{ $i + 1 }}" id="storage_row_{{ $i + 1 }}">
                                                            <!-- Storage Device Name -->
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="storage_name_{{ $i + 1 }}" class="form-label">Storage Device Name</label>
                                                                    <input type="text" name="storage_name[]" id="storage_name_{{ $i + 1 }}" class="form-control" value="{{ $storage_names->get($i) ?? '' }}">
                                                                </div>
                                                            </div>

                                                            <!-- Storage Brand (with preselected value via data-selected) -->
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="storage_brand_{{ $i + 1 }}" class="form-label">Storage Brand</label>
                                                                    <select name="storage_brand[]" id="storage_brand_{{ $i + 1 }}" class="form-control" data-selected="{{ $storage_brands->get($i) ?? '' }}">
                                                                        <option value="">Select Brand</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <!-- Storage Type -->
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="storage_type_{{ $i + 1 }}" class="form-label">Storage Type</label>
                                                                    <select name="storage_type[]" id="storage_type_{{ $i + 1 }}" class="form-control">
                                                                        <option value="">Select Storage Type</option>
                                                                        <option value="NVMe" {{ ($storage_types->get($i) ?? '') == 'NVMe' ? 'selected' : '' }}>NVMe</option>
                                                                        <option value="SSD" {{ ($storage_types->get($i) ?? '') == 'SSD' ? 'selected' : '' }}>SSD</option>
                                                                        <option value="HDD" {{ ($storage_types->get($i) ?? '') == 'HDD' ? 'selected' : '' }}>HDD</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <!-- Storage Capacity -->
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="storage_capacity_{{ $i + 1 }}" class="form-label">Storage Capacity</label>
                                                                    <select name="storage_capacity[]" id="storage_capacity_{{ $i + 1 }}" class="form-control">
                                                                        <option value="">Select Storage Capacity</option>
                                                                        <option value="128GB" {{ ($storage_capacities->get($i) ?? '') == '128GB' ? 'selected' : '' }}>128GB</option>
                                                                        <option value="256GB" {{ ($storage_capacities->get($i) ?? '') == '256GB' ? 'selected' : '' }}>256GB</option>
                                                                        <option value="512GB" {{ ($storage_capacities->get($i) ?? '') == '512GB' ? 'selected' : '' }}>512GB</option>
                                                                        <option value="1TB" {{ ($storage_capacities->get($i) ?? '') == '1TB' ? 'selected' : '' }}>1TB</option>
                                                                        <option value="2TB" {{ ($storage_capacities->get($i) ?? '') == '2TB' ? 'selected' : '' }}>2TB</option>
                                                                        <option value="3TB" {{ ($storage_capacities->get($i) ?? '') == '3TB' ? 'selected' : '' }}>3TB</option>
                                                                        <option value="4TB" {{ ($storage_capacities->get($i) ?? '') == '4TB' ? 'selected' : '' }}>4TB</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <!-- Remove Button (if not the first storage row) -->
                                                            @if ($i != 0)
                                                                <div class="col-md-1 d-flex align-items-center">
                                                                    <button type="button" class="btn btn-danger remove-storage" data-id="{{ $i + 1 }}">X</button>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endfor
                                                </div>

                                                @if ($storageCount < 3)
                                                    <button class="btn btn-success" id="add-more-storage">Add More Storage</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Components End --}}

                                    <!-- Pricing and Description -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="price" class="form-label">Price</label>
                                            <input type="tel" name="price" id="price" class="form-control" value="{{ $laptop->price }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sp" class="form-label">Sale Price</label>
                                            <input type="text" name="sp" id="sp" class="form-control" value="{{ $laptop->sale_price }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="reason" class="form-label">Reason For Selling (Optional)</label>
                                            <textarea name="reason" class="form-control" id="reason" cols="30" rows="4">{{ $laptop->reason }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea name="description" class="form-control" id="description" cols="30" rows="10">{{ $laptop->description }}</textarea>
                                        </div>
                                    </div>

                                    <!-- Product Images -->
                                    <div class="col-md-12">
                                        <label for="images" class="form-label">Product Images</label>
                                        <div id="image-preview-container">
                                            @if ($laptop->pictures)
                                                @foreach ($laptop->pictures as $picture)
                                                    <div class="image-preview">
                                                        <img src="{{ asset($picture->image) }}" alt="Product Image" style="max-width: 150px; max-height: 150px;">
                                                        <button type="button" class="btn btn-danger btn-sm remove-image" data-image-id="{{ $picture->id }}">Remove</button>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <input type="file" name="file[]" id="images" multiple>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-success">Update Product</button>
                                    </div>
                                    <!-- End Submit Button -->
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- End Row -->
        </div>
    </div>
@endsection

@section('additionScript')
    <script>
        // Render Year select options from 2010 to the current year.
        function renderYearSelectBox() {
            // Get the current year
            var currentYear = new Date().getFullYear();
            var selectedYear = {{ $laptop->year_of_make }};


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
                if (year === selectedYear) {
                    option1.selected = true;
                }
                yearSelect.appendChild(option1);

                // Create and append options for the second select box
                var option2 = document.createElement('option');
                option2.value = year;
                option2.text = year;
                yearSelect2.appendChild(option2);
            }
            yearSelect2.value = "{{ $laptop->parts->where('key', 'process_gen_year')->first()->value ?? '' }}";

        }
        document.addEventListener('DOMContentLoaded', renderYearSelectBox);
    </script>

    <script>
        // Get categories by slug and populate the corresponding select element.
        function getCategoriesBySlug(slug, compid) {
            var selectedBrand = null;
            if (compid === 'laptop_brand') {
                selectedBrand = "{{ $laptop->brand_id }}";
            } else if (compid === 'process_brand') {
                selectedBrand = "{{ $laptop->parts->where('key', 'process_brand')->first()?->value }}";
            } else if (compid === 'graphics_card_brand') {
                selectedBrand = "{{ $laptop->parts->where('key', 'graphics_card_brand')->first()?->value }}";
            } else if (compid === 'ram_brand') {
                selectedBrand = "{{ $laptop->parts->where('key', 'ram_brand')->first()?->value }}";
            } else if(compid.indexOf('storage_brand') === 0) {
                // For storage selects, read the preselected value from the data-selected attribute.
                selectedBrand = $('#' + compid).data('selected') || "";
            }

            $.ajax({
                url: '/categoryget/' + slug,
                method: 'GET',
                success: function(data) {
                    if (data && data.category && data.category.brands && data.category.brands.length > 0) {
                        $('#' + compid).empty().append('<option value="">Select Brand</option>');
                        // If the category is "laptops" we use brand id; otherwise compare by brand name.
                        if (slug.toLowerCase() === 'laptops') {
                            $.each(data.category.brands, function(index, brand) {
                                var selected = (brand.id == selectedBrand) ? 'selected' : '';
                                $('#' + compid).append('<option value="' + brand.id + '" ' + selected + '>' + brand.name + '</option>');
                            });
                        } else {
                            $.each(data.category.brands, function(index, brand) {
                                var selected = (brand.name == selectedBrand) ? 'selected' : '';
                                $('#' + compid).append('<option value="' + brand.name + '" ' + selected + '>' + brand.name + '</option>');
                            });
                        }
                    } else {
                        $('#' + compid).empty().append('<option value="">No Brand Associated With This Category</option>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('An error occurred:', error);
                    $('#' + compid).empty().append('<option value="">Error fetching brands</option>');
                }
            });
        }

        $(document).ready(function() {
            // Populate select boxes for various components.
            getCategoriesBySlug('processors', 'process_brand');
            getCategoriesBySlug('graphic-cards', 'graphics_card_brand');
            getCategoriesBySlug('rams', 'ram_brand');
            @for ($i = 1; $i <= $storageCount; $i++)
                getCategoriesBySlug('storage', 'storage_brand_{{ $i }}');
            @endfor
            getCategoriesBySlug('laptops', 'laptop_brand');
        });
    </script>

    <script>
        // Add More Storage Options.
        let storageCounter = {{ $storageCount }};
        document.getElementById("add-more-storage").addEventListener("click", function(e) {
            e.preventDefault();
            const storageRows = document.querySelectorAll(".storage");
            if (storageRows.length >= 3) {
                alert("You can only add up to 3 storage options.");
                return;
            }
            storageCounter++;
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
                            <select name="storage_brand[]" id="storage_brand_${storageCounter}" class="form-control" data-selected="">
                                <option value="">Select Brand</option>
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
            document.getElementById("storage-container").insertAdjacentHTML("beforeend", newStorageRow);
            getCategoriesBySlug('storage', `storage_brand_${storageCounter}`);
        });

        // Remove storage row on button click (using event delegation).
        document.getElementById("storage-container").addEventListener("click", function(e) {
            if (e.target && e.target.classList.contains("remove-storage")) {
                const rowId = e.target.getAttribute("data-id");
                document.getElementById(`storage_row_${rowId}`).remove();
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            // Remove an image from the preview and mark it for deletion.
            $('#image-preview-container').on('click', '.remove-image', function() {
                var imageDiv = $(this).closest('.image-preview');
                var imageId = $(this).data('image-id');
                var hiddenInput = '<input type="hidden" name="removed_images[]" value="' + imageId + '">';
                $('#image-preview-container').append(hiddenInput);
                imageDiv.remove();
            });

            // AJAX form submission for product update.
            $('#productForm').submit(function(e) {
                e.preventDefault();
                $('.error').remove();
                var formData = new FormData(this);
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            alert('Product updated successfully!');
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
                                    targetElement.after('<div class="error alert alert-danger">' + messages[0] + '</div>');
                                }
                            });
                        } else {
                            var errorMessage = xhr.responseJSON.error || 'Something went wrong. Please try again later.';
                            $('#productForm').prepend('<div class="alert alert-danger error">' + errorMessage + '</div>');
                        }
                    }
                });
            });
        });
    </script>
@endsection
