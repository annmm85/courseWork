<?php

namespace App\Http\Controllers\boxes;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoriesApiRequest;
use App\Models\Boxes;
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
        return response()->json([
            'success' => true,
            'code' => 201,
            'message' => 'Ящик создан',
        ], 201);
    }

    public function read(Request $request): JsonResponse
    {
        $Boxes = Boxes::all();
        return response()->json($Boxes);
    }

    public function updateById(Request $request, $id): JsonResponse
    {
        $Boxes = Boxes::find($id);

        $Boxes->update([
            'name' => $request->input('name', $Boxes->name),
        ]);
        $Boxes->save();
        return response()->json($Boxes);
    }

    public function deleteById(Request $request, $id): JsonResponse
    {
        $Boxes = Boxes::find($id);
        $Boxes->delete();
        return response()->json($Boxes);
    }
}
