<?php

namespace App\Http\Controllers;

use App\Models\HomePageSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class HomePageSliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = HomePageSlider::all();
        return view('dashboard.admin.pages.sliders.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.admin.pages.sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function store(Request $request)
    {
         $request->validate([
            'heading' => 'required',
            'description' => 'required',
            'button_text' => 'required',
             'button_url' => 'required',
            'image_desktop' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_mobile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $desktopImageFile = $request->file('image_desktop');
         $mobileImageFile = $request->file('image_mobile');
        $desktopImageName = time() . '_desktop.' . $desktopImageFile->getClientOriginalExtension();
        $mobileImageName = time() . '_mobile.' . $mobileImageFile->getClientOriginalExtension();

        $desktopImagePath = public_path('HomePageSliders/' . $desktopImageName);
          $mobileImagePath = public_path('HomePageSliders/' . $mobileImageName);

         $desktopImageFile->move(public_path('HomePageSliders'), $desktopImageName);
         $mobileImageFile->move(public_path('HomePageSliders'), $mobileImageName);

         HomePageSlider::create([
            'sub_heading' => $request->input('sub_heading'),
            'heading' => $request->input('heading'),
            'description' => $request->input('description'),
            'another_heading' => $request->input('another_heading'),
            'button_text' => $request->input('button_text'),
            'button_url' => $request->input('button_url'),
            'image_desktop' => 'HomePageSliders/' . $desktopImageName,
            'image_mobile' => 'HomePageSliders/' . $mobileImageName,
        ]);

        return redirect()->route('slider.index')->with('success', 'Slider created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HomePageSlider  $homePageSlider
     * @return \Illuminate\Http\Response
     */
    public function show(HomePageSlider $homePageSlider)
    {
        // Not needed in this case
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HomePageSlider  $homePageSlider
     * @return \Illuminate\Http\Response
     */
      public function edit(HomePageSlider $homePageSlider)
    {
        return view('dashboard.admin.pages.sliders.edit', compact('homePageSlider'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HomePageSlider  $homePageSlider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HomePageSlider $homePageSlider)
    {
        $request->validate([
            'heading' => 'required',
            'description' => 'required',
            'button_text' => 'required',
            'button_url' => 'required',
            'image_desktop' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_mobile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

         $updateData = [
            'sub_heading' => $request->input('sub_heading'),
            'heading' => $request->input('heading'),
            'description' => $request->input('description'),
             'another_heading' => $request->input('another_heading'),
            'button_text' => $request->input('button_text'),
            'button_url' => $request->input('button_url'),

        ];

         if ($request->hasFile('image_desktop')) {
             $desktopImageFile = $request->file('image_desktop');
             $desktopImageName = time() . '_desktop.' . $desktopImageFile->getClientOriginalExtension();
             $desktopImagePath = public_path('HomePageSliders/' . $desktopImageName);

            if (File::exists(public_path($homePageSlider->image_desktop)))
               {
                   File::delete(public_path($homePageSlider->image_desktop));
               }

            $desktopImageFile->move(public_path('HomePageSliders'), $desktopImageName);
            $updateData['image_desktop'] = 'HomePageSliders/' . $desktopImageName;
         }

         if ($request->hasFile('image_mobile')) {
             $mobileImageFile = $request->file('image_mobile');
            $mobileImageName = time() . '_mobile.' . $mobileImageFile->getClientOriginalExtension();
            $mobileImagePath = public_path('HomePageSliders/' . $mobileImageName);

           if (File::exists(public_path($homePageSlider->image_mobile)))
              {
                  File::delete(public_path($homePageSlider->image_mobile));
               }
            $mobileImageFile->move(public_path('HomePageSliders'), $mobileImageName);
              $updateData['image_mobile'] = 'HomePageSliders/' . $mobileImageName;
        }

        $homePageSlider->update($updateData);
        return redirect()->route('slider.index')->with('success', 'Slider updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HomePageSlider  $homePageSlider
     * @return \Illuminate\Http\Response
     */
     public function destroy(HomePageSlider $homePageSlider)
     {
          if (File::exists(public_path($homePageSlider->image_desktop)))
              {
                  File::delete(public_path($homePageSlider->image_desktop));
               }
           if (File::exists(public_path($homePageSlider->image_mobile)))
             {
                  File::delete(public_path($homePageSlider->image_mobile));
            }

        $homePageSlider->delete();
        return redirect()->route('slider.index')->with('success', 'Slider deleted successfully.');
     }
}
