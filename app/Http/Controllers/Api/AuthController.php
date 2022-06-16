<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function register(StoreUserRequest $request): JsonResponse
    {
        $user = User::create($request->validated());

        return response()->json([
            'user' => $user,
            'token' => $user->createToken('My token')->plainTextToken,
        ], 201);
    }

    public function login(LoginUserRequest $request): JsonResponse
    {
        $credentials = $request->validated();
        $user = User::where('email', $credentials['email'])->first();

        if (auth()->attempt($credentials)) {
            return response()->json([
                'user' => $user,
                'token' => $user->createToken('My token')->plainTextToken,
            ], 200);
        }

        return response()->json([
            'message' => 'Invalid credentials',
        ], 401);

    }
}
