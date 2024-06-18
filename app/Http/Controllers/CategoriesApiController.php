<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoriesApiRequest;
use App\Models\Categories;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoriesApiController extends Controller
{
    public function create(CreateCategoriesApiRequest $request): JsonResponse
    {
        $data = $request->all();

        Categories::create([
            'name' => $data['name'],
        ]);

        return response()->json(['message' => 'Категория успешно создана'], 201);
    }

    public function read(): JsonResponse
    {
        $Categories = Categories::all();

        return response()->json($Categories);
    }
    public function updateById(Request $request, $id): JsonResponse
    {
        $Categories = Categories::find($id);
        if (!$Categories) {
            return response()->json(['message' => 'Категория не найдена'], 404);
        }
        $Categories->update([
            'name' => $request->input('name', $Categories->name),
        ]);
        $Categories->save();
        return response()->json($Categories);
    }

    public function deleteById(Request $request, $id): JsonResponse
    {
        $Categories = Categories::find($id);
        if (!$Categories) {
            return response()->json(['message' => 'Категория не найдена'], 404);
        }
        $Categories->delete();
        return response()->json(['Категория успешно удалена'], 201);
    }


}
