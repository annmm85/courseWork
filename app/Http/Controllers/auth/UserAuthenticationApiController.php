<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserAuthenticationApiController extends Controller
{
    public function register(UserRegistrationRequest $request): JsonResponse
    {
        $data = $request->all();
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $data['role_id'] ?? 2
        ]);
        return response()->json(['message' => 'Успешная регистрация'], 201);
    }

    public function logout(Request $request): JsonResponse
    {
        if ($request->user()->tokens()->delete()) {
            return response()->json([
                'message' => 'Успешный выход'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Что-то не так, попробуйте еще раз'
            ], 500);
        }
    }
}
