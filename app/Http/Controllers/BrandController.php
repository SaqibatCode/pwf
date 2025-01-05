<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\support\Str;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::latest()->paginate(10); // Paginate the list of brands
        return view('dashboard.admin.brand.brand', compact('brands')); // Return the view with paginated brands
    }

    public function add(Request $request)
    {
        // Custom validation messages
        $messages = [
            'name.required' => 'Please provide a brand name.',
            'name.unique' => 'Brand Already Exists'
        ];

        // Validate the incoming request
        $validatedData = $request->validate([
            'image' => ['required', 'image', 'max:2048'],
            'name' => ['required', 'unique:brands'],
        ], $messages);

        // Handle image upload
        $image = $request->file('image');
        $imageName = $validatedData['name'] . '-' . time() . '.' . $image->getClientOriginalExtension();
        $imagePath = 'images/brands/' . $imageName;

        if ($image->move(public_path('images/brands'), $imageName)) {
            // Create a new brand and save the details
            $brand = new Brand;
            $brand->image = $imagePath;
            $brand->name = $validatedData['name'];
            $brand->slug = Str::slug($validatedData['name']);

            if ($brand->save()) {
                return redirect()->back()->with('success', 'Brand added successfully!');
            } else {
                return redirect()->back()->with('error', 'There was an error while adding the brand.');
            }
        }
    }

    public function edit($slug)
    {
        // Retrieve the brand based on the slug
        $brand = Brand::where('slug', $slug)->first();

        // Return the edit view with the brand data
        return view('dashboard.admin.brand.brand-single', compact('brand'));
    }

    public function update(Request $request, $brandId)
    {
        // Custom validation messages
        $messages = [
            'name.required' => 'Please provide a brand name.',
            'name.unique' => 'Brand name already exists.'
        ];

        // Validate the request data
        $validatedData = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Image validation
            'name' => 'required|string|max:255|unique:brands,name,' . $brandId, // Unique validation excluding current brand
        ], $messages);

        // Find the brand by ID
        $brand = Brand::findOrFail($brandId);

        // Handle image upload (if a new image is uploaded)
        if ($request->hasFile('image')) {
            // Get the image file
            $image = $request->file('image');
            $imageName = $validatedData['name'] . '-' . time() . '.' . $image->getClientOriginalExtension();
            $imagePath = 'images/brands/' . $imageName;

            // Move the uploaded image to the specified folder
            if ($image->move(public_path('images/brands'), $imageName)) {
                // Delete the old image if it exists and is not the default
                if ($brand->image && $brand->image !== 'images/default.jpg') {
                    if (file_exists(public_path($brand->image))) {
                        unlink(public_path($brand->image)); // Delete the old image
                    }
                }
                // Update the brand's image path
                $brand->image = $imagePath;
            }
        }

        // Update brand name and slug
        $brand->name = $validatedData['name'];
        $brand->slug = Str::slug($validatedData['name']);

        // Save the updated brand
        if ($brand->save()) {
            return redirect()->route('brand.index')->with('success', 'Brand updated successfully.');
        } else {
            return redirect()->route('brand.edit', $brand->slug)->with('error', 'There was an error updating the brand.');
        }
    }

    public function delete($brandId)
    {
        // Find the brand by ID
        $brand = Brand::findOrFail($brandId);

        // Delete the brand's image if it's not the default one
        if ($brand->image && $brand->image !== 'images/default.jpg') {
            if (file_exists(public_path($brand->image))) {
                unlink(public_path($brand->image)); // Delete the image
            }
        }

        // Remove any relationships in the pivot table (if applicable)
        $brand->categories()->detach(); // Assuming the brand has a many-to-many relationship with categories

        // Delete the brand from the brands table
        $brand->delete();

        // Redirect with success message
        return redirect()->route('brand.index')->with('success', 'Brand deleted successfully.');
    }
}
