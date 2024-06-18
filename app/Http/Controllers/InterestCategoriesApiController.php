<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Publishs;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InterestCategoriesApiController extends Controller
{
    public function addCategoryInterest(Request $request): JsonResponse
    {
        $userCategories = User::find($request->user()->id)->categories();
        if (isset($data['category_id'])) {
            return response()->json(['error' => 'Заполните поле категории'], 422);
        }
        if (!Categories::find($request->get('category_id'))) {
            return response()->json(['Категория не найдена'], 404);
        }
        $categories = $userCategories->pluck('id')->toArray();
        if (in_array($request->get('category_id'), $categories)) {
            return response()->json(['Категория уже добавлена в интересующие'], 404);
        }
        $userCategories->attach($request->get('category_id'));
        return response()->json(['Категория успешно добавлена в интересующие'], 201);
    }

    public function readInterestCategory(Request $request): JsonResponse
    {
        return response()->json(User::find($request->user()->id)->categories);
    }

    public function deleteByIdCategoryInterest(Request $request, $id): JsonResponse
    {
        $userInterestCategories = User::find($request->user()->id)->categories();
        if (!Categories::find($id)) {
            return response()->json(['Категория не найдена'], 404);
        }
        $categories = $userInterestCategories->pluck('id')->toArray();
        if (!in_array($id, $categories)) {
            return response()->json(['Категория не найдена в интересующих'], 404);
        }
        if ($userInterestCategories->count() <= 1) {
            return response()->json(['error' => 'Нельзя удалить последнюю интересующую категорию'], 400);
        }
        $userInterestCategories->attach($request->get('category_id'));
        return response()->json(['Категория успешно удалена из интересующих'], 201);
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
}
