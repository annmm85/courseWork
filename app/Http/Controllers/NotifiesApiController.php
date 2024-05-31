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
        return response()->json([
            'success' => true,
            'code' => 201,
            'message' => 'Уведомление создано',
        ], 201);
    }
    public function bindUser(Request $request, $id): JsonResponse
    {
        $notifies = Notifies::find($id);
        $users = User::find($request->get('user_id'));
        if($users){
            if($notifies) {
                $notifies->user()->attach($request->get('user_id'));
                return response()->json(['Уведомление успешно добавлено пользователю'], 201);
            }else{
                return response()->json(['message' => 'Уведомление не найдено'], 404);
            }
        }else{
            return response()->json(['message' => 'Пользователь не найден'], 404);
        }
    }

    public function read(Request $request): JsonResponse
    {
        $Notifies = Notifies::all();
        return response()->json($Notifies);
    }
    public function readNotifiesByUser(Request $request, $id): JsonResponse
    {
        $user = User::find($id);
        if ($user) {
            $notifies = $user->notifies()->get();
            return response()->json($notifies);
        } else {
            return response()->json(['message' => 'Пользователь не найден'], 404);
        }
    }
    public function readUserByNotifies(Request $request, $id): JsonResponse
    {
        $notifies = Notifies::find($id);
        if ($notifies) {
            $users = $notifies->user()->get();
            return response()->json($users);
        }else {
            return response()->json(['message' => 'Уведомление не найдено'], 404);
        }
    }
    public function updateById(Request $request, $id): JsonResponse
    {
        $Notifies = Notifies::find($id);
        if ($Notifies) {
            $Notifies->update([
                'title' => $request->input('title', $Notifies->title),
                'link' => $request->input('link', $Notifies->link),
            ]);
            if (isset($request->user_id)) {
                $Notifies->user()->update(['user_id' => $request->input('user_id')]);
            }
            $Notifies->save();
            return response()->json($Notifies);
        } else {
            return response()->json(['message' => 'Уведомление не найдено'], 404);
        }
    }
    public function deleteById(Request $request, $id): JsonResponse
    {
        $Notifies = Notifies::find($id);
        if ($Notifies) {
        $Notifies->delete();
        return response()->json($Notifies);
        } else {
            return response()->json(['message' => 'Уведомление не найдено'], 404);
        }
    }
    public function deleteUserByNotifies(Request $request, $id, $user_id): JsonResponse
    {
        $Notifies = Notifies::find($id);
        if ($Notifies) {
            if ($Notifies->user()->pluck('id')[0] == $user_id) {
                $Notifies->user()->detach($user_id);
                return response()->json(['Уведомление успешно удалено у пользователя'], 201);
            }else {
                return response()->json(['message' => 'Уведомление у этого пользователя не найдено'], 404);
            }
        }else {
                return response()->json(['message' => 'Уведомление не найдено'], 404);
        }
    }
}
