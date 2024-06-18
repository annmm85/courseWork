<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNotifiesApiRequest;
use App\Models\Notifies;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotifiesApiController extends Controller
{
    public function create(CreateNotifiesApiRequest $request): JsonResponse
    {
        $data = $request->all();
        Notifies::create([
            'title' => $data['title'],
            'link' => $data['link'],
        ]);
        return response()->json(['message' => 'Уведомление создано'], 201);
    }

    public function bindUser(Request $request, $id): JsonResponse
    {
        $notifies = Notifies::find($id);
        $users = User::find($request->get('user_id'));
        if (!$users) {
            return response()->json(['message' => 'Пользователь не найден'], 404);
        }
        if (!$notifies) {
            return response()->json(['message' => 'Уведомление не найдено'], 404);
        }
        $notifies->user()->attach($request->get('user_id'));
        return response()->json(['Уведомление успешно добавлено пользователю'], 201);
    }

    public function read(Request $request): JsonResponse
    {
        $Notifies = Notifies::all();
        return response()->json($Notifies);
    }

    public function readNotifiesByUser(Request $request, $id): JsonResponse
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Пользователь не найден'], 404);
        }
        $notifies = $user->notifies()->get();
        return response()->json($notifies);
    }

    public function readUserByNotifies(Request $request, $id): JsonResponse
    {
        $notifies = Notifies::find($id);
        if (!$notifies) {
            return response()->json(['message' => 'Уведомление не найдено'], 404);

        }
        $users = $notifies->user()->get();
        return response()->json($users);
    }

    public function updateById(Request $request, $id): JsonResponse
    {
        $Notifies = Notifies::find($id);
        if (!$Notifies) {
            return response()->json(['message' => 'Уведомление не найдено'], 404);
        }
        $Notifies->update([
            'title' => $request->input('title', $Notifies->title),
            'link' => $request->input('link', $Notifies->link),
        ]);
        if (isset($request->user_id)) {
            if (!User::find($request->input('user_id'))) {
                return response()->json(['message' => 'Пользователь не найден'], 404);
            }
            $Notifies->user()->update(['user_id' => $request->input('user_id')]);
        }
        $Notifies->save();
        return response()->json($Notifies);
    }

    public function deleteById(Request $request, $id): JsonResponse
    {
        $Notifies = Notifies::find($id);
        if (!$Notifies) {
            return response()->json(['message' => 'Уведомление не найдено'], 404);
        }
        $Notifies->delete();
        return response()->json($Notifies);
    }

    public function deleteUserByNotifies(Request $request, $id, $user_id): JsonResponse
    {
        $Notifies = Notifies::find($id);
        if (!$Notifies) {
            return response()->json(['message' => 'Уведомление не найдено'], 404);
        }
        if ($Notifies->user()->pluck('id')[0] !== $user_id) {
            return response()->json(['message' => 'Уведомление у этого пользователя не найдено'], 404);
        }
        $Notifies->user()->detach($user_id);
        return response()->json(['Уведомление успешно удалено у пользователя'], 201);

    }
}
