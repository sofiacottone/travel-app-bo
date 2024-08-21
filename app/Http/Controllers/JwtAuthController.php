<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtAuthController extends Controller
{
    // Register a new user
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'success' => true,
            'token' => $token
        ], 201);
    }

    // Login user and return a token
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        return response()->json([
            'success' => true,
            'token' => $token
        ]);
    }

    // Logout user by invalidating the token
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::parseToken());
        return response()->json([
            'success' => true,
            'message' => 'Successfully logged out'
        ]);
    }

    // Get authenticated user
    public function authUser()
    {
        $user = JWTAuth::parseToken()->authenticate();
        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }
}
