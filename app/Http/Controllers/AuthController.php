<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterAdminRequest;
use App\Http\Requests\RegisterParentRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function getAllUsers()
    {
        $users = User::all();

        return response()->json($users);
    }

    public function registerAdmin(RegisterAdminRequest $request)
    {
        $admin = User::create([
            'name' => $request->validated()['name'],
            'email' => $request->validated()['email'],
            'role' => 'admin',
            'password' => Hash::make('default_password'),
        ]);

        $admin->addRole('admin');

        Password::sendResetLink(['email' => $admin->email]);

        return response()->json([
            'message' => 'Admin registered successfully. A password reset email has been sent.',
            'admin' => $admin,
        ]);
    }

    public function registerParent(RegisterParentRequest $request)
    {
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            $parent = User::create([
                'name' => $request->validated()['name'],
                'email' => $request->validated()['email'],
                'role' => 'parent',
                'password' => Hash::make($request->validated()['password']),
            ]);

            $parent->addRole('parent');

            Password::sendResetLink(['email' => $parent->email]);

            return response()->json([
                'message' => 'Parent registered successfully. Password reset email sent.',
                'parent' => $parent,
            ]);
        }
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (! Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = User::find(Auth::id());
        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }
}
