<?php

namespace App\Http\Controllers\notifies;

use App\Http\Controllers\Controller;
use App\Models\Notifies;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotifiesApiController extends Controller
{
    public function create(Request $request): JsonResponse
    {
        $data = $request->all();
        Notifies::create([
            'title' => $data['title'],
            'link' => $data['link'],
            'image' => $data['image'],
        ]);
        return response()->json([
            'success' => true,
            'code' => 201,
            'message' => 'Уведомление создано',
        ], 201);
    }
    public function bindUser(Request $request, $id): JsonResponse
    {
        Notifies::find($id)->user()->attach($request->get('user_id'));
        return response()->json([
            'success' => true,
            'code' => 201,
            'message' => 'Уведомление успешно добавлено пользователю',
        ], 201);
    }

    public function read(Request $request): JsonResponse
    {
        $Notifies = Notifies::all();
        return response()->json($Notifies);
    }
    public function readNotifiesByUser(Request $request, $id): JsonResponse
    {
        $notifies = User::find($id)->notifies()->get();
        return response()->json($notifies);
    }
    public function readUserByNotifies(Request $request, $id): JsonResponse
    {
        $users = Notifies::find($id)->user()->get();
        return response()->json($users);
    }
    public function updateById(Request $request, $id): JsonResponse
    {
        $Notifies = Notifies::find($id);
        $Notifies->update([
            'title' => $request->input('title', $Notifies->title),
            'link' => $request->input('link', $Notifies->link),
            'image' => $request->input('image', $Notifies->image),
        ]);
        if(isset($request->user_id)) {
            $Notifies->user()->update(['user_id' => $request->input('user_id')]);
        }
        $Notifies->save();
        return response()->json($Notifies);
    }
    public function deleteById(Request $request, $id): JsonResponse
    {
        $Notifies = Notifies::find($id);
        $Notifies->delete();
        return response()->json($Notifies);
    }
    public function deleteByUser(Request $request, $notify_id, $id): JsonResponse
    {
        Notifies::find($id)->notifies()->detach($notify_id);
        return response()->json([
            'success' => true,
            'code' => 201,
            'message' => 'Уведомление успешно удалено у пользователя',
        ], 201);
    }
}
