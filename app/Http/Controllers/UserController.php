<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{


    /** Login */
    public function index()
    {

        if (!Auth::check()) {
            return view('dashboard.auth.login');
        }

        $authRole = null;
        if (Auth::check()) {
            $authRole = Auth::user()->type;
        }

        switch ($authRole) {
            case 'seller':
                return view('dashboard.seller.dashboard');
            case 'admin':
                return view('dashboard.admin.dashboard');
            case 'buyer':
                return ('Home');
        }
    }

    public function login(Request $request)
    {
        // dd($request->all());
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('portal'));
        }

        return back()->withErrors([
            'email' => 'Invalid Credentials Provided',
        ])->onlyInput('email');
    }


    /** Registeration */
    public function get_register_page()
    {
        if (!Auth::check()) {
            return view('dashboard.auth.register');
        } else {
            return ('Dashboard');
        }
    }

    public function register_seller(Request $request)
    {

        $messages = [
            'dob.before_or_equal' => 'You must be at least 18 years old to register.',

        ];
        $validatedData = $request->validate([
            'first_name'  => 'required|string|max:255',
            'last_name'   => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'dob' => [
                'required',
                'date_format:d/m/Y',
                'before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
            ],
            'address'     => 'required|string|max:255',
            'cnic'        => 'required|string|max:15|min:12|unique:users',
            'phone'       => 'required|string|min:11|unique:users,phone',
            'password'    => 'required|string|min:8',
            'terms'       => 'accepted',
            'city'        => 'required',
        ], $messages);
        $user = User::create([
            'first_name'   => $validatedData['first_name'],
            'last_name'    => $validatedData['last_name'],
            'father_name'  => $validatedData['father_name'],
            'email'        => $validatedData['email'],
            'type'         => 'seller',
            'dob'          => Carbon::createFromFormat('d/m/Y', $validatedData['dob'])->format('Y-m-d'),
            'address'      => $validatedData['address'],
            'cnic'         => $validatedData['cnic'],
            'city'         => $validatedData['city'],
            'phone'        => $validatedData['phone'],
            'password'     => Hash::make($validatedData['password']),
            'verification' => 'Unverified', // or set based on your logic
            'terms'        => true, // since 'accepted' was required, we can safely set true
        ]);

        Auth::login($user);

        return redirect()
            ->route('portal')
            ->with('success', 'Registration successful! Please Proceed To Verfication');
    }

    /** Logout */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('home'));
    }
}
