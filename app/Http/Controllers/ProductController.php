<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CompletePcPart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::with(['category', 'pictures'])->where('user_id', Auth::user()->id)->latest()->paginate(10);
        // return response()->json($product[0]);
        return view('dashboard.seller.products.index', compact('product'));
    }

    public function approved_products()
    {
        $product = Product::with('category', 'pictures')->where('status', 'approved')->where('user_id', Auth::user()->id)->latest()->paginate(10);
        return view('dashboard.seller.products.products', compact('product'));
    }
    public function pending_products()
    {
        $product = Product::with('category', 'pictures')->where('status', 'pending')->where('user_id', Auth::user()->id)->latest()->paginate(10);
        return view('dashboard.seller.products.products', compact('product'));
    }
    public function reject_products()
    {
        $product = Product::with('category', 'pictures')->where('status', 'rejected')->where('user_id', Auth::user()->id)->latest()->paginate(10);
        return view('dashboard.seller.products.products', compact('product'));
    }
    /*****************************************************
     *
     *
     * Helper Functions For Products
     *
     *
     *****************************************************/


    public function getBrands($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $brands = $category->brands()->get();
        return response()->json($brands);
    }

    public function getAttributesAndValues($categoryId)
    {
        $category = Category::findOrFail($categoryId);

        // Fetch attributes related to the category
        $attributes = $category->attributes; // Assuming Category has many-to-many with Attribute

        $attributesWithValues = [];

        foreach ($attributes as $attribute) {
            $attributeValues = $attribute->values; // Get values for each attribute
            $attributesWithValues[] = [
                'attribute' => $attribute,
                'values' => $attributeValues
            ];
        }

        return response()->json($attributesWithValues);
    }

    public function findCategoryBySlug($slug)
    {
        // Find the category by slug
        $category = Category::where('slug', $slug)->with('brands')->first(); // Eager load the brands

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return response()->json([
            'category' => $category
        ]);
    }

    /*****************************************************
     *
     *
     * New Product Functions
     *
     *
     *****************************************************/

    public function show_add_new_product_page()
    {
        $category = Category::all();
        return view('dashboard.seller.products.types.add-new-product.add-new-product', compact('category'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validate input
            $validatedData = $request->validate([
                'product_name' => 'required|string|max:255',
                'category_name' => 'required|exists:categories,id',
                'brand_name' => 'required|exists:brands,id',
                'warranty' => 'required|string',
                'price' => 'required|numeric',
                'sp' => 'nullable|numeric',
                'sku' => 'required|string|max:255',
                'stock' => 'required|integer|min:0',
                'reason' => 'nullable|string',
                'year' => 'required',
                'description' => 'nullable|string',
                'file' => 'required|array|min:4|max:10', // Max 10 files
                'file.*' => 'file|mimes:jpeg,png,jpg|max:2048', // Secure file types & size validation
            ]);

            $sellerName = Auth::user()->first_name;
            $slug = Product::generateSlug($validatedData['product_name'], $sellerName);
            $status = 'pending';
            if (Auth::user()->verification !== 'Unverified' && Auth::user()->verification !== 'pending') {
                $status = 'approved';
            }

            // Store product data
            $product = Product::create([
                'product_name' => $validatedData['product_name'],
                'category_id' => $validatedData['category_name'],
                'brand_id' => $validatedData['brand_name'],
                'slug' => $slug,
                'warranty' => $validatedData['warranty'],
                'price' => $validatedData['price'],
                'year_of_make' => $validatedData['year'],
                'condition' => 'new',
                'reason' => $validatedData['reason'],
                'sale_price' => $validatedData['sp'],
                'sku' => $validatedData['sku'],
                'stock_quanity' => $validatedData['stock'],
                'description' => $validatedData['description'],
                'user_id' => Auth::user()->id,
                'product_type' => 'new',
                'repaired' => null,
                'status' => $status
            ]);

            // Attach attributes
            if ($request->has('attribute')) {
                foreach ($request->attribute as $attributeId => $value) {
                    $attributeValue = \App\Models\AttributeValue::find($value);

                    if ($attributeValue) {
                        $product->attributes()->attach($attributeId, [
                            'attribute_value_id' => $attributeValue->id,
                        ]);
                    }
                }
            }

            // Handle file uploads
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $file) {
                    $path = public_path('images/products');

                    // Create the directory if it doesn't exist
                    if (!is_dir($path)) {
                        mkdir($path, 0777, true);
                    }

                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move($path, $fileName);

                    // Attach the image path to the product
                    $product->pictures()->create(['image' => 'images/products/' . $fileName]);
                }
            }

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Product added successfully!',
            ]);
        } catch (\Exception $e) {
            // Rollback the transaction if any exception occurs
            DB::rollBack();

            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the product.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function edit($id)
    {
        // Fetch the product along with relationships
        $product = Product::with(['category', 'brand', 'attributes', 'pictures'])
            ->findOrFail($id);


        // Get all categories for the dropdown
        $categories = Category::all();
        return response()->json('Hello');
        // Return a view (you can name it however you like)
        // e.g. `edit-product.blade.php` inside the same folder structure
        return view('dashboard.seller.products.types.add-new-product.edit-new-product', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            // Validate input
            $validatedData = $request->validate([
                'product_name'   => 'required|string|max:255',
                'category_name'  => 'required|exists:categories,id',
                'brand_name'     => 'required|exists:brands,id',
                'warranty'       => 'required|string',
                'price'          => 'required|numeric',
                'sp'             => 'nullable|numeric',
                'sku'            => 'required|string|max:255',
                'stock'          => 'required|integer|min:0',
                'reason'         => 'nullable|string',
                'year'           => 'required',
                'description'    => 'nullable|string',
                'remove_images' => 'array',         // optional array of picture IDs to remove
                'remove_images.*' => 'numeric',     // each must be a number (the picture ID)
                'file'   => 'nullable|array|max:10', // up to 10 new files
                'file.*' => 'file|mimes:jpeg,png,jpg|max:2048',
            ]);

            // Find existing product
            $product = Product::findOrFail($id);
            // Update product fields
            $product->update([
                'product_name'   => $validatedData['product_name'],
                'category_id'    => $validatedData['category_name'],
                'brand_id'       => $validatedData['brand_name'],
                'warranty'       => $validatedData['warranty'],
                'price'          => $validatedData['price'],
                'sale_price'     => $validatedData['sp'],
                'sku'            => $validatedData['sku'],
                'stock_quanity'  => $validatedData['stock'],
                'year_of_make'   => $validatedData['year'],
                'description'    => $validatedData['description'],
                // 'reason' is optional in your table; include it if you store it:
                'reason'         => $validatedData['reason'] ?? null,
            ]);

            // Detach existing attribute pivot data
            $product->attributes()->detach();

            // If attributes are provided, re-attach them
            if ($request->has('attribute')) {
                foreach ($request->attribute as $attributeId => $value) {
                    $attributeValue = \App\Models\AttributeValue::find($value);

                    if ($attributeValue) {
                        $product->attributes()->attach($attributeId, [
                            'attribute_value_id' => $attributeValue->id,
                        ]);
                    }
                }
            }

            // 4) Remove any pictures marked for deletion
            $removeImages = $request->input('remove_images', []);
            if (!empty($removeImages)) {
                // Eager load pictures to avoid N+1
                $product->load('pictures');

                foreach ($product->pictures as $pic) {
                    if (in_array($pic->id, $removeImages)) {
                        // Delete the file from disk
                        $imagePath = public_path($pic->image);
                        if (File::exists($imagePath)) {
                            File::delete($imagePath);
                        }
                        // Delete the record from DB
                        $pic->delete();
                    }
                }
            }

            // 5) Handle uploading new pictures
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $file) {
                    $path = public_path('images/products');
                    if (!is_dir($path)) {
                        mkdir($path, 0777, true);
                    }

                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move($path, $fileName);

                    $product->pictures()->create([
                        'image' => 'images/products/' . $fileName
                    ]);
                }
            }

            DB::commit();

            // Return a JSON response if you're handling this via AJAX
            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the product.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }


    /*****************************************************
     *
     *
     * Used Product Functions
     *
     *
     *****************************************************/

    public function show_add_used_product_page()
    {
        $category = Category::all();
        return view('dashboard.seller.products.types.add-used-product.add-used-product', compact('category'));
    }

    public function edit_used($id)
    {
        // Fetch the product along with relationships
        $product = Product::with(['category', 'brand', 'attributes', 'pictures'])
            ->findOrFail($id);

        // Get all categories for the dropdown
        $categories = Category::all();

        // Return a view (you can name it however you like)
        // e.g. `edit-product.blade.php` inside the same folder structure
        return view('dashboard.seller.products.types.add-used-product.edit-used-product', compact('product', 'categories'));
    }

    public function store_used(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validate input
            $validatedData = $request->validate([
                'product_name' => 'required|string|max:255',
                'category_name' => 'required|exists:categories,id',
                'brand_name' => 'required|exists:brands,id',
                'warranty' => 'required|string',
                'price' => 'required|numeric',
                'sp' => 'nullable|numeric',
                'sku' => 'required|string|max:255',
                'stock' => 'required|integer|min:0',
                'reason' => 'nullable|string',
                'year' => 'required',
                'description' => 'nullable|string',
                'repaired' => 'nullable|string',
                'file' => 'required|array|min:4|max:10', // Max 10 files
                'file.*' => 'file|mimes:jpeg,png,jpg|max:2048', // Secure file types & size validation
            ]);

            $sellerName = Auth::user()->first_name;
            $slug = Product::generateSlug($validatedData['product_name'], $sellerName);
            $status = 'pending';
            if (Auth::user()->verification !== 'Unverified' && Auth::user()->verification !== 'pending') {
                $status = 'approved';
            }
            // Store product data
            $product = Product::create([
                'product_name' => $validatedData['product_name'],
                'category_id' => $validatedData['category_name'],
                'brand_id' => $validatedData['brand_name'],
                'slug' => $slug,
                'reason' => $validatedData['reason'],
                'repaired' => $validatedData['repaired'],
                'warranty' => $validatedData['warranty'],
                'price' => $validatedData['price'],
                'year_of_make' => $validatedData['year'],
                'condition' => 'used',
                'product_type' => 'used',
                'sale_price' => $validatedData['sp'],
                'sku' => $validatedData['sku'],
                'stock_quanity' => $validatedData['stock'],
                'description' => $validatedData['description'],
                'user_id' => Auth::user()->id,
                'status' => $status
            ]);

            // Attach attributes
            if ($request->has('attribute')) {
                foreach ($request->attribute as $attributeId => $value) {
                    $attributeValue = \App\Models\AttributeValue::find($value);

                    if ($attributeValue) {
                        $product->attributes()->attach($attributeId, [
                            'attribute_value_id' => $attributeValue->id,
                        ]);
                    }
                }
            }

            // Handle file uploads
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $file) {
                    $path = public_path('images/products');

                    // Create the directory if it doesn't exist
                    if (!is_dir($path)) {
                        mkdir($path, 0777, true);
                    }

                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move($path, $fileName);

                    // Attach the image path to the product
                    $product->pictures()->create(['image' => 'images/products/' . $fileName]);
                }
            }

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Product added successfully!',
            ]);
        } catch (\Exception $e) {
            // Rollback the transaction if any exception occurs
            DB::rollBack();

            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the product.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update_used(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            // Validate input
            $validatedData = $request->validate([
                'product_name'   => 'required|string|max:255',
                'category_name'  => 'required|exists:categories,id',
                'brand_name'     => 'required|exists:brands,id',
                'warranty'       => 'required|string',
                'price'          => 'required|numeric',
                'sp'             => 'nullable|numeric',
                'sku'            => 'required|string|max:255',
                'stock'          => 'required|integer|min:0',
                'reason'         => 'nullable|string',
                'repaired'       => 'nullable|string',
                'year'           => 'required',
                'description'    => 'nullable|string',
                'remove_images' => 'array',         // optional array of picture IDs to remove
                'remove_images.*' => 'numeric',     // each must be a number (the picture ID)
                'file'   => 'nullable|array|max:10', // up to 10 new files
                'file.*' => 'file|mimes:jpeg,png,jpg|max:2048',
            ]);

            // Find existing product
            $product = Product::findOrFail($id);

            // Update product fields
            $product->update([
                'product_name'   => $validatedData['product_name'],
                'category_id'    => $validatedData['category_name'],
                'brand_id'       => $validatedData['brand_name'],
                'warranty'       => $validatedData['warranty'],
                'price'          => $validatedData['price'],
                'sale_price'     => $validatedData['sp'],
                'sku'            => $validatedData['sku'],
                'stock_quanity'  => $validatedData['stock'],
                'year_of_make'   => $validatedData['year'],
                'description'    => $validatedData['description'],
                'reason'         => $validatedData['reason'] ?? null,
                'repaired'       => $validatedData['repaired'] ?? null
            ]);

            // Detach existing attribute pivot data
            $product->attributes()->detach();

            // If attributes are provided, re-attach them
            if ($request->has('attribute')) {
                foreach ($request->attribute as $attributeId => $value) {
                    $attributeValue = \App\Models\AttributeValue::find($value);

                    if ($attributeValue) {
                        $product->attributes()->attach($attributeId, [
                            'attribute_value_id' => $attributeValue->id,
                        ]);
                    }
                }
            }

            // 4) Remove any pictures marked for deletion
            $removeImages = $request->input('remove_images', []);
            if (!empty($removeImages)) {
                // Eager load pictures to avoid N+1
                $product->load('pictures');

                foreach ($product->pictures as $pic) {
                    if (in_array($pic->id, $removeImages)) {
                        // Delete the file from disk
                        $imagePath = public_path($pic->image);
                        if (File::exists($imagePath)) {
                            File::delete($imagePath);
                        }
                        // Delete the record from DB
                        $pic->delete();
                    }
                }
            }

            // 5) Handle uploading new pictures
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $file) {
                    $path = public_path('images/products');
                    if (!is_dir($path)) {
                        mkdir($path, 0777, true);
                    }

                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move($path, $fileName);

                    $product->pictures()->create([
                        'image' => 'images/products/' . $fileName
                    ]);
                }
            }

            DB::commit();

            // Return a JSON response if you're handling this via AJAX
            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the product.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /*****************************************************
     *
     *
     * Complete Pc Product Product Functions
     *
     *
     *****************************************************/

    public function show_add_complete_pc_product_page()
    {
        $category = Category::all();
        return view('dashboard.seller.products.types.add-complete-pc-build.add-complete-pc-build', compact('category'));
    }

    public function store_complete_pc(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validate input
            $validatedData = $request->validate([
                '_token' => 'required|string',
                'product_name' => 'required|string|max:255',
                'warranty' => 'required|string',
                'sku' => 'required|string|max:255',
                'year' => 'required|integer|min:1900|max:' . date('Y'),
                'process_name' => 'required|string|max:255',
                'process_brand' => 'required|string|max:255',
                'process_gen_year' => 'required|integer|min:1900|max:' . date('Y'),
                'process_condition' => 'required|string|max:255',
                'graphics_card_name' => 'required|string|max:255',
                'graphics_card_brand' => 'required|string|max:255',
                'graphics_card_memory' => 'required|string|max:10',
                'graphics_card_condition' => 'required|string|in:New,Used',
                'motherboard_name' => 'required|string|max:255',
                'motherboard_brand' => 'required|string|max:255',
                'motherboard_condition' => 'required|string|in:New,Used',
                'ram_name' => 'required|string|max:255',
                'ram_brand' => 'required|string|max:255',
                'ram_memory' => 'required|string|max:10',
                'ram_dimm' => 'required|string',
                'storage_name' => 'required|array|min:1',
                'storage_name.*' => 'required|string|max:255',
                'storage_brand' => 'required|array|min:1',
                'storage_brand.*' => 'required|string|max:255',
                'storage_type' => 'required|array|min:1',
                'storage_type.*' => 'required|string|in:HDD,SSD,NVMe',
                'storage_capacity' => 'required|array|min:1',
                'storage_capacity.*' => 'required|string|max:10',
                'case_name' => 'required|string|max:255',
                'case_brand' => 'required|string|max:255',
                'case_condition' => 'required|string|in:New,Used',
                'cooler_name' => 'required|string|max:255',
                'cooler_brand' => 'required|string|max:255',
                'cooler_condition' => 'required|string|in:New,Used',
                'psu_name' => 'required|string|max:255',
                'psu_brand' => 'required|string|max:255',
                'psu_condition' => 'required|string',
                'psu_watt' => 'required|string',
                'price' => 'required|numeric|min:0',
                'sp' => 'nullable|numeric|min:0',
                'reason' => 'nullable|string|max:500',
                'description' => 'required|string|max:1000',
                'file' => 'required|array|min:4|max:10',
                'file.*' => 'file|mimes:jpeg,png,jpg|max:2048',

                // Additional Components
                'keyboard_name' => 'nullable|string|max:255',
                'keyboard_brand' => 'nullable|required_with:keyboard_name|string|max:255',
                'keyboard_condition' => 'nullable|required_with:keyboard_name|string|in:New,Used',
                'monitor_name' => 'nullable|string|max:255',
                'monitor_brand' => 'nullable|required_with:monitor_name|string|max:255',
                'monitor_size' => 'nullable|required_with:monitor_name|string|max:10',
                'mouse_name' => 'nullable|string|max:255',
                'mouse_brand' => 'nullable|required_with:mouse_name|string|max:255',
                'mouse_type' => 'nullable|required_with:mouse_name|string|max:255',
                'headphones_name' => 'nullable|string|max:255',
                'headphones_brand' => 'nullable|required_with:headphones_name|string|max:255',
                'headphones_condition' => 'nullable|required_with:headphones_name|string|max:255',

                // Addition Parts
                'fan_name' => 'nullable|string|max:255',
                'fan_condition' => 'nullable|required_with:fan_name|string|max:255',
                'fan_brand' => 'nullable|required_with:fan_name|string|max:255',
                'fan_number' => 'nullable|required_with:fan_name|string|max:255',
                'gpu_stand_name' => 'nullable|string|max:255',
                'gpu_stand_condition' => 'nullable|required_with:gpu_stand_name|string|max:255',
                'gpu_stand_brand' => 'nullable|required_with:gpu_stand_name|string|max:255',
                'case_parts_name' => 'nullable|string|max:255',
                'case_parts_condition' => 'nullable|required_with:case_parts_name|string|max:255',
                'case_parts_brand' => 'nullable|required_with:case_parts_name|string|max:255',



            ]);


            $sellerName = Auth::user()->first_name;
            $slug = Product::generateSlug($validatedData['product_name'], $sellerName);
            $status = 'pending';
            if (Auth::user()->verification !== 'Unverified' && Auth::user()->verification !== 'pending') {
                $status = 'approved';
            }
            // Store product data
            $product = Product::create([
                'product_name' => $validatedData['product_name'],
                'slug' => $slug,
                'warranty' => $validatedData['warranty'],
                'price' => $validatedData['price'],
                'year_of_make' => $validatedData['year'],
                'sale_price' => $validatedData['sp'],
                'sku' => $validatedData['sku'],
                'stock_quanity' => 1,
                'description' => $validatedData['description'],
                'product_type' => 'complete_pc',
                'user_id' => Auth::user()->id,
                'status' => $status
            ]);
            $pcPartsData = [
                ['key' => 'process_name', 'value' => $validatedData['process_name']],
                ['key' => 'process_brand', 'value' => $validatedData['process_brand']],
                ['key' => 'process_condition', 'value' => $validatedData['process_condition']],
                ['key' => 'process_gen_year', 'value' => $validatedData['process_gen_year']],

                ['key' => 'graphics_card_name', 'value' => $validatedData['graphics_card_name']],
                ['key' => 'graphics_card_brand', 'value' => $validatedData['graphics_card_brand']],
                ['key' => 'graphics_card_condition', 'value' => $validatedData['graphics_card_condition']],
                ['key' => 'graphics_card_memory', 'value' => $validatedData['graphics_card_memory']],

                ['key' => 'motherboard_name', 'value' => $validatedData['motherboard_name']],
                ['key' => 'motherboard_brand', 'value' => $validatedData['motherboard_brand']],
                ['key' => 'motherboard_condition', 'value' => $validatedData['graphics_card_memory']],

                ['key' => 'ram_name', 'value' => $validatedData['ram_name']],
                ['key' => 'ram_brand', 'value' => $validatedData['ram_brand']],
                ['key' => 'ram_dimm', 'value' => $validatedData['ram_dimm']],
                ['key' => 'ram_memory', 'value' => $validatedData['ram_memory']],


                ['key' => 'case_name', 'value' => $validatedData['case_name']],
                ['key' => 'case_condition', 'value' => $validatedData['case_condition']],
                ['key' => 'case_brand', 'value' => $validatedData['case_brand']],

                ['key' => 'cooler_name', 'value' => $validatedData['cooler_name']],
                ['key' => 'cooler_condition', 'value' => $validatedData['cooler_condition']],
                ['key' => 'cooler_brand', 'value' => $validatedData['cooler_brand']],

                ['key' => 'psu_name', 'value' => $validatedData['psu_name']],
                ['key' => 'psu_brand', 'value' => $validatedData['psu_brand']],
                ['key' => 'psu_condition', 'value' => $validatedData['psu_condition']],
            ];


            $additionalPartsData = [];

            // Handle Keyboard
            if (!empty($validatedData['keyboard_name'])) {
                $additionalPartsData[] = ['key' => 'keyboard_name', 'value' => $validatedData['keyboard_name']];
                $additionalPartsData[] = ['key' => 'keyboard_brand', 'value' => $validatedData['keyboard_brand'] ?? ''];
                $additionalPartsData[] = ['key' => 'keyboard_condition', 'value' => $validatedData['keyboard_condition'] ?? ''];
            }

            // Handle Monitor
            if (!empty($validatedData['monitor_name'])) {
                $additionalPartsData[] = ['key' => 'monitor_name', 'value' => $validatedData['monitor_name']];
                $additionalPartsData[] = ['key' => 'monitor_brand', 'value' => $validatedData['monitor_brand'] ?? ''];
                $additionalPartsData[] = ['key' => 'monitor_size', 'value' => $validatedData['monitor_size'] ?? ''];
            }

            // Handle Mouse
            if (!empty($validatedData['mouse_name'])) {
                $additionalPartsData[] = ['key' => 'mouse_name', 'value' => $validatedData['mouse_name']];
                $additionalPartsData[] = ['key' => 'mouse_brand', 'value' => $validatedData['mouse_brand'] ?? ''];
                $additionalPartsData[] = ['key' => 'mouse_type', 'value' => $validatedData['mouse_type'] ?? ''];
            }

            // Handle Headphones
            if (!empty($validatedData['headphones_name'])) {
                $additionalPartsData[] = ['key' => 'headphones_name', 'value' => $validatedData['headphones_name']];
                $additionalPartsData[] = ['key' => 'headphones_brand', 'value' => $validatedData['headphones_brand'] ?? ''];
                $additionalPartsData[] = ['key' => 'headphones_condition', 'value' => $validatedData['headphones_condition'] ?? ''];
            }

            // Additional Parts
            if (!empty($validatedData['fan_name'])) {
                $additionalPartsData[] = ['key' => 'fan_name', 'value' => $validatedData['fan_name']];
                $additionalPartsData[] = ['key' => 'fan_condition', 'value' => $validatedData['fan_condition'] ?? ''];
                $additionalPartsData[] = ['key' => 'fan_brand', 'value' => $validatedData['fan_brand'] ?? ''];
                $additionalPartsData[] = ['key' => 'fan_number', 'value' => $validatedData['fan_number'] ?? ''];
            }

            if (!empty($validatedData['gpu_stand_name'])) {
                $additionalPartsData[] = ['key' => 'gpu_stand_name', 'value' => $validatedData['gpu_stand_name']];
                $additionalPartsData[] = ['key' => 'gpu_stand_condition', 'value' => $validatedData['gpu_stand_condition'] ?? ''];
                $additionalPartsData[] = ['key' => 'gpu_stand_brand', 'value' => $validatedData['gpu_stand_brand'] ?? ''];
            }

            if (!empty($validatedData['case_parts_name'])) {
                $additionalPartsData[] = ['key' => 'case_parts_name', 'value' => $validatedData['case_parts_name']];
                $additionalPartsData[] = ['key' => 'case_parts_condition', 'value' => $validatedData['case_parts_condition'] ?? ''];
                $additionalPartsData[] = ['key' => 'case_parts_brand', 'value' => $validatedData['case_parts_brand'] ?? ''];
            }

            $pcPartsData = array_merge($pcPartsData, $additionalPartsData);



            // For Storage

            $storageData = [];

            // Required first storage entry
            $storageData[] = ['key' => 'storage_brand', 'value' => $validatedData['storage_brand'][0]];
            $storageData[] = ['key' => 'storage_capacity', 'value' => $validatedData['storage_capacity'][0]];
            $storageData[] = ['key' => 'storage_name', 'value' => $validatedData['storage_name'][0]];
            $storageData[] = ['key' => 'storage_type', 'value' => $validatedData['storage_type'][0]];

            // Check for second storage entry
            if (!empty($validatedData['storage_brand'][1])) {
                $storageData[] = ['key' => 'storage_brand', 'value' => $validatedData['storage_brand'][1]];
                $storageData[] = ['key' => 'storage_capacity', 'value' => $validatedData['storage_capacity'][1]];
                $storageData[] = ['key' => 'storage_name', 'value' => $validatedData['storage_name'][1]];
                $storageData[] = ['key' => 'storage_type', 'value' => $validatedData['storage_type'][1]];
            }

            // Check for third storage entry
            if (!empty($validatedData['storage_brand'][2])) {
                $storageData[] = ['key' => 'storage_brand', 'value' => $validatedData['storage_brand'][2]];
                $storageData[] = ['key' => 'storage_capacity', 'value' => $validatedData['storage_capacity'][2]];
                $storageData[] = ['key' => 'storage_name', 'value' => $validatedData['storage_name'][2]];
                $storageData[] = ['key' => 'storage_type', 'value' => $validatedData['storage_type'][2]];
            }

            $pcPartsData = array_merge($pcPartsData, $storageData);



            $product->parts()->createMany($pcPartsData);


            // Handle file uploads
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $file) {
                    $path = public_path('images/products');

                    // Create the directory if it doesn't exist
                    if (!is_dir($path)) {
                        mkdir($path, 0777, true);
                    }

                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move($path, $fileName);

                    // Attach the image path to the product
                    $product->pictures()->create(['image' => 'images/products/' . $fileName]);
                }
            }

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Product added successfully!',
            ]);
        } catch (\Exception $e) {
            // Rollback the transaction if any exception occurs
            DB::rollBack();

            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the product.',
                'error' => $e->getMessage(),
            ], 500);
            return response()->json($req->all());
        }
    }



    public function edit_complete_pc($id)
    {
        $product = Product::with('parts', 'pictures')->findOrFail($id);
        return view('dashboard.seller.products.types.add-complete-pc-build.edit-complete-pc-build', compact('product'));
    }

    public function update_complete_pc(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            // Validate input
            $validatedData = $request->validate([
                '_token' => 'required|string',
                'product_name' => 'required|string|max:255',
                'warranty' => 'required|string',
                'sku' => 'required|string|max:255',
                'year' => 'required|integer|min:1900|max:' . date('Y'),
                'process_name' => 'required|string|max:255',
                'process_brand' => 'required|string|max:255',
                'process_gen_year' => 'required|integer|min:1900|max:' . date('Y'),
                'process_condition' => 'required|string|max:255',
                'graphics_card_name' => 'required|string|max:255',
                'graphics_card_brand' => 'required|string|max:255',
                'graphics_card_memory' => 'required|string|max:10',
                'graphics_card_condition' => 'required|string|in:New,Used',
                'motherboard_name' => 'required|string|max:255',
                'motherboard_brand' => 'required|string|max:255',
                'motherboard_condition' => 'required|string|in:New,Used',
                'ram_name' => 'required|string|max:255',
                'ram_brand' => 'required|string|max:255',
                'ram_memory' => 'required|string|max:10',
                'ram_dimm' => 'required|string',
                'storage_name' => 'required|array|min:1',
                'storage_name.*' => 'required|string|max:255',
                'storage_brand' => 'required|array|min:1',
                'storage_brand.*' => 'required|string|max:255',
                'storage_type' => 'required|array|min:1',
                'storage_type.*' => 'required|string|in:HDD,SSD,NVMe',
                'storage_capacity' => 'required|array|min:1',
                'storage_capacity.*' => 'required|string|max:10',
                'case_name' => 'required|string|max:255',
                'case_brand' => 'required|string|max:255',
                'case_condition' => 'required|string|in:New,Used',
                'cooler_name' => 'required|string|max:255',
                'cooler_brand' => 'required|string|max:255',
                'cooler_condition' => 'required|string|in:New,Used',
                'psu_name' => 'required|string|max:255',
                'psu_brand' => 'required|string|max:255',
                'psu_condition' => 'required|string',
                'psu_watt' => 'required|string',
                'price' => 'required|numeric|min:0',
                'sp' => 'nullable|numeric|min:0',
                'reason' => 'nullable|string|max:500',
                'description' => 'required|string|max:1000',
                'file' => 'nullable|array',
                'file.*' => 'file|mimes:jpeg,png,jpg|max:2048',
                'deleted_images' => 'nullable|array',

                // Additional Components
                'keyboard_name' => 'nullable|string|max:255',
                'keyboard_brand' => 'nullable|required_with:keyboard_name|string|max:255',
                'keyboard_condition' => 'nullable|required_with:keyboard_name|string|in:New,Used',
                'monitor_name' => 'nullable|string|max:255',
                'monitor_brand' => 'nullable|required_with:monitor_name|string|max:255',
                'monitor_size' => 'nullable|required_with:monitor_name|string|max:10',
                'mouse_name' => 'nullable|string|max:255',
                'mouse_brand' => 'nullable|required_with:mouse_name|string|max:255',
                'mouse_type' => 'nullable|required_with:mouse_name|string|max:255',
                'headphones_name' => 'nullable|string|max:255',
                'headphones_brand' => 'nullable|required_with:headphones_name|string|max:255',
                'headphones_condition' => 'nullable|required_with:headphones_name|string|max:255',

                // Addition Parts
                'fan_name' => 'nullable|string|max:255',
                'fan_condition' => 'nullable|required_with:fan_name|string|max:255',
                'fan_brand' => 'nullable|required_with:fan_name|string|max:255',
                'fan_number' => 'nullable|required_with:fan_name|string|max:255',
                'gpu_stand_name' => 'nullable|string|max:255',
                'gpu_stand_condition' => 'nullable|required_with:gpu_stand_name|string|max:255',
                'gpu_stand_brand' => 'nullable|required_with:gpu_stand_name|string|max:255',
                'case_parts_name' => 'nullable|string|max:255',
                'case_parts_condition' => 'nullable|required_with:case_parts_name|string|max:255',
                'case_parts_brand' => 'nullable|required_with:case_parts_name|string|max:255',
            ]);

            // Find the product
            $product = Product::findOrFail($id);

            $sellerName = Auth::user()->first_name;
            $slug = Product::generateSlug($validatedData['product_name'], $sellerName);

            // Update product data
            $product->update([
                'product_name' => $validatedData['product_name'],
                'slug' => $slug,
                'warranty' => $validatedData['warranty'],
                'price' => $validatedData['price'],
                'year_of_make' => $validatedData['year'],
                'sale_price' => $validatedData['sp'],
                'sku' => $validatedData['sku'],
                'description' => $validatedData['description'],
            ]);

            // Update/create PC Parts
            $pcPartsData = [
                ['key' => 'process_name', 'value' => $validatedData['process_name']],
                ['key' => 'process_brand', 'value' => $validatedData['process_brand']],
                ['key' => 'process_condition', 'value' => $validatedData['process_condition']],
                ['key' => 'process_gen_year', 'value' => $validatedData['process_gen_year']],

                ['key' => 'graphics_card_name', 'value' => $validatedData['graphics_card_name']],
                ['key' => 'graphics_card_brand', 'value' => $validatedData['graphics_card_brand']],
                ['key' => 'graphics_card_condition', 'value' => $validatedData['graphics_card_condition']],
                ['key' => 'graphics_card_memory', 'value' => $validatedData['graphics_card_memory']],

                ['key' => 'motherboard_name', 'value' => $validatedData['motherboard_name']],
                ['key' => 'motherboard_brand', 'value' => $validatedData['motherboard_brand']],
                ['key' => 'motherboard_condition', 'value' => $validatedData['graphics_card_memory']],

                ['key' => 'ram_name', 'value' => $validatedData['ram_name']],
                ['key' => 'ram_brand', 'value' => $validatedData['ram_brand']],
                ['key' => 'ram_dimm', 'value' => $validatedData['ram_dimm']],
                ['key' => 'ram_memory', 'value' => $validatedData['ram_memory']],


                ['key' => 'case_name', 'value' => $validatedData['case_name']],
                ['key' => 'case_condition', 'value' => $validatedData['case_condition']],
                ['key' => 'case_brand', 'value' => $validatedData['case_brand']],

                ['key' => 'cooler_name', 'value' => $validatedData['cooler_name']],
                ['key' => 'cooler_condition', 'value' => $validatedData['cooler_condition']],
                ['key' => 'cooler_brand', 'value' => $validatedData['cooler_brand']],

                ['key' => 'psu_name', 'value' => $validatedData['psu_name']],
                ['key' => 'psu_brand', 'value' => $validatedData['psu_brand']],
                ['key' => 'psu_condition', 'value' => $validatedData['psu_condition']],
            ];

            $additionalPartsData = [];

            // Handle Keyboard
            if (!empty($validatedData['keyboard_name'])) {
                $additionalPartsData[] = ['key' => 'keyboard_name', 'value' => $validatedData['keyboard_name']];
                $additionalPartsData[] = ['key' => 'keyboard_brand', 'value' => $validatedData['keyboard_brand'] ?? ''];
                $additionalPartsData[] = ['key' => 'keyboard_condition', 'value' => $validatedData['keyboard_condition'] ?? ''];
            }

            // Handle Monitor
            if (!empty($validatedData['monitor_name'])) {
                $additionalPartsData[] = ['key' => 'monitor_name', 'value' => $validatedData['monitor_name']];
                $additionalPartsData[] = ['key' => 'monitor_brand', 'value' => $validatedData['monitor_brand'] ?? ''];
                $additionalPartsData[] = ['key' => 'monitor_size', 'value' => $validatedData['monitor_size'] ?? ''];
            }

            // Handle Mouse
            if (!empty($validatedData['mouse_name'])) {
                $additionalPartsData[] = ['key' => 'mouse_name', 'value' => $validatedData['mouse_name']];
                $additionalPartsData[] = ['key' => 'mouse_brand', 'value' => $validatedData['mouse_brand'] ?? ''];
                $additionalPartsData[] = ['key' => 'mouse_type', 'value' => $validatedData['mouse_type'] ?? ''];
            }

            // Handle Headphones
            if (!empty($validatedData['headphones_name'])) {
                $additionalPartsData[] = ['key' => 'headphones_name', 'value' => $validatedData['headphones_name']];
                $additionalPartsData[] = ['key' => 'headphones_brand', 'value' => $validatedData['headphones_brand'] ?? ''];
                $additionalPartsData[] = ['key' => 'headphones_condition', 'value' => $validatedData['headphones_condition'] ?? ''];
            }

            // Additional Parts
            if (!empty($validatedData['fan_name'])) {
                $additionalPartsData[] = ['key' => 'fan_name', 'value' => $validatedData['fan_name']];
                $additionalPartsData[] = ['key' => 'fan_condition', 'value' => $validatedData['fan_condition'] ?? ''];
                $additionalPartsData[] = ['key' => 'fan_brand', 'value' => $validatedData['fan_brand'] ?? ''];
                $additionalPartsData[] = ['key' => 'fan_number', 'value' => $validatedData['fan_number'] ?? ''];
            }

            if (!empty($validatedData['gpu_stand_name'])) {
                $additionalPartsData[] = ['key' => 'gpu_stand_name', 'value' => $validatedData['gpu_stand_name']];
                $additionalPartsData[] = ['key' => 'gpu_stand_condition', 'value' => $validatedData['gpu_stand_condition'] ?? ''];
                $additionalPartsData[] = ['key' => 'gpu_stand_brand', 'value' => $validatedData['gpu_stand_brand'] ?? ''];
            }

            if (!empty($validatedData['case_parts_name'])) {
                $additionalPartsData[] = ['key' => 'case_parts_name', 'value' => $validatedData['case_parts_name']];
                $additionalPartsData[] = ['key' => 'case_parts_condition', 'value' => $validatedData['case_parts_condition'] ?? ''];
                $additionalPartsData[] = ['key' => 'case_parts_brand', 'value' => $validatedData['case_parts_brand'] ?? ''];
            }

            $pcPartsData = array_merge($pcPartsData, $additionalPartsData);


            $storageData = [];

            // Required first storage entry
            $storageData[] = ['key' => 'storage_brand', 'value' => $validatedData['storage_brand'][0]];
            $storageData[] = ['key' => 'storage_capacity', 'value' => $validatedData['storage_capacity'][0]];
            $storageData[] = ['key' => 'storage_name', 'value' => $validatedData['storage_name'][0]];
            $storageData[] = ['key' => 'storage_type', 'value' => $validatedData['storage_type'][0]];

            // Check for second storage entry
            if (!empty($validatedData['storage_brand'][1])) {
                $storageData[] = ['key' => 'storage_brand', 'value' => $validatedData['storage_brand'][1]];
                $storageData[] = ['key' => 'storage_capacity', 'value' => $validatedData['storage_capacity'][1]];
                $storageData[] = ['key' => 'storage_name', 'value' => $validatedData['storage_name'][1]];
                $storageData[] = ['key' => 'storage_type', 'value' => $validatedData['storage_type'][1]];
            }

            // Check for third storage entry
            if (!empty($validatedData['storage_brand'][2])) {
                $storageData[] = ['key' => 'storage_brand', 'value' => $validatedData['storage_brand'][2]];
                $storageData[] = ['key' => 'storage_capacity', 'value' => $validatedData['storage_capacity'][2]];
                $storageData[] = ['key' => 'storage_name', 'value' => $validatedData['storage_name'][2]];
                $storageData[] = ['key' => 'storage_type', 'value' => $validatedData['storage_type'][2]];
            }

            $pcPartsData = array_merge($pcPartsData, $storageData);


            // Sync parts
            $product->parts()->delete(); // delete the old ones before adding the new ones
            $product->parts()->createMany($pcPartsData);



            // Handle file uploads
            if ($request->hasFile('file')) {
                $path = public_path('images/products');
                foreach ($request->file('file') as $file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move($path, $fileName);
                    $product->pictures()->create(['image' => 'images/products/' . $fileName]);
                }
            }

            // Handle deleted images
            if ($request->has('deleted_images')) {
                foreach ($request->input('deleted_images') as $imagePath) {
                    if (file_exists(public_path($imagePath))) {
                        unlink(public_path($imagePath));
                    }
                    $product->pictures()->where('image', $imagePath)->delete();
                }
            }


            // Commit the transaction
            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Product added successfully!',
            ]);
        } catch (\Exception $e) {
            // Rollback the transaction if any exception occurs
            DB::rollBack();

            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the product.',
                'error' => $e->getMessage(),
            ], 500);
            return response()->json($req->all());
        }
    }

    /*****************************************************
     *
     *
     * Common Product Functions
     *
     *
     *****************************************************/

    public function destroy($id)
    {
        // Find the product by ID
        $product = Product::findOrFail($id);

        // Delete the associated pictures (if any)
        foreach ($product->pictures as $picture) {
            // Delete the image file from the server
            $imagePath = public_path($picture->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);  // Delete the image file from the server
            }
            // Delete the picture record from the database
            $picture->delete();
        }

        // Delete the product
        $product->delete();

        // Redirect to the product list with a success message
        return redirect()->route('product.index')->with('success', 'Product Deleted Successfully.');
    }
}
