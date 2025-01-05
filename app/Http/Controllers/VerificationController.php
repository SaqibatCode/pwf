<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Verification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    public function index()
    {
        $authRole = null;
        if (Auth::check()) {
            $authRole = Auth::user()->type;
        }

        switch ($authRole) {
            case 'seller':
                return view('dashboard.seller.verification.verification');
            case 'admin':
                $verification = User::with('user_verification')
                ->where('type', 'seller')
                ->where('verification', 'pending')
                ->paginate(10);
                // dd($verification);
                // return response()->json($verification);
                return view('dashboard.admin.verification.verification', compact('verification'));
        }
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // Validate the incoming request data
        $validatedData = $request->validate([
            'seller_type'                  => ['required'],
            'cnic_front_picture'           => ['required', 'image', 'max:2048'],
            'cnic_back_picture'            => ['required', 'image', 'max:2048'],
            'cnic_holding_selfie'          => ['required', 'image', 'max:2048'],
            'shop_name'                    => ['nullable', 'string', 'max:255'],
            'shop_picture'                 => ['nullable', 'image', 'max:2048'],
            'shop_business_card_picture'   => ['nullable', 'image', 'max:2048'],
            'shop_address'                 => ['nullable', 'string', 'max:255'],
            'rep_post_link'                => ['nullable', 'url'],
        ]);

        $user = Auth::user();

        // Sanitize first name and email to create a safe directory name
        $sanitizedFirstName = Str::slug($user->first_name, '_');
        $sanitizedEmail = Str::slug($user->email, '_');

        // Define the folder path: assets/verification/{userId}_{first_name}_{email}
        $folderName = 'assets/verification/' . $user->id . '_' . $sanitizedFirstName . '_' . $sanitizedEmail;
        $destinationPath = public_path($folderName);

        // Create the directory if it doesn't exist
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }

        // Function to build the file name and store the file
        $buildFilePath = function (UploadedFile $file) use ($destinationPath, $folderName, $user) {
            // Sanitize the original file name to prevent issues
            $originalName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME), '_');
            $newFileName = sprintf(
                '%s_%s_%d.%s',
                $originalName,
                $user->first_name,
                $user->id,
                $file->getClientOriginalExtension()
            );

            // Move the file to the target directory
            $file->move($destinationPath, $newFileName);

            // Return the relative path to store in the database
            return $folderName . '/' . $newFileName;
        };

        // Store files only if they are present
        if ($request->hasFile('cnic_front_picture')) {
            $validatedData['cnic_front_picture'] = $buildFilePath(
                $request->file('cnic_front_picture')
            );
        }

        if ($request->hasFile('cnic_back_picture')) {
            $validatedData['cnic_back_picture'] = $buildFilePath(
                $request->file('cnic_back_picture')
            );
        }

        if ($request->hasFile('cnic_holding_selfie')) {
            $validatedData['cnic_holding_selfie'] = $buildFilePath(
                $request->file('cnic_holding_selfie')
            );
        }

        if ($request->hasFile('shop_picture')) {
            $validatedData['shop_picture'] = $buildFilePath(
                $request->file('shop_picture')
            );
        }

        if ($request->hasFile('shop_business_card_picture')) {
            $validatedData['shop_business_card_picture'] = $buildFilePath(
                $request->file('shop_business_card_picture')
            );
        }

        // Create a new verification record
        $verification = Verification::create([
            'user_id'                    => $user->id,
            'cnic_front_picture'         => $validatedData['cnic_front_picture'] ?? null,
            'cnic_back_picture'          => $validatedData['cnic_back_picture'] ?? null,
            'cnic_holding_selfie'        => $validatedData['cnic_holding_selfie'] ?? null,
            'shop_name'                  => $validatedData['shop_name'] ?? null,
            'shop_picture'               => $validatedData['shop_picture'] ?? null,
            'shop_business_card_picture' => $validatedData['shop_business_card_picture'] ?? null,
            'shop_address'               => $validatedData['shop_address'] ?? null,
            'rep_post_link'              => $validatedData['rep_post_link'] ?? null,
        ]);

        // Check if verification was successful and update user status
        if ($verification) {
            $user->verification = 'Pending';
            $user->seller_type = $validatedData['seller_type'];
            $user->save();

            return redirect()->back()
                ->with('success', 'Your Verification Request has been sent!');
        }
        return redirect()->back()
            ->with('error', 'There was an error in processing your verification request.');
    }

    public function approve_user(Request $request){
        $user = User::findorfail($request->id);
        $user->verification = 'Verified';
        $user->save();
        return redirect()->back()->with('success', 'User Verified Successfully');
    }
    public function reject_user(Request $request){
        $user = User::findorfail($request->id);
        $user->verification = 'Unverified';
        $user->save();
        return redirect()->back()->with('success', 'User Rejected Successfully');
    }
}
