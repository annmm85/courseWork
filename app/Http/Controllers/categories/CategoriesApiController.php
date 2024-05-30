<?php

namespace App\Http\Controllers\categories;

use App\Http\Controllers\Controller;
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
            'name' => $data['name']
        ]);

        return response()->json([
            'success' => true,
            'code' => 201,
            'message' => 'Success',
        ], 201);
    }
    public function read(): JsonResponse
    {
        $Categories = Categories::all();

        return response()->json($Categories);
    }

    public function updateById(Request $request, $id): JsonResponse
    {
        $Categories = Categories::find($id);

        $Categories->update([
            'name' => $request->input('name', $Categories->name),
        ]);
        $Categories->save();
        return response()->json($Categories);
    }

    public function deleteById(Request $request, $id): JsonResponse
    {

        $Categories = Categories::find($id);
        $Categories->delete();
        return response()->json($Categories);
    }
}
