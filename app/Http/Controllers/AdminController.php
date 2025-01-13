<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    // Products Routes

    public function all_products(Request $request)
    {
        $sellerName = $request->input('seller_name');
        $sellerPhone = $request->input('seller_phone');

        $product = Product::with('user', 'category', 'pictures')
            ->when($sellerName, function ($query, $sellerName) {
                $query->whereHas('user', function ($q) use ($sellerName) {
                    $q->where('first_name', 'like', "%{$sellerName}%")
                        ->orWhere('last_name', 'like', "%{$sellerName}%");
                });
            })
            ->when($sellerPhone, function ($query, $sellerPhone) {
                $query->whereHas('user', function ($q) use ($sellerPhone) {
                    $q->where('phone', 'like', "%{$sellerPhone}%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('dashboard.admin.product.all-products', compact('product'));
    }

    public function pending_products(Request $request)
    {
        $sellerName = $request->input('seller_name');
        $sellerPhone = $request->input('seller_phone');

        $product = Product::with('user', 'category', 'pictures')
            ->where('status', 'pending')
            ->when($sellerName, function ($query, $sellerName) {
                $query->whereHas('user', function ($q) use ($sellerName) {
                    $q->where('first_name', 'like', "%{$sellerName}%")
                        ->orWhere('last_name', 'like', "%{$sellerName}%");
                });
            })
            ->when($sellerPhone, function ($query, $sellerPhone) {
                $query->whereHas('user', function ($q) use ($sellerPhone) {
                    $q->where('phone', 'like', "%{$sellerPhone}%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('dashboard.admin.product.all-products', compact('product'));
    }
    public function approved_products(Request $request)
    {
        $sellerName = $request->input('seller_name');
        $sellerPhone = $request->input('seller_phone');

        $product = Product::with('user', 'category', 'pictures')
            ->where('status', 'approved')
            ->when($sellerName, function ($query, $sellerName) {
                $query->whereHas('user', function ($q) use ($sellerName) {
                    $q->where('first_name', 'like', "%{$sellerName}%")
                        ->orWhere('last_name', 'like', "%{$sellerName}%");
                });
            })
            ->when($sellerPhone, function ($query, $sellerPhone) {
                $query->whereHas('user', function ($q) use ($sellerPhone) {
                    $q->where('phone', 'like', "%{$sellerPhone}%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('dashboard.admin.product.all-products', compact('product'));
    }
    public function rejected_products(Request $request)
    {
        $sellerName = $request->input('seller_name');
        $sellerPhone = $request->input('seller_phone');

        $product = Product::with('user', 'category', 'pictures')
            ->where('status', 'rejected')
            ->when($sellerName, function ($query, $sellerName) {
                $query->whereHas('user', function ($q) use ($sellerName) {
                    $q->where('first_name', 'like', "%{$sellerName}%")
                        ->orWhere('last_name', 'like', "%{$sellerName}%");
                });
            })
            ->when($sellerPhone, function ($query, $sellerPhone) {
                $query->whereHas('user', function ($q) use ($sellerPhone) {
                    $q->where('phone', 'like', "%{$sellerPhone}%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('dashboard.admin.product.all-products', compact('product'));
    }
    public function approve_product(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        // Check if the product status is not already approved
        if ($product->status !== 'approved') {
            $product->status = 'approved'; // Set the status to approved
            $product->save(); // Save the changes
        }

        return redirect()->back()->with('success', 'Product approved successfully.');
    }
    public function reject_product(Request $request, $id) {

        $product = Product::findOrFail($id);
        // Check if the product status is not already approved
        if ($product->status !== 'rejected') {
            $product->status = 'rejected'; // Set the status to approved
            $product->save(); // Save the changes
        }
        return redirect()->back()->with('success', 'Product approved successfully.');
    }



    // Seller Routes
    public function all_sellers(Request $request)
    {
        // Retrieve query parameters
        $sellerType = $request->input('seller_type');
        $sellerVerificationType = $request->input('seller_verification_type');
        $sellerName = $request->input('seller_name');
        // Filter sellers based on parameters
        $sellers = User::where('type', 'seller')
            ->when($sellerType, function ($query, $sellerType) {
                $query->where('seller_type', 'like', "%{$sellerType}%");
            })
            ->when($sellerVerificationType, function ($query, $sellerVerificationType) {
                $query->where('verification', 'like', "%{$sellerVerificationType}%");
            })
            ->when($sellerName, function ($query, $sellerName) {
                $query->where('first_name', 'like', "%{$sellerName}%");
            })
            ->with('user_verification')
            ->paginate(10);

        return view('dashboard.admin.seller.seller', compact('sellers'));
    }
}
