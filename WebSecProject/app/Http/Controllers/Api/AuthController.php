<?php
namespace App\Http\Controllers\API;
use Spatie\Permission\Models\Role;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // $user = User::find($user->id);
        // $user->assignRole('customer');

        if (! $user->hasRole('customer')) {
        $user->assignRole('customer');
        }

        $token = $user->createToken('auth_token')->accessToken;

        return response()->json([
            'user' => $user,
            'access_token' => $token,
            'message' => 'User registered successfully.',
        ], 201);
    }

    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $token = $user->createToken('auth_token')->accessToken;

    return response()->json([
        'user' => $user,
        'access_token' => $token,
        'message' => 'Login successful.',
    ]);
}

public function logout(Request $request)
{
    auth()->user()->token()->revoke();

    return response()->json(['message' => 'Logged out successfully']);
}
}
