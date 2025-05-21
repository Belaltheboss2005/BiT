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



    // public function index()
    // {
    //     if (!Auth::user()->hasPermissionTo('show-users')) {
    //         abort(403, 'Unauthorized');
    //     }
    //     $users = User::all();
    //     return view('users.list', compact('users'));
    // }
    public function manageUsers(Request $request)
{
    if (!Auth::user()->hasPermissionTo('show-users')) {
        abort(403, 'Unauthorized');
    }

    $query = User::with('roles');

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
        return view('users.list', compact('users', 'action')); // Show add form
    }

    return view('users.list', compact('users', 'action', 'userToEdit'));
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
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'credit' => 80000,
        ]);

        $user->assignRole('customer');

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
        ]);

        $user->update($request->only(['name', 'email']));
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




