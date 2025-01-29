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
                        <h4 class="mb-0 font-size-18">Edit Product: {{ $product->product_name }}</h4>
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
                    <form action="{{ route('products.update-complete-pc', $product->id) }}" id="productForm" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Use PUT method for updates -->
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="product_name" class="form-label">Build Title</label>
                                            <input type="text" name="product_name" id="product_name" class="form-control"
                                                value="{{ $product->product_name }}">
                                        </div>
                                    </div>
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sku" class="form-label">Product SKU</label>
                                            <input type="text" name="sku" id="sku" class="form-control"
                                                value="{{ $product->sku }}">
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
                                                                class="form-control"
                                                                value="{{ $product->parts->where('key', 'process_name')->first()->value ?? '' }}">
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
                                                            <label for="process_condition" class="form-label">Processor
                                                                Condition</label>
                                                            <select name="process_condition" id="process_condition"
                                                                class="form-control">
                                                                <option value="">Select Condition</option>
                                                                <option value="New"
                                                                    {{ ($product->parts->where('key', 'process_condition')->first()->value ?? '') == 'New' ? 'selected' : '' }}>
                                                                    New</option>
                                                                <option value="Used"
                                                                    {{ ($product->parts->where('key', 'process_condition')->first()->value ?? '') == 'Used' ? 'selected' : '' }}>
                                                                    Used</option>
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
                                                                class="form-control"
                                                                value="{{ $product->parts->where('key', 'graphics_card_name')->first()->value ?? '' }}">
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
                                                                <option value="NVIDIA"
                                                                    {{ ($product->parts->where('key', 'graphics_card_brand')->first()->value ?? '') == 'NVIDIA' ? 'selected' : '' }}>
                                                                    NVIDIA</option>
                                                                <option value="AMD"
                                                                    {{ ($product->parts->where('key', 'graphics_card_brand')->first()->value ?? '') == 'AMD' ? 'selected' : '' }}>
                                                                    AMD</option>
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
                                                                <option value="1GB"
                                                                    {{ ($product->parts->where('key', 'graphics_card_memory')->first()->value ?? '') == '1GB' ? 'selected' : '' }}>
                                                                    1GB</option>
                                                                <option value="2GB"
                                                                    {{ ($product->parts->where('key', 'graphics_card_memory')->first()->value ?? '') == '2GB' ? 'selected' : '' }}>
                                                                    2GB</option>
                                                                <option value="3GB"
                                                                    {{ ($product->parts->where('key', 'graphics_card_memory')->first()->value ?? '') == '3GB' ? 'selected' : '' }}>
                                                                    3GB</option>
                                                                <option value="24GB"
                                                                    {{ ($product->parts->where('key', 'graphics_card_memory')->first()->value ?? '') == '24GB' ? 'selected' : '' }}>
                                                                    24GB</option>
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
                                                                <option value="New"
                                                                    {{ ($product->parts->where('key', 'graphics_card_condition')->first()->value ?? '') == 'New' ? 'selected' : '' }}>
                                                                    New</option>
                                                                <option value="Used"
                                                                    {{ ($product->parts->where('key', 'graphics_card_condition')->first()->value ?? '') == 'Used' ? 'selected' : '' }}>
                                                                    Used</option>
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
                                                                id="motherboard_name" class="form-control"
                                                                value="{{ $product->parts->where('key', 'motherboard_name')->first()->value ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="motherboard_brand" class="form-label">Motherboard
                                                                Brand</label>
                                                            <select name="motherboard_brand" id="motherboard_brand"
                                                                data-slug="motherboards" class="form-control">
                                                                <option value="">Select Motherboard Brand</option>
                                                                <option value="ASUS"
                                                                    {{ ($product->parts->where('key', 'motherboard_brand')->first()->value ?? '') == 'ASUS' ? 'selected' : '' }}>
                                                                    ASUS</option>
                                                                <option value="MSI"
                                                                    {{ ($product->parts->where('key', 'motherboard_brand')->first()->value ?? '') == 'MSI' ? 'selected' : '' }}>
                                                                    MSI</option>
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
                                                                <option value="New"
                                                                    {{ ($product->parts->where('key', 'motherboard_condition')->first()->value ?? '') == 'New' ? 'selected' : '' }}>
                                                                    New</option>
                                                                <option value="Used"
                                                                    {{ ($product->parts->where('key', 'motherboard_condition')->first()->value ?? '') == 'Used' ? 'selected' : '' }}>
                                                                    Used</option>
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
                                                                data-slug="rams" class="form-control"
                                                                value="{{ $product->parts->where('key', 'ram_name')->first()->value ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="ram_brand" class="form-label">RAM Brand</label>
                                                            <select name="ram_brand" id="ram_brand" class="form-control">
                                                                <option value="">Select RAM Brand</option>
                                                                <option value="Corsair"
                                                                    {{ ($product->parts->where('key', 'ram_brand')->first()->value ?? '') == 'Corsair' ? 'selected' : '' }}>
                                                                    Corsair</option>
                                                                <option value="G.SKILL"
                                                                    {{ ($product->parts->where('key', 'ram_brand')->first()->value ?? '') == 'G.SKILL' ? 'selected' : '' }}>
                                                                    G.SKILL</option>
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
                                                                <option value="1GB"
                                                                    {{ ($product->parts->where('key', 'ram_memory')->first()->value ?? '') == '1GB' ? 'selected' : '' }}>
                                                                    1GB</option>
                                                                <option value="2GB"
                                                                    {{ ($product->parts->where('key', 'ram_memory')->first()->value ?? '') == '2GB' ? 'selected' : '' }}>
                                                                    2GB</option>
                                                                <option value="3GB"
                                                                    {{ ($product->parts->where('key', 'ram_memory')->first()->value ?? '') == '3GB' ? 'selected' : '' }}>
                                                                    3GB</option>
                                                                <!-- Add more options as needed -->
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="ram_dimm" class="form-label">Ram Dimm Type</label>
                                                            <select name="ram_dimm" id="ram_dimm" class="form-control">
                                                                <option value="">Select Dimm Type</option>
                                                                <option value="DDR1"
                                                                    {{ ($product->parts->where('key', 'ram_dimm')->first()->value ?? '') == 'DDR1' ? 'selected' : '' }}>
                                                                    DDR1</option>
                                                                <option value="DDR2"
                                                                    {{ ($product->parts->where('key', 'ram_dimm')->first()->value ?? '') == 'DDR2' ? 'selected' : '' }}>
                                                                    DDR2</option>
                                                                <option value="DDR3"
                                                                    {{ ($product->parts->where('key', 'ram_dimm')->first()->value ?? '') == 'DDR3' ? 'selected' : '' }}>
                                                                    DDR3</option>
                                                                <option value="DDR4"
                                                                    {{ ($product->parts->where('key', 'ram_dimm')->first()->value ?? '') == 'DDR4' ? 'selected' : '' }}>
                                                                    DDR4</option>
                                                                <option value="DDR5"
                                                                    {{ ($product->parts->where('key', 'ram_dimm')->first()->value ?? '') == 'DDR5' ? 'selected' : '' }}>
                                                                    DDR5</option>
                                                                <option value="DDR6"
                                                                    {{ ($product->parts->where('key', 'ram_dimm')->first()->value ?? '') == 'DDR6' ? 'selected' : '' }}>
                                                                    DDR6</option>
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
                                                        $storages = collect();
                                                        $storageKeys = [
                                                            'storage_name',
                                                            'storage_brand',
                                                            'storage_type',
                                                            'storage_capacity',
                                                        ];
                                                        foreach ($storageKeys as $key) {
                                                            $storages = $storages->merge(
                                                                $product->parts
                                                                    ->where('key', $key)
                                                                    ->pluck('value', 'key'),
                                                            );
                                                        }
                                                        $storageGroups = $storages->groupBy(function ($item, $key) {
                                                            $index = null;
                                                            if (strpos($key, 'storage_name') === 0) {
                                                                $index = substr($key, 12);
                                                            }
                                                            if (strpos($key, 'storage_brand') === 0) {
                                                                $index = substr($key, 13);
                                                            }
                                                            if (strpos($key, 'storage_type') === 0) {
                                                                $index = substr($key, 12);
                                                            }
                                                            if (strpos($key, 'storage_capacity') === 0) {
                                                                $index = substr($key, 16);
                                                            }
                                                            return $index;
                                                        });
                                                    @endphp
                                                    @foreach ($storageGroups as $index => $storage)
                                                        <div class="row storage" data-id="{{ (int) $index + 1 }}"
                                                            id="storage_row_{{ (int) $index + 1 }}">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="storage_name_{{ (int) $index + 1 }}"
                                                                        class="form-label">Storage
                                                                        Device Name</label>
                                                                    <input type="text" name="storage_name[]"
                                                                        id="storage_name_{{ (int) $index + 1 }}"
                                                                        class="form-control"
                                                                        value="{{ $storage['storage_name'] ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="storage_brand_{{ (int) $index + 1 }}"
                                                                        class="form-label">Storage
                                                                        Brand</label>
                                                                    <select name="storage_brand[]"
                                                                        id="storage_brand_{{ (int) $index + 1 }}"
                                                                        class="form-control">
                                                                        <option value="">Select Brands</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="storage_type_{{ (int) $index + 1 }}"
                                                                        class="form-label">Storage
                                                                        Type</label>
                                                                    <select name="storage_type[]"
                                                                        id="storage_type_{{ (int) $index + 1 }}"
                                                                        class="form-control">
                                                                        <option value="">Select Storage Type</option>
                                                                        <option value="NVMe"
                                                                            {{ ($storage['storage_type'] ?? '') == 'NVMe' ? 'selected' : '' }}>
                                                                            NVMe</option>
                                                                        <option value="SSD"
                                                                            {{ ($storage['storage_type'] ?? '') == 'SSD' ? 'selected' : '' }}>
                                                                            SSD</option>
                                                                        <option value="HDD"
                                                                            {{ ($storage['storage_type'] ?? '') == 'HDD' ? 'selected' : '' }}>
                                                                            HDD</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="storage_capacity_{{ (int) $index + 1 }}"
                                                                        class="form-label">Storage
                                                                        Capacity</label>
                                                                    <select name="storage_capacity[]"
                                                                        id="storage_capacity_{{ (int) $index + 1 }}"
                                                                        class="form-control">
                                                                        <option value="">Select Storage Capacity
                                                                        </option>
                                                                        <option value="128GB"
                                                                            {{ ($storage['storage_capacity'] ?? '') == '128GB' ? 'selected' : '' }}>
                                                                            128GB</option>
                                                                        <option value="256GB"
                                                                            {{ ($storage['storage_capacity'] ?? '') == '256GB' ? 'selected' : '' }}>
                                                                            256GB</option>
                                                                        <option value="512GB"
                                                                            {{ ($storage['storage_capacity'] ?? '') == '512GB' ? 'selected' : '' }}>
                                                                            512GB</option>
                                                                        <option value="1TB"
                                                                            {{ ($storage['storage_capacity'] ?? '') == '1TB' ? 'selected' : '' }}>
                                                                            1TB</option>
                                                                        <option value="2TB"
                                                                            {{ ($storage['storage_capacity'] ?? '') == '2TB' ? 'selected' : '' }}>
                                                                            2TB</option>
                                                                        <option value="3TB"
                                                                            {{ ($storage['storage_capacity'] ?? '') == '3TB' ? 'selected' : '' }}>
                                                                            3TB</option>
                                                                        <option value="4TB"
                                                                            {{ ($storage['storage_capacity'] ?? '') == '4TB' ? 'selected' : '' }}>
                                                                            4TB</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            @if ($index != 0)
                                                                <div class="col-md-1 d-flex align-items-center">
                                                                    <button type="button"
                                                                        class="btn btn-danger remove-storage"
                                                                        data-id="{{ (int) $index + 1 }}">X</button>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                                @if (count($storageGroups) < 3)
                                                    <button class="btn btn-success" id="add-more-storage">Add More
                                                        Storage</button>
                                                @endif
                                            </div>

                                            <!-- Case -->
                                            <div class="col-md-12">
                                                <h4>Case</h4>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="case_name" class="form-label">Case Name</label>
                                                            <input type="text" name="case_name" id="case_name"
                                                                class="form-control"
                                                                value="{{ $product->parts->where('key', 'case_name')->first()->value ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="case_brand" class="form-label">Case Brand</label>
                                                            <select name="case_brand" data-slug="cases" id="case_brand"
                                                                class="form-control">
                                                                <option value="">Select Case Brand</option>
                                                                <option value="NZXT"
                                                                    {{ ($product->parts->where('key', 'case_brand')->first()->value ?? '') == 'NZXT' ? 'selected' : '' }}>
                                                                    NZXT</option>
                                                                <option value="Corsair"
                                                                    {{ ($product->parts->where('key', 'case_brand')->first()->value ?? '') == 'Corsair' ? 'selected' : '' }}>
                                                                    Corsair</option>
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
                                                                <option value="New"
                                                                    {{ ($product->parts->where('key', 'case_condition')->first()->value ?? '') == 'New' ? 'selected' : '' }}>
                                                                    New</option>
                                                                <option value="Used"
                                                                    {{ ($product->parts->where('key', 'case_condition')->first()->value ?? '') == 'Used' ? 'selected' : '' }}>
                                                                    Used</option>
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
                                                                class="form-control"
                                                                value="{{ $product->parts->where('key', 'cooler_name')->first()->value ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="cooler_brand" class="form-label">Cooler
                                                                Brand</label>
                                                            <select name="cooler_brand" data-slug="cooling"
                                                                id="cooler_brand" class="form-control">
                                                                <option value="">Select Cooler Brand</option>
                                                                <option value="Cooler Master"
                                                                    {{ ($product->parts->where('key', 'cooler_brand')->first()->value ?? '') == 'Cooler Master' ? 'selected' : '' }}>
                                                                    Cooler Master</option>
                                                                <option value="Corsair"
                                                                    {{ ($product->parts->where('key', 'cooler_brand')->first()->value ?? '') == 'Corsair' ? 'selected' : '' }}>
                                                                    Corsair</option>
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
                                                                <option value="New"
                                                                    {{ ($product->parts->where('key', 'cooler_condition')->first()->value ?? '') == 'New' ? 'selected' : '' }}>
                                                                    New</option>
                                                                <option value="Used"
                                                                    {{ ($product->parts->where('key', 'cooler_condition')->first()->value ?? '') == 'Used' ? 'selected' : '' }}>
                                                                    Used</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- PSU -->
                                            <div class="col-md-12">
                                                <h4>Power Supply Unit (PSU)</h4>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="psu_name" class="form-label">PSU Name</label>
                                                            <input type="text" name="psu_name" id="psu_name"
                                                                class="form-control"
                                                                value="{{ $product->parts->where('key', 'psu_name')->first()->value ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="psu_brand" class="form-label">PSU Brand</label>
                                                            <select name="psu_brand" data-slug="psu" id="psu_brand"
                                                                class="form-control">
                                                                <option value="">Select PSU Brand</option>
                                                                <option value="Corsair"
                                                                    {{ ($product->parts->where('key', 'psu_brand')->first()->value ?? '') == 'Corsair' ? 'selected' : '' }}>
                                                                    Corsair</option>
                                                                <option value="EVGA"
                                                                    {{ ($product->parts->where('key', 'psu_brand')->first()->value ?? '') == 'EVGA' ? 'selected' : '' }}>
                                                                    EVGA</option>
                                                                <option value="Seasonic"
                                                                    {{ ($product->parts->where('key', 'psu_brand')->first()->value ?? '') == 'Seasonic' ? 'selected' : '' }}>
                                                                    Seasonic</option>
                                                                <!-- Add more brands as needed -->
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="psu_condition"
                                                                class="form-label">Condition</label>
                                                            <select name="psu_condition" id="psu_condition"
                                                                class="form-control">
                                                                <option value="">Select Condition</option>
                                                                <option value="New"
                                                                    {{ ($product->parts->where('key', 'psu_condition')->first()->value ?? '') == 'New' ? 'selected' : '' }}>
                                                                    New</option>
                                                                <option value="Used"
                                                                    {{ ($product->parts->where('key', 'psu_condition')->first()->value ?? '') == 'Used' ? 'selected' : '' }}>
                                                                    Used</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="psu_watt" class="form-label">Psu Watt</label>
                                                            <input type="text" name="psu_watt" id="psu_watt"
                                                                class="form-control"
                                                                value="{{ $product->parts->where('key', 'psu_watt')->first()->value ?? '' }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            @php
                                                $additionalComponents = [
                                                    'keyboard' => [
                                                        'name' => 'keyboard_name',
                                                        'brand' => 'keyboard_brand',
                                                        'condition' => 'keyboard_condition',
                                                    ],
                                                    'monitor' => [
                                                        'name' => 'monitor_name',
                                                        'brand' => 'monitor_brand',
                                                        'size' => 'monitor_size',
                                                    ],
                                                    'mouse' => [
                                                        'name' => 'mouse_name',
                                                        'brand' => 'mouse_brand',
                                                        'type' => 'mouse_type',
                                                    ],
                                                    'headphones' => [
                                                        'name' => 'headphones_name',
                                                        'brand' => 'headphones_brand',
                                                        'condition' => 'headphones_condition',
                                                    ],
                                                ];
                                            @endphp

                                            @foreach ($additionalComponents as $componentKey => $componentFields)
                                                @if ($product->parts->where('key', $componentFields['name'])->first())
                                                    <div class="col-md-12" id="{{ $componentKey }}-form">
                                                        <h4>{{ ucfirst($componentKey) }}</h4>
                                                        <div class="row">
                                                            @if (isset($componentFields['name']))
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="{{ $componentFields['name'] }}"
                                                                            class="form-label">{{ ucfirst($componentKey) }}
                                                                            Name</label>
                                                                        <input type="text"
                                                                            name="{{ $componentFields['name'] }}"
                                                                            id="{{ $componentFields['name'] }}"
                                                                            class="form-control"
                                                                            value="{{ $product->parts->where('key', $componentFields['name'])->first()->value ?? '' }}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if (isset($componentFields['brand']))
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="{{ $componentFields['brand'] }}"
                                                                            class="form-label">{{ ucfirst($componentKey) }}
                                                                            Brand</label>
                                                                        <select name="{{ $componentFields['brand'] }}"
                                                                            id="{{ $componentFields['brand'] }}"
                                                                            class="form-control">
                                                                            <option value="">Select
                                                                                {{ ucfirst($componentKey) }} Brand</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if (isset($componentFields['condition']))
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="{{ $componentFields['condition'] }}"
                                                                            class="form-label">{{ ucfirst($componentKey) }}
                                                                            Condition</label>
                                                                        <select name="{{ $componentFields['condition'] }}"
                                                                            id="{{ $componentFields['condition'] }}"
                                                                            class="form-control">
                                                                            <option value="">Select Condition
                                                                            </option>
                                                                            <option value="New"
                                                                                {{ ($product->parts->where('key', $componentFields['condition'])->first()->value ?? '') == 'New' ? 'selected' : '' }}>
                                                                                New</option>
                                                                            <option value="Used"
                                                                                {{ ($product->parts->where('key', $componentFields['condition'])->first()->value ?? '') == 'Used' ? 'selected' : '' }}>
                                                                                Used</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if (isset($componentFields['size']))
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="{{ $componentFields['size'] }}"
                                                                            class="form-label">Monitor Size</label>
                                                                        <select name="{{ $componentFields['size'] }}"
                                                                            id="{{ $componentFields['size'] }}"
                                                                            class="form-control">
                                                                            <option value="">Select Size</option>
                                                                            <option value="24in"
                                                                                {{ ($product->parts->where('key', $componentFields['size'])->first()->value ?? '') == '24in' ? 'selected' : '' }}>
                                                                                24 inches</option>
                                                                            <option value="27in"
                                                                                {{ ($product->parts->where('key', $componentFields['size'])->first()->value ?? '') == '27in' ? 'selected' : '' }}>
                                                                                27 inches</option>
                                                                            <option value="32in"
                                                                                {{ ($product->parts->where('key', $componentFields['size'])->first()->value ?? '') == '32in' ? 'selected' : '' }}>
                                                                                32 inches</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if (isset($componentFields['type']))
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="{{ $componentFields['type'] }}"
                                                                            class="form-label">Mouse Type</label>
                                                                        <select name="{{ $componentFields['type'] }}"
                                                                            id="{{ $componentFields['type'] }}"
                                                                            class="form-control">
                                                                            <option value="">Select Mouse Type
                                                                            </option>
                                                                            <option value="Wireless"
                                                                                {{ ($product->parts->where('key', $componentFields['type'])->first()->value ?? '') == 'Wireless' ? 'selected' : '' }}>
                                                                                Wireless</option>
                                                                            <option value="Wired"
                                                                                {{ ($product->parts->where('key', $componentFields['type'])->first()->value ?? '') == 'Wired' ? 'selected' : '' }}>
                                                                                Wired</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <div class="col-md-3">
                                                                <button class="btn btn-danger delete-btn"
                                                                    data-component="{{ ucfirst($componentKey) }}">Delete</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                            <div class="col-md-12 my-5">
                                                <h4>Add More Component</h4>
                                                <select name="add_component" class="form-control" id="add_component">
                                                    <option value="Keyboard">Keyboard</option>
                                                    <option value="Monitor">Monitor</option>
                                                    <option value="Mouse">Mouse</option>
                                                    <option value="Headphones">Headphones</option>
                                                </select>
                                                <a class="btn btn-success mt-2 text-white" id="add-more-component">Add
                                                    Component</a>
                                            </div>
                                            <!-- Additonal Components -->
                                            <div id="additional_component" class="row">

                                            </div>

                                            @php
                                                $additionalParts = [
                                                    'fan' => [
                                                        'name' => 'fan_name',
                                                        'condition' => 'fan_condition',
                                                        'brand' => 'fan_brand',
                                                        'number' => 'fan_number',
                                                    ],
                                                    'gpu_stand' => [
                                                        'name' => 'gpu_stand_name',
                                                        'condition' => 'gpu_stand_condition',
                                                        'brand' => 'gpu_stand_brand',
                                                    ],
                                                    'case_parts' => [
                                                        'name' => 'case_parts_name',
                                                        'condition' => 'case_parts_condition',
                                                        'brand' => 'case_parts_brand',
                                                    ],
                                                ];
                                            @endphp
                                            @foreach ($additionalParts as $partKey => $partFields)
                                                @if ($product->parts->where('key', $partFields['name'])->first())
                                                    <div class="col-md-12"
                                                        id="{{ str_replace('_', '-', $partKey) }}-form">
                                                        <h4>{{ ucfirst(str_replace('_', ' ', $partKey)) }}</h4>
                                                        <div class="row">
                                                            @if (isset($partFields['name']))
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="{{ $partFields['name'] }}"
                                                                            class="form-label">{{ ucfirst(str_replace('_', ' ', $partKey)) }}
                                                                            Name</label>
                                                                        <input type="text"
                                                                            name="{{ $partFields['name'] }}"
                                                                            id="{{ $partFields['name'] }}"
                                                                            class="form-control"
                                                                            value="{{ $product->parts->where('key', $partFields['name'])->first()->value ?? '' }}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if (isset($partFields['condition']))
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="{{ $partFields['condition'] }}"
                                                                            class="form-label">{{ ucfirst(str_replace('_', ' ', $partKey)) }}
                                                                            Condition</label>
                                                                        <select name="{{ $partFields['condition'] }}"
                                                                            id="{{ $partFields['condition'] }}"
                                                                            class="form-control">
                                                                            <option value="">Select Condition
                                                                            </option>
                                                                            <option value="New"
                                                                                {{ ($product->parts->where('key', $partFields['condition'])->first()->value ?? '') == 'New' ? 'selected' : '' }}>
                                                                                New</option>
                                                                            <option value="Used"
                                                                                {{ ($product->parts->where('key', $partFields['condition'])->first()->value ?? '') == 'Used' ? 'selected' : '' }}>
                                                                                Used</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if (isset($partFields['brand']))
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="{{ $partFields['brand'] }}"
                                                                            class="form-label">{{ ucfirst(str_replace('_', ' ', $partKey)) }}
                                                                            Brand</label>
                                                                        <input type="text"
                                                                            name="{{ $partFields['brand'] }}"
                                                                            id="{{ $partFields['brand'] }}"
                                                                            class="form-control"
                                                                            value="{{ $product->parts->where('key', $partFields['brand'])->first()->value ?? '' }}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            @if (isset($partFields['number']))
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="{{ $partFields['number'] }}"
                                                                            class="form-label">Fan Number</label>
                                                                        <input type="text"
                                                                            name="{{ $partFields['number'] }}"
                                                                            id="{{ $partFields['number'] }}"
                                                                            class="form-control"
                                                                            value="{{ $product->parts->where('key', $partFields['number'])->first()->value ?? '' }}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <div class="col-md-3">
                                                                <button class="btn btn-danger delete-btn"
                                                                    data-part="{{ ucfirst(str_replace('_', ' ', $partKey)) }}">Delete</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach

                                            <div class="col-md-12 my-5">
                                                <h4>Add More Part</h4>
                                                <select name="add_part" class="form-control" id="add_part">
                                                    <option value="Fan">Fan</option>
                                                    <option value="GPU Stand">GPU Stand</option>
                                                    <option value="Case Parts">Case Parts</option>
                                                </select>
                                                <a class="btn btn-success mt-2 text-white" id="add-more-part">Add Part</a>
                                            </div>

                                            <div id="additional_part" class="row"></div>
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
                                            <input type="tel" name="price" id="price" class="form-control"
                                                value="{{ $product->price }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sp" class="form-label">Sale Price</label>
                                            <input type="text" name="sp" id="sp" class="form-control"
                                                value="{{ $product->sale_price }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="reason" class="form-label">Reason For Selling (Optional)</label>
                                            <textarea name="reason" class="form-control" id="reason" cols="30" rows="4">{{ $product->reason }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea name="description" class="form-control" id="description" cols="30" rows="10">{{ $product->description }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="d-flex flex-wrap gap-2 mb-2" id="currentImagesContainer">
                                            @if ($product->pictures)
                                                @foreach ($product->pictures as $picture)
                                                    <div class="position-relative border rounded p-1 d-inline-flex"
                                                        style="width: 100px; height: 100px">
                                                        <img src="{{ asset($picture->image) }}" alt="Product Image"
                                                            style="object-fit: cover; width: 100%; height: 100%;">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm position-absolute top-0 start-0 delete-current-image"
                                                            data-image="{{ $picture->image }}"
                                                            style="padding: 0; margin: 2px; height: 20px; width: 20px; font-size: 12px;">X</button>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <input type="file" class="filepond" name="file" id="images" multiple />
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-success">Update Product</button>
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
            var selectedYear = {{ $product->year_of_make }};


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
        }

        // Call the function to render the year select boxes when the page loads
        document.addEventListener('DOMContentLoaded', renderYearSelectBox);
    </script>

    {{-- Script For Getting Categories By Slug --}}
    <script>
        function getCategoriesBySlug(slug, compid, selected = null) {
            $.ajax({
                url: '/categoryget/' + slug, // API endpoint to get category by slug
                method: 'GET',
                success: function(data) {
                    // Check if the category and its brands exist in the response
                    if (data && data.category && data.category.brands && data.category.brands
                        .length > 0) {
                        $('#' + compid).empty();
                        $('#' + compid).append('<option value="">Select Brand</option>');

                        // Iterate through the brands array
                        $.each(data.category.brands, function(index, brand) {
                            var option = $('<option value="' + brand.name + '">' +
                                brand.name + '</option>');
                            if (selected == brand.name) {
                                option.attr('selected', 'selected');
                            }

                            $('#' + compid).append(option);
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

            let process_brand_selected =
                "{{ $product->parts->where('key', 'process_brand')->first()->value ?? '' }}";
            let graphics_card_brand_selected =
                "{{ $product->parts->where('key', 'graphics_card_brand')->first()->value ?? '' }}";
            let motherboard_brand_selected =
                "{{ $product->parts->where('key', 'motherboard_brand')->first()->value ?? '' }}";
            let ram_brand_selected = "{{ $product->parts->where('key', 'ram_brand')->first()->value ?? '' }}";
            let case_brand_selected = "{{ $product->parts->where('key', 'case_brand')->first()->value ?? '' }}";
            let cooler_brand_selected =
                "{{ $product->parts->where('key', 'cooler_brand')->first()->value ?? '' }}";
            let psu_brand_selected = "{{ $product->parts->where('key', 'psu_brand')->first()->value ?? '' }}";
            let storage_brand_selected1 =
                "{{ $product->parts->where('key', 'storage_brand')->first()->value ?? '' }}";
            // let storage_brand_selected2 = "{{ $product->parts->where('key', 'storage_brand')->skip(1)->first()->value ?? '' }}";
            //  let storage_brand_selected3 = "{{ $product->parts->where('key', 'storage_brand')->skip(2)->first()->value ?? '' }}";
            getCategoriesBySlug('processors', 'process_brand', process_brand_selected);
            getCategoriesBySlug('graphic-cards', 'graphics_card_brand', graphics_card_brand_selected);
            getCategoriesBySlug('motherboards', 'motherboard_brand', motherboard_brand_selected);
            getCategoriesBySlug('rams', 'ram_brand', ram_brand_selected);
            getCategoriesBySlug('cases', 'case_brand', case_brand_selected);
            getCategoriesBySlug('cooling', 'cooler_brand', cooler_brand_selected);
            getCategoriesBySlug('psu', 'psu_brand', psu_brand_selected);
            getCategoriesBySlug('storage', 'storage_brand_1', storage_brand_selected1);
            // getCategoriesBySlug('storage', 'storage_brand_2', storage_brand_selected2);
            // getCategoriesBySlug('storage', 'storage_brand_3', storage_brand_selected3);
            @foreach ($additionalComponents as $componentKey => $componentFields)
                @if (isset($componentFields['brand']) && $product->parts->where('key', $componentFields['brand'])->first())
                    let {{ $componentKey }}_brand_selected =
                        "{{ $product->parts->where('key', $componentFields['brand'])->first()->value ?? '' }}";
                    getCategoriesBySlug('{{ ucfirst($componentKey) }}', '{{ $componentFields['brand'] }}',
                        {{ $componentKey }}_brand_selected);
                @endif
            @endforeach
        });
    </script>
    {{-- Script For Storage --}}
    <script>
        let storageCounter = {{ count($storageGroups) }}; // Counter to keep track of unique IDs

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
    {{-- Script For Additonal Components  --}}
    <script>
        // Store original options to restore later
        // Component-specific variable names
        const componentSelect = document.getElementById('add_component');
        const originalComponentOptions = Array.from(componentSelect.options).map(option => ({
            value: option.value,
            text: option.text
        }));
        @foreach ($additionalComponents as $componentKey => $componentFields)
            @if ($product->parts->where('key', $componentFields['name'])->first())
                componentSelect.querySelector(`option[value="{{ ucfirst($componentKey) }}"]`).remove();
            @endif
        @endforeach

        document.getElementById('add-more-component').addEventListener('click', function() {
            const selectedComponent = componentSelect.value;
            const additionalComponentDiv = document.getElementById('additional_component');

            if (!selectedComponent) return;

            // Remove the selected option from dropdown completely
            for (let i = 0; i < componentSelect.options.length; i++) {
                if (componentSelect.options[i].value === selectedComponent) {
                    componentSelect.remove(i);
                    break;
                }
            }

            let componentForm = '';

            // Form templates (shortened for brevity - keep your existing templates)
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
                </div>`;
                getCategoriesBySlug('Keyboards', `keyboard_brand`);
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
            `
                getCategoriesBySlug('Monitors', `monitor_brand`);;
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
            `
                getCategoriesBySlug('Mouse', `mouse_brand`);;
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
            `
                getCategoriesBySlug('Headphones', `headphones_brand`);;
            }

            // Use insertAdjacentHTML instead of innerHTML += to preserve existing elements
            additionalComponentDiv.insertAdjacentHTML('beforeend', componentForm);

            // Reset select to first available option
            if (componentSelect.options.length > 0) {
                componentSelect.value = componentSelect.options[0].value;
            }
        });

        // Component delete handler
        document.getElementById('additional_component').addEventListener('click', function(event) {
            if (event.target.classList.contains('delete-btn')) {
                const componentType = event.target.dataset.component;
                const formToDelete = document.getElementById(`${componentType.toLowerCase()}-form`);

                // Restore to component options
                const originalOption = originalComponentOptions.find(opt => opt.value === componentType);
                if (originalOption) {
                    componentSelect.add(new Option(originalOption.text, originalOption.value));
                }
                formToDelete.remove();
            }
        });
    </script>
    {{-- Script For Additonal Parts  --}}

    <script>
        // Part-specific variable names
        const partSelect = document.getElementById('add_part');
        const originalPartOptions = Array.from(partSelect.options).map(option => ({
            value: option.value,
            text: option.text
        }));

        @foreach ($additionalParts as $partKey => $partFields)
            @if ($product->parts->where('key', $partFields['name'])->first())
                partSelect.querySelector(`option[value="{{ ucfirst(str_replace('_', ' ', $partKey)) }}"]`).remove();
            @endif
        @endforeach

        document.getElementById('add-more-part').addEventListener('click', function() {
            const selectedPart = partSelect.value;
            const additionalPartDiv = document.getElementById('additional_part');

            if (!selectedPart) return;

            // Remove the selected option from dropdown completely
            for (let i = 0; i < partSelect.options.length; i++) {
                if (partSelect.options[i].value === selectedPart) {
                    partSelect.remove(i);
                    break;
                }
            }

            let partForm = '';

            // Form templates for adding parts (Fan, GPU Stand, etc.)
            if (selectedPart === 'Fan') {
                partForm = `
                <div class="col-md-12" id="fan-form">
                    <h4>Fan</h4>
                    <div class="row">
                        <!-- Fan Form Fields -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="fan_name" class="form-label">Fan Name</label>
                                <input type="text" name="fan_name" id="fan_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="fan_condition" class="form-label">Fan Condition</label>
                                <select name="fan_condition" id="fan_condition" class="form-control">
                                    <option value="">Select Condition</option>
                                    <option value="New">New</option>
                                    <option value="Used">Used</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="fan_brand" class="form-label">Fan Brand</label>
                                <input type="text" name="fan_brand" id="fan_brand" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="fan_number" class="form-label">Fan Number</label>
                                <input type="text" name="fan_number" id="fan_number" class="form-control">
                            </div>
                        </div>
                         <div class="col-md-3">
                            <button class="btn btn-danger delete-btn" data-part="Fan">Delete</button>
                        </div>
                    </div>
                </div>`;
            } else if (selectedPart === 'GPU Stand') {
                partForm = `
                <div class="col-md-12" id="gpu-stand-form">
                    <h4>GPU Stand</h4>
                    <div class="row">
                        <!-- GPU Stand Form Fields -->
                         <div class="col-md-3">
                            <div class="form-group">
                                <label for="gpu_stand_name" class="form-label">GPU Stand Name</label>
                                <input type="text" name="gpu_stand_name" id="gpu_stand_name" class="form-control">
                            </div>
                        </div>
                         <div class="col-                                 md-3">
                                <div class="form-group">
                                    <label for="gpu_stand_condition" class="form-label">GPU Stand Condition</label>
                                    <select name="gpu_stand_condition" id="gpu_stand_condition" class="form-control">
                                        <option value="">Select Condition</option>
                                        <option value="New">New</option>
                                        <option value="Used">Used</option>
                                    </select>
                                </div>
                            </div>
                             <div class="col-md-3">
                                <div class="form-group">
                                    <label for="gpu_stand_brand" class="form-label">GPU Stand Brand</label>
                                    <input type="text" name="gpu_stand_brand" id="gpu_stand_brand" class="form-control">
                                </div>
                            </div>
                             <div class="col-md-3">
                                 <button class="btn btn-danger delete-btn" data-part="GPU Stand">Delete</button>
                             </div>
                        </div>
                    </div>`;
            } else if (selectedPart === 'Case Parts') {
                partForm = `
                    <div class="col-md-12" id="case-parts-form">
                        <h4>Case Parts</h4>
                        <div class="row">
                            <!-- Case Parts Form Fields -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="case_parts_name" class="form-label">Case Part Name</label>
                                    <input type="text" name="case_parts_name" id="case_parts_name" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="case_parts_condition" class="form-label">Case Part Condition</label>
                                    <select name="case_parts_condition" id="case_parts_condition" class="form-control">
                                        <option value="">Select Condition</option>
                                        <option value="New">New</option>
                                        <option value="Used">Used</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="case_parts_brand" class="form-label">Case Part Brand</label>
                                    <input type="text" name="case_parts_brand" id="case_parts_brand" class="form-control">
                                </div>
                            </div>
                             <div class="col-md-3">
                                 <button class="btn btn-danger delete-btn" data-part="Case Parts">Delete</button>
                             </div>
                        </div>
                    </div>`;
            }

            // Use insertAdjacentHTML instead of innerHTML += to preserve existing elements
            additionalPartDiv.insertAdjacentHTML('beforeend', partForm);

            // Reset select to first available option
            if (partSelect.options.length > 0) {
                partSelect.value = partSelect.options[0].value;
            }
        });

        // Part delete handler
        document.getElementById('additional_part').addEventListener('click', function(event) {
            if (event.target.classList.contains('delete-btn')) {
                const partType = event.target.dataset.part;
                const formID = `${partType.toLowerCase().replace(/\s+/g, '-')}-form`;
                const formToDelete = document.getElementById(formID);

                // Restore to part options
                const originalOption = originalPartOptions.find(opt => opt.value === partType);
                if (originalOption) {
                    partSelect.add(new Option(originalOption.text, originalOption.value));
                }
                formToDelete.remove();
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


            // Array to store deleted image paths
            let deletedImages = [];


            // AJAX Form Submission
            $('#productForm').submit(function(e) {
                e.preventDefault(); // Prevent default form submission

                // Clear previous errors
                $('.error').remove();

                // Get the form data
                var formData = new FormData(this);

                // Append the deleted images to the form data
                deletedImages.forEach(function(imagePath) {
                    formData.append('deleted_images[]', imagePath);
                });


                // Append files from FilePond to FormData
                let files = pond.getFiles();
                files.forEach(function(fileItem) {
                    if (fileItem.file) {
                        formData.append('file[]', fileItem.file); // Add each file from FilePond
                    }
                });

                // Send AJAX request
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            alert('Product updated successfully!');
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

            // Delete current image handler
            $('#currentImagesContainer').on('click', '.delete-current-image', function() {
                const imagePath = $(this).data('image');
                deletedImages.push(imagePath); // Add image to deleted array
                $(this).closest('.position-relative').remove();
            });
        });
    </script>
@endsection
