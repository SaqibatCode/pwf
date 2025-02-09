<?php

namespace App\Http\Controllers;

use App\Mail\AccountCreated;
use App\Models\ChildOrder;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{


    public function sendTestMail()
    {
        $user = User::findorFail(Auth::user()->id);
        try {
            // Attempt to send the email
            Mail::mailer('account_smtp')
                ->to('saqib75ahmed@gmail.com')
                ->send(new AccountCreated($user));

            // If successful, return a success message
            return 'Test email sent successfully!';
        } catch (Exception $e) {
            // If an error occurs, return the error message to the browser
            return 'Failed to send test email: ' . $e->getMessage();
        }
    }

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
                $totalRevenue = '200000';
                $totalOrders = Order::count();
                $totalProducts = Product::count();
                $totalSellers = User::where('type', 'seller')->count();
                $totalBuyers = User::where('type', 'buyer')->count();

                $recentOrders = ChildOrder::latest()->take(5)->get();
                return view('dashboard.admin.dashboard', compact('totalRevenue', 'totalOrders', 'totalProducts', 'totalSellers', 'totalBuyers', 'recentOrders'));
            case 'buyer':
                return redirect(route('home'));
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
        // Send the account creation email using the account_smtp mailer
        Mail::mailer('account_smtp')
            ->to($user->email)
            ->send(new AccountCreated($user));
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
