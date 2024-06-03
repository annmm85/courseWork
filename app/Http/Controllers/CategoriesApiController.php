<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoriesApiRequest;
use App\Models\Categories;
use App\Models\Publishs;
use App\Models\User;
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
    public function mainRead(Request $request): JsonResponse
    {
        $interestPublishs = [];
        $user = User::find($request->user()->id);
        $idInterestCategories = $user->categories()->pluck('id');

        foreach ($idInterestCategories as $category) {
            $publishs = Categories::find($category)->publishs()->get();
            array_push($interestPublishs, $publishs);
        }

        if ($user->authors()) {
            $authors_publishs = Publishs::whereIn('user_id', $user->authors()->get()->pluck('id'))->get()->toArray();
            $interestPublishs = array_merge($interestPublishs, $authors_publishs);
        }
        return response()->json($interestPublishs);
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
