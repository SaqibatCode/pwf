<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::paginate(10);
        return view('dashboard.admin.category.category', compact('category'));
    }
    public function add(Request $request)
    {
        $messages = [
            'name.required' => 'Please provide a category name.',
            'name.unique' => 'Category Already Exist'
        ];
        $validatedData = $request->validate([
            'image' => ['required', 'image', 'max:2048'],
            'name' => ['required', 'unique:categories'],
        ], $messages);

        $image = $request->file('image');
        $imageName = $validatedData['name'] . '-' . time() . '.' . $image->getClientOriginalExtension();
        $imagePath = 'images/categories/' . $imageName;
        if ($image->move(public_path('images/categories'), $imageName)) {
            $category = new Category;
            $category->image = $imagePath;
            $category->name = $validatedData['name'];
            $category->slug = Str::slug($validatedData['name']);
            if ($category->save()) {
                return redirect()->back()
                    ->with('success', 'Your Verification Request has been sent!');
            } else {
                return redirect()->back()
                    ->with('error', 'There was an error in processing your verification request.');
            }
        }
    }

    public function edit($slug)
    {
        $category = Category::with('brands')->Where('slug', $slug)->get();
        $categoryId = $category[0]->id;
        $availableBrands = Brand::whereNotIn('id', function ($query) use ($categoryId) {
            $query->select('brand_id')
                ->from('brand_category')
                ->where('category_id', $categoryId);
        })->get();

        // return response()->json($category);
        return view('dashboard.admin.category.category-single', compact('category', 'availableBrands'));
    }

    public function update(Request $request, $categoryId)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Image validation
        ]);

        // Find the category by ID
        $category = Category::findOrFail($categoryId);

        // Check if a new image is uploaded
        if ($request->hasFile('image')) {
            // Get the image file
            $image = $request->file('image');

            // Generate a unique name for the image based on the category name and current timestamp
            $imageName = $validatedData['name'] . '-' . time() . '.' . $image->getClientOriginalExtension();

            // Define the image path
            $imagePath = 'images/categories/' . $imageName;

            // Move the uploaded image to the specified folder
            if ($image->move(public_path('images/categories'), $imageName)) {
                // If the category already has an old image, delete it from storage
                // Avoid deleting the default image
                if ($category->image && $category->image !== 'images/default.jpg' && file_exists(public_path($category->image))) {
                    unlink(public_path($category->image)); // Delete the old image
                }

                // Update the category's image field with the new image path
                $category->image = $imagePath;
            }
        }

        // Update the category's name
        $category->name = $validatedData['name'];
        $category->slug = Str::slug($validatedData['name']);

        // Save the updated category
        if ($category->save()) {
            return redirect()->route('category.edit', $category->slug)
                ->with('success', 'Category updated successfully.');
        } else {
            return redirect()->route('category.edit', $category->slug)
                ->with('error', 'There was an error updating the category.');
        }
    }

    public function delete($categoryId)
    {
        // Find the category by ID
        $category = Category::findOrFail($categoryId);

        // Remove the relationships between the category and brands in the pivot table
        $category->brands()->detach();  // Detach all associated brands from the category

        // Check if the category has an image and it's not the default one
        if ($category->image && $category->image !== 'images/default.jpg') {
            // Delete the image from the storage
            if (file_exists(public_path($category->image))) {
                unlink(public_path($category->image));  // Delete the image file
            }
        }

        // Delete the category from the categories table
        $category->delete();

        // Redirect back with a success message
        return redirect()->route('category')  // Adjust this route if necessary
            ->with('success', 'Category deleted successfully.');
    }



    public function updateBrand(Request $request)
    {

        $request->validate([
            'brands' => 'array',
            'brands.*' => 'exists:brands,id'
        ]);
        $categoryId = $request->id;

        $category = Category::findOrFail($categoryId);


        $existingBrandIds = $category->brands->pluck('id')->toArray();

        $selectedBrandIds = $request->brands;

        $newBrandIds = array_diff($selectedBrandIds, $existingBrandIds);


        if (!empty($newBrandIds)) {
            $category->brands()->attach($newBrandIds);
        }

        return redirect()->route('category.edit', $category->slug)
            ->with('success', 'Brands added successfully.');
    }


    public function removeBrand($categoryId, $brandId)
    {
        // Fetch the category
        $category = Category::findOrFail($categoryId);
        $brand = $category->brands()->find($brandId);

        // Detach the specific brand from the category
        if ($brand) {
            $category->brands()->detach($brandId);
        }

        return redirect()->route('category.edit', $category->slug)
            ->with('success', 'Brand removed successfully.');
    }
}
