<?php

namespace App\Http\Controllers\notifies;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoriesApiRequest;
use App\Models\Notifies;
use App\Models\Publishs;
use App\Models\Usernotifies;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsernotifiesApiController extends Controller
{
    public function createByIdNotify(Request $request, $id): JsonResponse
    {
        $data = $request->all();
        Usernotifies::create([
            'user_id' => $data['user_id'],
            'notify_id' => $id,
        ]);
        return response()->json([
            'success' => true,
            'code' => 201,
            'message' => 'Уведомление отправлено пользователю',
        ], 201);
    }

    public function readUserNotifies(Request $request): JsonResponse
    {
        $all_notifies=[];
        $ff_notif_id = Usernotifies::where('user_id', $request->user()->id)->get('notify_id');
        foreach ($ff_notif_id as $notif) {
            $notifies= Notifies::where('id', $notif['notify_id'])->get()[0];
            array_push($all_notifies, $notifies);
        }
        return response()->json($all_notifies);
    }

    public function updateByIdUsernotifies(Request $request, $id, $user_id): JsonResponse
    {
        $Usernotifies = Usernotifies::where(['notify_id'=>$id, 'user_id'=>$user_id])->get()[0];

        $Usernotifies->update([
            'notify_id' => $request->input('notify_id', $Usernotifies->notify_id),
            'user_id' => $request->input('user_id', $Usernotifies->user_id),
        ]);
        $Usernotifies->save();
        return response()->json($Usernotifies);
    }

    public function deleteById(Request $request, $id, $user_id): JsonResponse
    {
        $Usernotifies = Usernotifies::where(['notify_id'=>$id, 'user_id'=>$user_id])->get()[0];
        $Usernotifies->delete();
        return response()->json($Usernotifies);
    }
}
