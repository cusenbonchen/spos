<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Đăng nhập bằng email + password
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    // Đăng nhập bằng sinh trắc học
    public function loginWithBiometric(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'biometric_key' => 'required|string'
        ]);

        $user = User::where('email', $request->email)
                    ->where('biometric_enabled', true)
                    ->where('biometric_key', $request->biometric_key)
                    ->first();

        if (!$user) {
            return response()->json(['message' => 'Biometric login failed'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Biometric login successful',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    // Đăng xuất (xóa token)
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logout successful']);
    }

    // Lấy thông tin user đang đăng nhập
    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
