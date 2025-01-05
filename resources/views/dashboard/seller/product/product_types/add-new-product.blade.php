@extends('dashboard.layout.layout')

@section('pageTitle')
    Seller Products
@endsection

@section('main-content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Add New Product</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Playware</a></li>
                                <li class="breadcrumb-item active">Add Product</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card p-4">
                        <div class="card-body">
                            <form action="" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <!-- Product Name -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="product_name" class="form-label">Product Name</label>
                                            <input type="text" name="product_name" id="product_name"
                                                class="form-control">
                                        </div>
                                    </div>

                                    <!-- Product Category -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="product_category" class="form-label">Product Category</label>
                                            <select name="product_category" id="product_category" class="form-control">
                                                <option value="0">Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Product Brand -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="brands" class="form-label">Product Brand</label>
                                            <select name="brands" id="brands" class="form-control">
                                                <!-- Brands will be populated based on category -->
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Product Attributes -->
                                    <div id="attributes-container" class="col-md-12 mb-2" style="display:none;">
                                        <div id="attributes-list" class="row"></div>
                                    </div>

                                    <!-- Warranty -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="warranty" class="form-label">Warranty</label>
                                            <input type="text" name="warranty" id="warranty" class="form-control">
                                        </div>
                                    </div>

                                    <!-- Year-Make of Product -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="year_make" class="form-label">Year of Make</label>
                                            <input type="text" name="year_make" id="year_make" class="form-control">
                                        </div>
                                    </div>

                                    <!-- Reason for Selling (Optional) -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="reason_selling" class="form-label">Reason for Selling
                                                (Optional)</label>
                                            <input type="text" name="reason_selling" id="reason_selling"
                                                class="form-control">
                                        </div>
                                    </div>

                                    <!-- Upload Pictures -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="product_pictures" class="form-label">Upload Pictures</label>
                                            <input type="file" name="product_pictures[]" id="product_pictures"
                                                class="form-control" multiple>
                                        </div>
                                        <div id="image-preview-container" class="mt-3">
                                            <!-- Preview of images will be displayed here -->
                                        </div>
                                    </div>

                                    <!-- Product Description -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="product_description" class="form-label">Product Description</label>
                                            <textarea name="product_description" id="product_description" class="form-control" rows="4"></textarea>
                                        </div>
                                    </div>

                                    <!-- Amount in Stock -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="amount_in_stock" class="form-label">Amount in Stock</label>
                                            <input type="number" name="amount_in_stock" id="amount_in_stock"
                                                class="form-control" min="1">
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">Save Product</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('additionScript')
    <script>
        // Image preview functionality
        $('#product_pictures').change(function(e) {
            var files = e.target.files;
            var previewContainer = $('#image-preview-container');
            previewContainer.empty(); // Clear previous previews

            // Loop through the selected files and create image previews
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                var reader = new FileReader();

                reader.onload = function(event) {
                    var image = $('<img />', {
                        src: event.target.result,
                        class: 'img-thumbnail',
                        width: 100, // Thumbnail size
                        height: 100 // Thumbnail size
                    });
                    previewContainer.append(image); // Add the image to the container
                }

                reader.readAsDataURL(file); // Read the image as a data URL
            }
        });

        // Handling category change to fetch brands and attributes
        $('#product_category').change(function() {
            var categoryId = $(this).val();

            if (categoryId) {
                // Fetch brands for selected category
                $.ajax({
                    url: '/brands/' + categoryId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var brandSelect = $('#brands');
                        brandSelect.empty();
                        $.each(data, function(index, brand) {
                            brandSelect.append('<option value="' + brand.id + '">' + brand
                                .name + '</option>');
                        });
                    },
                    error: function(error) {
                        console.log('Error fetching brands:', error);
                    }
                });

                // Fetch attributes for the selected category
                $.ajax({
                    url: '/category/' + categoryId + '/attributes',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var attributesList = $('#attributes-list');
                        attributesList.empty(); // Clear previous attributes

                        if (data.length > 0) {
                            $('#attributes-container').show();
                            $.each(data, function(index, attribute) {
                                var attributeHtml = `
                                    <div class="attribute col-md-4">
                                        <label for="attribute-${attribute.id}">${attribute.name}</label>
                                        <select name="attributes[${attribute.id}]" id="attribute-${attribute.id}" class="form-control">
                                            <option value="">Select ${attribute.name}</option>
                                            ${attribute.values.map(value => `<option value="${value.id}">${value.value}</option>`).join('')}
                                        </select>
                                    </div>
                                `;
                                attributesList.append(attributeHtml);
                            });
                        } else {
                            $('#attributes-container').hide();
                        }
                    },
                    error: function(error) {
                        console.log('Error fetching attributes:', error);
                        $('#attributes-container').hide();
                    }
                });
            } else {
                $('#brands').empty().append('<option value="">No Brand Found</option>');
            }
        });
    </script>
@endsection
