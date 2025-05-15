<?php

namespace App\Http\Controllers;

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

class UserController extends Controller
{
    use ValidatesRequests;


    public function login(Request $request) {
        return view('users.login');
    }

    public function doLogin(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user->hasRole('Banned')) {
            return redirect()->route('banned_page');
        }

        // if (!$user || !$user->email_verified_at) {
        //     return redirect()->back()->withInput($request->input())
        //         ->withErrors('Your email is not verified.');
        // }

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->back()->withInput($request->input())
                ->withErrors('Invalid login information.');
        }

        Auth::setUser($user);

        return redirect('/')->with('success', 'Login successful!');
    }




    public function register(Request $request) {
        return view('users.register');
    }

    public function doRegister(Request $request) {

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

        // Assign the "customer" role to the user


        // Check email verification preference
        // if ($request->email_verification === 'now') {
        //     $title = "Verification Link";
        //     $token = Crypt::encryptString(json_encode(['id' => $user->id, 'email' => $user->email]));
        //     $link = route("verify", ['token' => $token]);
        //     try {
        //         Mail::to($user->email)->send(new VerificationEmail($link, $user->name));
        //         Log::info('Verification email sent successfully to ' . $user->email);
        //     } catch (\Exception $e) {
        //         Log::error('Failed to send verification email: ' . $e->getMessage());
        //     }
        // }

        return redirect()->route('login')->with('success', 'Registration successful!');
    }

    public function profile(Request $request, User $user = null) {

        $user = $user??auth()->user();
        // if(auth()->id()!=$user->id) {
        //     if(!auth()->user()->hasPermissionTo('show_users')) abort(401);
        // }

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

}
