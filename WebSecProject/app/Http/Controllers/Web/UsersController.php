<?php

namespace App\Http\Controllers\Web;


use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;
use Artisan;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Mail\ResetPasswordMail;

use App\Http\Controllers\Controller;


class UsersController extends Controller
{
    use ValidatesRequests;



    public function login(Request $request) {
        if (Auth::user()){
            abort(403, 'Unauthorized access');
        }
        return view('users.login');
    }


    public function doLogin(Request $request)
    {
        if (Auth::user()){
            abort(403, 'Unauthorized access');
        }
        $user = User::where('email', $request->email)->first();

        if ($user && $user->hasRole('Banned')) {
            return redirect()->route('banned_page');
        }

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->back()->withInput($request->input())
                ->withErrors('Invalid login information.');
        }

        Auth::setUser($user);

        // Check if user must change password after reset
        if ($user->force_change_password) {
            return redirect()->route('password.change')->with('info', 'You must change your password before continuing.');
        }

        return redirect('/')->with('success', 'Login successful!');
    }

    public function redirectToGoogle()
    {
    if (Auth::user()){
        abort(403, 'Unauthorized access');
    }
    return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback()
    {
        if (Auth::user()){
            abort(403, 'Unauthorized access');
        }
        try {
            // Retrieve the Google user data
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Log the Google user data for debugging
            Log::info('Google User:', [
                'id' => $googleUser->id,
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'token' => $googleUser->token,
                'refresh_token' => $googleUser->refreshToken,
            ]);

            // Check if the user already exists by email
            $user = User::where('email', $googleUser->email)->first();

            // If the user exists, update their Google data
            if ($user) {
                $user->google_id = $googleUser->id;
                $user->google_token = $googleUser->token;
                $user->google_refresh_token = $googleUser->refreshToken;
                $user->save();
            } else {
                // If the user doesn't exist, create a new one
                $user = new User();
                $user->name = $googleUser->name;
                $user->email = $googleUser->email;
                $user->google_id = $googleUser->id;
                $user->google_token = $googleUser->token;
                $user->google_refresh_token = $googleUser->refreshToken;
                $user->password = bcrypt('default_password'); // Set a default password
                $user->credit = 80000; // Assign 80000 credit to the user
                $user->assignRole('customer');
                $user->save();

                // Send the verification email as in your doRegister method
                $title = "Verification Link";
                $token = Crypt::encryptString(json_encode(['id' => $user->id, 'email' => $user->email]));
                $link = route("verify", ['token' => $token]);
                Mail::to($user->email)->send(new VerificationEmail($link, $user->name));
            }

            // Log the user in
            Auth::login($user);

            // Redirect to the home page or dashboard
            return redirect('/')->with('success', 'Logged in successfully with Google!');
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Google Login Error:', ['message' => $e->getMessage()]);

            // Redirect back to the login page with an error message
            return redirect('/login')->with('error', 'Google login failed. Please try again.');
        }
    }
    public function register(Request $request) {
        if (Auth::user()){
            abort(403, 'Unauthorized access');
        }
        return view('users.register');
    }

    public function doRegister(Request $request) {
        if (Auth::user()){
            abort(403, 'Unauthorized access');
        }

        try {
            $this->validate($request, [
                'name' => ['required', 'string', 'min:5'],
                'email' => ['required', 'email', 'unique:users'],
                'password' => ['required', 'confirmed', Password::min(5)->numbers()->letters()->mixedCase()->symbols()],
                // 'email_verification' => ['required', 'in:now,later'],
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withInput($request->input())->withErrors('Invalid registration information.');
        }


        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password); // Secure
        $user->credit = 80000; // Assign 80000 credit to the user
        $user->save();
        $user->assignRole('customer');

        // Create a cart for the new user
        $user_id = new Cart();
        $user_id->user_id = $user->id;
        $user_id->save();

        // Check email verification preference
        if ($request->email_verification === 'now') {
            $title = "Verification Link";
            $token = Crypt::encryptString(json_encode(['id' => $user->id, 'email' => $user->email]));
            $link = route("verify", ['token' => $token]);
            try {
                Mail::to($user->email)->send(new VerificationEmail($link, $user->name));
                Log::info('Verification email sent successfully to ' . $user->email);
            } catch (\Exception $e) {
                Log::error('Failed to send verification email: ' . $e->getMessage());
            }
        }

        return redirect()->route('login')->with('success', 'Registration successful!');
    }

    public function verify(Request $request) {
        $decryptedData = json_decode(Crypt::decryptString($request->token), true);
        $user = User::find($decryptedData['id']);
        if(!$user) abort(401);
        $user->email_verified_at = Carbon::now();
        $user->save();
        return redirect()->route('welcome')->with('success', 'Email verified successfully!');
    }
    public function manageUsers(Request $request)
{
    if (!Auth::user()->hasPermissionTo('show-users')) {
        abort(403, 'Unauthorized');
    }
    // Query to get all users except those with the 'admin' role
    $query = User::with('roles')->whereDoesntHave('roles', function($q) {
        $q->where('name', 'admin');
    });

    // Search functionality
    if ($request->has('keywords') && !empty($request->keywords)) {
        $keywords = $request->keywords;
        $query->where(function ($q) use ($keywords) {
            $q->where('name', 'like', "%{$keywords}%")
              ->orWhere('email', 'like', "%{$keywords}%");
        });
    }

    $users = $query->paginate(10); // Pagination with 10 items per page

    $action = $request->input('action', 'list');
    $userToEdit = null;

    if ($action === 'edit' && $request->has('user_id')) {
        $userToEdit = User::with('roles')->findOrFail($request->input('user_id'));
    } elseif ($action === 'add') {
        return view('manager.list', compact('users', 'action')); // Show add form
    }

    return view('manager.list', compact('users', 'action', 'userToEdit'));
}

    public function store(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('add-users')) {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'name' => ['required', 'string', 'min:5'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(5)->numbers()->letters()->mixedCase()->symbols()],
            'role' => ['required', 'in:manager,seller,employee,customer'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'credit' => 80000,
        ]);

        $user->assignRole($request->role);

        return redirect()->route('users.manage')->with('success', 'User created!');
    }

    public function update(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('edit-users')) {
            abort(403, 'Unauthorized');
        }
        $user = User::findOrFail($request->input('user_id'));
        $request->validate([
            'name' => ['required', 'string', 'min:5'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:manager,seller,employee,customer'],
            'password' => ['nullable', 'confirmed', Password::min(5)->numbers()->letters()->mixedCase()->symbols()],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save();
        $user->syncRoles([$request->role]);
        return redirect()->route('users.manage')->with('success', 'User updated!');
    }
    public function destroy(User $user)
    {
        if (!Auth::user()->hasPermissionTo('delete-users')) {
            abort(403, 'Unauthorized');
        }
        $user->delete();
        return redirect()->route('users.manage')->with('success', 'User deleted!');
    }

    public function profile(Request $request, User $user = null) {

        $user = $user??auth()->user();
        if(auth()->id()!=$user->id) {
            if(!auth()->user()->hasPermissionTo('show_users_profile')) abort(401);
        }

        $permissions = [];
        foreach($user->permissions as $permission) {
            $permissions[] = $permission;
        }
        foreach($user->roles as $role) {
            foreach($role->permissions as $permission) {
                $permissions[] = $permission;
            }
        }

        return view('users.profile', compact('user', 'permissions'));
     }
    public function doLogout(Request $request) {

    	Auth::logout();

        return redirect('/');

    }
    public function welcomePage()
    {
        return view('welcome');
    }
    public function dashboard()
    {
        // Only allow managers
        if (!Auth::user()->hasPermissionTo('manage-users')) {
        abort(403, 'Unauthorized');
    }
        $totalSales = Order::where('status', '!=', 'cancelled')->sum('total_amount');
        $totalOrders = Order::count();
        $totalProductsSold = OrderItem::sum('quantity');
        $recentOrders = Order::with('user')->orderByDesc('created_at')->limit(10)->get();
        return view('manager.dashboard', compact('totalSales', 'totalOrders', 'totalProductsSold', 'recentOrders'));
    }
    public function showForgotPasswordForm()
    {
        return view('users.forgot_password');
    }

    public function sendResetPassword(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
        $user = User::where('email', $request->email)->first();
        $newPassword = bin2hex(random_bytes(4)); // 8-char random password
        $user->password = bcrypt($newPassword);
        $user->force_change_password = true;
        $user->save();
        try {
            Mail::to($user->email)->send(new ResetPasswordMail($user->name, $newPassword));
        } catch (\Exception $e) {
            \Log::error('Failed to send reset password email: ' . $e->getMessage());
            return back()->withErrors('Failed to send reset password email.');
        }
        return redirect()->route('login')->with('success', 'A new password has been sent to your email.');
    }
    public function showChangePasswordForm()
    {
        return view('users.change_password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Password::min(5)->numbers()->letters()->mixedCase()->symbols()],
        ]);
        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->force_change_password = false;
        $user->save();
        return redirect('/')->with('success', 'Password changed successfully!');
    }
    public function resendVerificationEmail(Request $request)
    {
        // Only allow authenticated users who don't have their email verified
        if (!Auth::check() || (Auth::user() && Auth::user()->email_verified_at)) {
            return redirect()->route('login')->withErrors('You must be logged in or you have already verified your email.');
        }

        $user = Auth::user();
        if ($user && !$user->email_verified_at) {
            $token = Crypt::encryptString(json_encode(['id' => $user->id, 'email' => $user->email]));
            $link = route('verify', ['token' => $token]);
            try {
                Mail::to($user->email)->send(new VerificationEmail($link, $user->name));
                return back()->with('success', 'Verification email sent successfully!');
            } catch (\Exception $e) {
                Log::error('Failed to resend verification email: ' . $e->getMessage());
                return back()->withErrors('Failed to send verification email.');
            }
        }
        return back()->withErrors('Email is already verified or user not found.');
    }
}
