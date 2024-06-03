<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Admin
{

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (+$user->role_id !== 1){
            return response()->json(['message' => 'У вас нет прав доступа к данной странице'], 403);
        }
        return $next($request);
    }
}
