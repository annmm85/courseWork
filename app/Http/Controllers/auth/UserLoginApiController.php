<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;


class UserLoginApiController extends Controller
{
    use HasApiTokens;

    public function login(UserLoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->get('email'))->first();

        if (!$user || !Hash::check($request->get('password'), $user->password)) {
            return response()->json([
                'message' => 'Почта или пароль некорректны.'
            ], 422);
        }

        $user->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'token' => $user->createToken('authToken')->plainTextToken
        ]);
    }



}
