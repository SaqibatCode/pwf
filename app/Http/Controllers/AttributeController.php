<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    // Show all attributes
    public function index()
    {
        $attributes = Attribute::with('values')->paginate(10);  // Fetch attributes with values
        return view('dashboard.admin.attribute.index', compact('attributes'));
    }

    // Show form to create a new attribute
    public function create()
    {
        return view('dashboard.admin.attribute.create');
    }

    // Store a new attribute
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
        ]);

        $attribute = new Attribute();
        $attribute->name = $request->name;
        $attribute->type = $request->type;
        $attribute->save();

        return redirect()->route('attribute.index')->with('success', 'Attribute created successfully!');
    }

    // Show the form to edit an existing attribute
    public function edit($id)
    {
        $attribute = Attribute::findOrFail($id);
        return view('dashboard.admin.attribute.edit', compact('attribute'));
    }

    // Update an existing attribute
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
        ]);

        $attribute = Attribute::findOrFail($id);
        $attribute->name = $request->name;
        $attribute->type = $request->type;
        $attribute->save();

        return redirect()->route('attribute.index')->with('success', 'Attribute updated successfully!');
    }

    // Delete an attribute
    public function destroy($id)
    {
        $attribute = Attribute::findOrFail($id);
        $attribute->delete();

        return redirect()->route('attribute.index')->with('success', 'Attribute deleted successfully!');
    }

    // Manage values for a specific attribute
    public function manageValues($attributeId)
    {
        $attribute = Attribute::findOrFail($attributeId);
        $values = $attribute->values()->paginate(10);  // Fetch values for this attribute
        return view('dashboard.admin.attribute_value.index', compact('attribute', 'values'));
    }

    // Store attribute values (batch add)
    public function storeValues(Request $request, $attributeId)
    {
        $request->validate([
            'values' => 'required|array',
            'values.*' => 'required|string|max:255',
        ]);

        $attribute = Attribute::findOrFail($attributeId);

        // Batch insert the values
        foreach ($request->values as $value) {
            $attributeValue = new AttributeValue();
            $attributeValue->attribute_id = $attribute->id;
            $attributeValue->value = $value;
            $attributeValue->save();
        }

        return redirect()->route('attribute.manageValues', $attributeId)->with('success', 'Attribute values added successfully!');
    }

    // Update an attribute value
    public function updateValue(Request $request, $attributeId, $valueId)
    {
        $request->validate([
            'value' => 'required|string|max:255',
        ]);

        $value = AttributeValue::findOrFail($valueId);
        $value->value = $request->value;
        $value->save();

        return redirect()->route('attribute.manageValues', $attributeId)->with('success', 'Attribute value updated successfully!');
    }

    // Delete an attribute value
    public function destroyValue($attributeId, $valueId)
    {
        $value = AttributeValue::findOrFail($valueId);
        $value->delete();

        return redirect()->route('attribute.manageValues', $attributeId)->with('success', 'Attribute value deleted successfully!');
    }

    // Show form to assign attributes to a category
    public function assignCategory($attributeId)
    {
        $attribute = Attribute::findOrFail($attributeId);
        $categories = Category::whereDoesntHave('attributes', function ($query) use ($attributeId) {
            $query->where('attribute_id', $attributeId);
        })->get();  // Get categories that are not assigned to this attribute

        return view('dashboard.admin.category_attribute.create', compact('attribute', 'categories'));
    }

    // Store category-attribute association
    public function storeCategoryAssignment(Request $request, $attributeId)
    {
        $request->validate([
            'categories' => 'required|array',
        ]);

        $attribute = Attribute::findOrFail($attributeId);
        $attribute->categories()->sync($request->categories);  // Sync selected categories

        return redirect()->route('attribute.index')->with('success', 'Categories assigned to attribute successfully!');
    }
}
