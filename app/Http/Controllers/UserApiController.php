<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
//    создание пользователя - регистрация уже создана
    public function subscribe(Request $request): JsonResponse
    {
        $authors = User::find($request->user()->id)->authors();
        if (User::find($request->author_id)) {
            if (!in_array($request->get('author_id'), $authors->pluck('id')->toArray())) {
                $authors->attach($request->author_id);
                return response()->json(['Вы успешно подписаны'], 201);
            } else {
                return response()->json(['Вы уже подписаны на пользователя'], 404);
            }
        } else {
            return response()->json(['Пользователь не найден'], 404);
        }
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
        $authors = User::find($request->user()->id)->authors();
        if (User::find($id)) {
            if (in_array($id, $authors->pluck('id')->toArray())) {
                $authors->detach($id);
                return response()->json(['message' => 'Вы успешно отписались от автора'], 201);
            } else {
                return response()->json(['Вы не подписаны на пользователя'], 404);
            }
        } else {
            return response()->json(['Пользователь не найден'], 404);
        }
    }
}
