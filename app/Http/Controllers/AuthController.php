<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterAdminRequest;
use App\Http\Requests\RegisterParentRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function getAllUsers()
    {
        $users = User::all();

        return UserResource::collection($users);
    }

    public function registerAdmin(RegisterAdminRequest $request)
    {
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            $admin = User::create([
                'name' => $request->validated()['name'],
                'email' => $request->validated()['email'],
                'role' => 'admin',
                'password' => Hash::make('default_password'),
            ]);

            $admin->addRole('admin');

            $status = Password::sendResetLink(['email' => $admin->email]);

            if ($status == Password::RESET_LINK_SENT) {
                return response()->json([
                    'message' => 'Admin registered successfully. A password reset email has been sent.',
                    'admin' => new UserResource($admin),
                ]);
            } else {
                return response()->json([
                    'message' => 'Admin registered successfully, but the password reset email could not be sent.',
                    'admin' => new UserResource($admin),
                ], 500);
            }
        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
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

            $status = Password::sendResetLink(['email' => $parent->email]);

            if ($status == Password::RESET_LINK_SENT) {
                return response()->json([
                    'message' => 'Parent registered successfully. A password reset email has been sent.',
                    'parent' => new UserResource($parent),
                ]);
            } else {
                return response()->json([
                    'message' => 'Parent registered successfully, but the password reset email could not be sent.',
                    'parent' => new UserResource($parent),
                ], 500);
            }
        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
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
            'user' => new UserResource($user),
        ]);
    }
}
