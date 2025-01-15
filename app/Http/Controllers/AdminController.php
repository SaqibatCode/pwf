<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\AboutUs;
use App\Models\ContactUs;
use App\Models\Faq;
use App\Models\TermsAndCondition;

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
    public function reject_product(Request $request, $id)
    {

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

    public function termsEdit()
    {
        $terms = TermsAndCondition::first();
        return view('dashboard.admin.pages.terms.edit', compact('terms'));
    }

    public function termsUpdate(Request $request)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $terms = TermsAndCondition::firstOrNew();
        $terms->content = $request->content;
        $terms->save();
        return redirect()->route('admin.terms.edit')->with('success', 'Terms and conditions updated successfully!');
    }

    // FAQs
    public function faqsIndex()
    {
        $faqs = Faq::all();
        return view('dashboard.admin.pages.faqs.index', compact('faqs'));
    }

    public function faqsCreate()
    {
        return view('dashboard.admin.pages.faqs.create');
    }

    public function faqsStore(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);

        Faq::create($request->all());
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ created successfully!');
    }

    public function faqsEdit(Faq $faq)
    {
        return view('dashboard.admin.pages.faqs.edit', compact('faq'));
    }

    public function faqsUpdate(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);

        $faq->update($request->all());
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ updated successfully!');
    }

    public function faqsDestroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ deleted successfully!');
    }


    // About Us
    public function aboutEdit()
    {
        $about = AboutUs::first();
        return view('dashboard.admin.pages.about.edit', compact('about'));
    }

    public function aboutUpdate(Request $request)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $about = AboutUs::firstOrNew();
        $about->content = $request->content;
        $about->save();
        return redirect()->route('admin.about.edit')->with('success', 'About us updated successfully!');
    }

    // Contact Us
    public function contactEdit()
    {
        $contact = ContactUs::first();
        return view('dashboard.admin.pages.contact.edit', compact('contact'));
    }

    public function contactUpdate(Request $request)
    {
        $request->validate([
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
        ]);

        $contact = ContactUs::firstOrNew();
        $contact->address = $request->address;
        $contact->phone = $request->phone;
        $contact->email = $request->email;
        $contact->save();

        return redirect()->route('admin.contact.edit')->with('success', 'Contact us updated successfully!');
    }





    public function homePageSliderIndex(){
        return view('dashboard.admin.pages.home-page-slider');
    }
}
