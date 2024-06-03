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
        if ($data['role_id']) {
            if ($data['role_id'] > 2) {
                return response()->json(['error' => 'Может быть только 1 - админ, 2-пользователь',], 404);
            } else if ($data['role_id'] == 2) {
                $role_id = 2;
            }
            $role_id = 1;
        } else $role_id = 2;
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $role_id
        ]);
        return response()->json([
            'success' => true,
            'code' => 201,
            'message' => 'Success',
        ], 201);
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
