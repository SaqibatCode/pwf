<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use App\Models\ContactUs;
use App\Models\Faq;
use App\Models\TermsAndCondition;
use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    public function terms()
    {
        $terms = TermsAndCondition::first();
        return view('store-front.pages.terms', compact('terms'));
    }

    public function faqs()
    {
        $faqs = Faq::all();
        return view('store-front.pages.faqs', compact('faqs'));
    }

    public function about()
    {
        $about = AboutUs::first();
        return view('store-front.pages.about', compact('about'));
    }

    public function contact()
    {
        $contact = ContactUs::first();
        return view('store-front.pages.contact', compact('contact'));
    }
}
