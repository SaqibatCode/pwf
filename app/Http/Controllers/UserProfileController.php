<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\UserProfile;

class UserProfileController extends Controller
{
    public function index($slug)
    {
        $user =  User::with('payment_methods', 'user_verification', 'userProfile')->where('slug', $slug)->first();
        return view('dashboard.seller.profile.profile', compact('user'));
    }

    public function update(Request $request)
    {

        DB::beginTransaction();

        try {
            // Validate input
            $validatedData = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'description' => 'nullable|string|max:500',  // Adding description field
                'profile_photo' => 'nullable|file|mimes:jpeg,png,jpg|max:2048', // Profile picture validation
                'cover_photo' => 'nullable|file|mimes:jpeg,png,jpg|max:2048', // Cover photo validation
            ]);

            // Get the authenticated user
            $user = Auth::user();
            $user->first_name = $validatedData['first_name'];
            $user->last_name = $validatedData['last_name'];
            $user->email = $validatedData['email'];

            // Check if the user has a UserProfile. If not, create one.
            $userProfile = $user->userProfile ?: new UserProfile();
            $userProfile->seller_description = $validatedData['description'] ?? $userProfile->seller_description;

            // Handle profile picture upload
            if ($request->hasFile('profile_photo')) {
                // Delete the old profile picture if exists
                if ($userProfile->profile_photo && file_exists(public_path($userProfile->profile_photo))) {
                    unlink(public_path($userProfile->profile_photo)); // Remove the old file
                }

                // Upload the new profile picture
                $profilePath = public_path('images/profile_photos');
                if (!is_dir($profilePath)) {
                    mkdir($profilePath, 0777, true);
                }

                $profileFile = $request->file('profile_photo');
                $profileFileName = time() . '_' . $profileFile->getClientOriginalName();
                $profileFile->move($profilePath, $profileFileName);
                $userProfile->profile_photo = 'images/profile_photos/' . $profileFileName;
            }

            // Handle cover photo upload
            if ($request->hasFile('cover_photo')) {
                // Delete the old cover photo if exists
                if ($userProfile->cover_photo && file_exists(public_path($userProfile->cover_photo))) {
                    unlink(public_path($userProfile->cover_photo)); // Remove the old file
                }

                // Upload the new cover photo
                $coverPath = public_path('images/cover_photos');
                if (!is_dir($coverPath)) {
                    mkdir($coverPath, 0777, true);
                }

                $coverFile = $request->file('cover_photo');

                $coverFileName = time() . '_' . $coverFile->getClientOriginalName();
                $coverFile->move($coverPath, $coverFileName);
                $userProfile->cover_photo = 'images/cover_photos/' . $coverFileName;
            }

            // Save the updated user profile
            $user->userProfile()->save($userProfile);

            // Save the user's basic details
            $user->save();

            // Commit the transaction
            DB::commit();

            // Redirect with a success message
            return redirect()->back()->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            // Rollback the transaction if any exception occurs
            DB::rollBack();

            // Redirect with an error message
            return redirect()->back()->with('error', 'An error occurred while updating the profile: ' . $e->getMessage());
        }
    }
}
