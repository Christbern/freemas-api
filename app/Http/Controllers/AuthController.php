<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|unique:users,phone',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if (!$request->email && !$request->phone) {
            return response()->json([
                'success' => false,
                'message' => 'Email or phone number is required',
            ]);
        }
        $validated['password'] = Hash::make($validated['password']);
        $user = $this->userRepository->store($validated);

        $token = $user->createToken('freemas_api_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'user' => $user,
            'token' => $token,
            'message' => 'Account created successfully.',
        ]);
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'identifier' => 'required|string',
            'password' => 'required|string',
        ]);
        $identifier = $validated['identifier'];
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $user = $this->userRepository->getByEmail($identifier);
        } else {
            $user = $this->userRepository->getByPhoneNumber($identifier);
        }

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json(['success' => false, 'message' => 'Invalid credentials']);
        }

        $token = $user->createToken('freemas_api_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    }

    public function refresh(Request $request)
    {
        $user = $request->user();

        $user->currentAccessToken()->delete();

        $newToken = $user->createToken('freemas_api_token')->plainTextToken;

        return response()->json([
            'message' => 'Token refreshed.',
            'token' => $newToken,
        ]);
    }
}
