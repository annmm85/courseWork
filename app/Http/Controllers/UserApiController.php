<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserApiController extends Controller
{
    public function subscribe(Request $request, $id): JsonResponse
    {
        $authors = User::find($request->user()->id)->authors();
        if (!User::find($id)) {
            return response()->json(['Пользователь не найден'], 404);
        }
        if (in_array($id, $authors->pluck('id')->toArray())) {
            return response()->json(['Вы уже подписаны на пользователя'], 404);
        }
        $authors->attach($id);
        return response()->json(['Вы успешно подписаны'], 201);
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
    public function read(Request $request): JsonResponse
    {
        $Boxes = User::all();
        return response()->json($Boxes);
    }

    public function updateRoleById(Request $request, $id): JsonResponse
    {
        $user = User::find($id);
        if ($user) {
            if ($request->get('role_id') > 2) {
                return response()->json(['error' => 'Может быть только следующие роли: 1 - админ, 2 - пользователь',], 404);
            }
            $user->update([
                'role_id' => $request->input('role_id', $user->role_id),
            ]);
            $user->save();
            return response()->json($user);
        } else {
            return response()->json(['message' => 'Пользователь не найден'], 404);
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
    public function readUsersByRole(Request $request, $id): JsonResponse
    {
        $authors = User::where('role_id', $id)->get();
        return response()->json($authors);
    }
}
