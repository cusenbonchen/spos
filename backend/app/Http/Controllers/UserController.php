<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    // Lấy danh sách tất cả users
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    // Thêm user mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,staff',
            'biometric_key' => 'nullable|string',
            'biometric_enabled' => 'boolean',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'biometric_key' => $request->biometric_key,
            'biometric_enabled' => $request->biometric_enabled ?? false,
        ]);

        return response()->json($user, 201);
    }

    // Lấy thông tin 1 user
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user, 200);
    }

    // Cập nhật user
    public function userUpdate(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $request->validate([
            'name' => 'sometimes|string|max:255', 
            'role' => 'sometimes|in:admin,staff',
            'biometric_key' => 'nullable|string',
            'biometric_enabled' => 'boolean',
        ]);

        $user->update([
            'name' => $request->name ?? $user->name, 
            'role' => $request->role ?? $user->role,
            'biometric_key' => $request->biometric_key,
            'biometric_enabled' => $request->biometric_enabled ?? $user->biometric_enabled,
        ]);

        return response()->json($user, 200);
    }

    // Xóa user
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
