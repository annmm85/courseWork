<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
//    создание пользователя - регистрация уже создана
    public function subscribe(Request $request): JsonResponse
    {
        User::find($request->user()->id)->authors()->attach($request->get('author_id'));

        return response()->json([
            'success' => true,
            'code' => 201,
            'message' => 'ВЫ успешно подписались',
        ], 201);
    }
    public function readAuthors(Request $request): JsonResponse
    {
        $authors = User::find($request->user()->id)->authors()->get();
        return response()->json($authors);
    }
    public function readSubscribers(Request $request): JsonResponse
    {
        $subscribers = User::find($request->user()->id)->user()->get();
        return response()->json($subscribers);
    }
    public function unsubscribe(Request $request, $id): JsonResponse
    {
        User::find($request->user()->id)->authors()->detach($id);

        return response()->json([
            'success' => true,
            'code' => 201,
            'message' => 'ВЫ успешно отписались от автора',
        ], 201);
    }
}
