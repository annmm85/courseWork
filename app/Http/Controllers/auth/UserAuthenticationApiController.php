<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserAuthenticationApiController extends Controller
{
    public function register(UserRegistrationRequest $request): JsonResponse
    {
        $data = $request->all();

        User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>Hash::make($data['password']),
        ]);
        return response()->json([
            'success' => true,
            'code' => 201,
            'message' => 'Success',
        ],201);
    }
}
