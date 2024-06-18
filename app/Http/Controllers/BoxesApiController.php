<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoriesApiRequest;
use App\Models\Boxes;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BoxesApiController extends Controller
{
    public function create(CreateCategoriesApiRequest $request): JsonResponse
    {
        $data = $request->all();
        Boxes::create([
            'name' => $data['name'],
            'user_id' => $request->user()->id,
        ]);
        return response()->json(['message' => 'Ящик создан'], 201);
    }

    public function read(Request $request): JsonResponse
    {
        $Boxes = Boxes::all();
        return response()->json($Boxes);
    }
    public function readByUser(Request $request): JsonResponse
    {
        return response()->json(User::find($request->user()->id)->boxes()->get());
    }
    public function updateById(Request $request, $id): JsonResponse
    {
        $Boxes = Boxes::find($id);
        if ($Boxes) {
            if ($request->user()->id !== $Boxes->user_id && $request->user()->id !== 1) {
                return response()->json(['error' => 'Вы не являетесь автором/администратором этого ящика'], 403);
            }
            $Boxes->update([
                'name' => $request->input('name', $Boxes->name),
            ]);
            $Boxes->save();
            return response()->json($Boxes);
        } else {
            return response()->json(['message' => 'Ящик не найден'], 404);
        }
    }

    public function deleteById(Request $request, $id): JsonResponse
    {
        $Boxes = Boxes::find($id);
        if ($Boxes) {
            $Boxes->delete();
            return response()->json($Boxes);
        } else {
            return response()->json(['message' => 'Ящик не найден'], 404);
        }
    }
}
