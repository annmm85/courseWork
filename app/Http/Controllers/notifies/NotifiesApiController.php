<?php

namespace App\Http\Controllers\notifies;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoriesApiRequest;
use App\Models\Notifies;
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

    public function read(Request $request): JsonResponse
    {
        $Notifies = Notifies::all();
        return response()->json($Notifies);
    }

    public function updateById(Request $request, $id): JsonResponse
    {
        $Notifies = Notifies::find($id);
        $Notifies->update([
            'title' => $request->input('title', $Notifies->title),
            'link' => $request->input('link', $Notifies->link),
            'image' => $request->input('image', $Notifies->image),
        ]);
        $Notifies->save();
        return response()->json($Notifies);
    }

    public function deleteById(Request $request, $id): JsonResponse
    {
        $Notifies = Notifies::find($id);
        $Notifies->delete();
        return response()->json($Notifies);
    }
}
