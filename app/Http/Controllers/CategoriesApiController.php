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
            'name' => $data['name']
        ]);

        return response()->json([
            'success' => true,
            'code' => 201,
            'message' => 'Success',
        ], 201);
    }


    public function addCategoryInterest(Request $request): JsonResponse
    {
        $userCategories = User::find($request->user()->id)->categories();
        if (Categories::find($request->get('category_id'))) {
            $categories = $userCategories->pluck('id')->toArray();
            if (!in_array($request->get('category_id'), $categories)) {
                $userCategories->attach($request->get('category_id'));
                return response()->json(['Категория успешно добавлена в интересующие'], 201);
            } else {
                return response()->json(['Категория уже добавлена в интересующие'], 404);
            }
        } else {
            return response()->json(['Категория не найдена'], 404);
        }
    }

    public function read(): JsonResponse
    {
        $Categories = Categories::all();

        return response()->json($Categories);
    }

    public function mainRead(Request $request): JsonResponse
    {
        $idInterestCategories = User::find($request->user()->id)->categories()->pluck('id');
        $interestPublishs = [];
        foreach ($idInterestCategories as $category) {
            $publishs = Categories::find($category)->publishs()->get();
            array_push($interestPublishs, $publishs);
        }
        return response()->json($interestPublishs);

//        if (Categories::find($id)) {
//            return response()->json(Categories::find($id)->publishs()->get());
//        } else {
//            return response()->json(['message' => 'Категория не найдена'], 404);
//        }
    }

    public function updateById(Request $request, $id): JsonResponse
    {
        $Categories = Categories::find($id);

        if ($Categories) {
            $Categories->update([
                'name' => $request->input('name', $Categories->name),
            ]);
            $Categories->save();
            return response()->json($Categories);
        } else {
            return response()->json(['message' => 'Категория не найдена'], 404);
        }
    }

    public function deleteById(Request $request, $id): JsonResponse
    {
        $Categories = Categories::find($id);
        if ($Categories) {
            $Categories->delete();
            return response()->json($Categories);
        } else {
            return response()->json(['message' => 'Категория не найдена'], 404);
        }
    }
}
