<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePublishsApiRequest;
use App\Models\Boxes;
use App\Models\Categories;
use App\Models\Publishs;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublishsApiController extends Controller
{
    public function read(): JsonResponse
    {
        return response()->json(Publishs::all());
    }

    public function categoryRead(Request $request, $id): JsonResponse
    {
        if (!Categories::find($id)) {
            return response()->json(['message' => 'Категория не найдена'], 404);
        }
        return response()->json(Categories::find($id)->publishs()->get());
    }

    public function categoriesByOnePublishRead(Request $request, $id): JsonResponse
    {
        if (!Publishs::find($id)) {
            return response()->json(['message' => 'Публикация не найдена'], 404);
        }
        return response()->json(Publishs::find($id)->categories()->get());
    }

    public function boxesRead(Request $request, $id): JsonResponse
    {
        if (!Boxes::find($id)) {
            return response()->json(['message' => 'Ящик не найден'], 404);
        }
        return response()->json(Boxes::find($id)->publishs()->get());
    }

    public function boxesByOnePublishRead(Request $request, $id): JsonResponse
    {
        if (!Publishs::find($id)) {
            return response()->json(['message' => 'Публикация не найдена'], 404);
        }
        return response()->json(Publishs::find($id)->boxes()->get());

    }

    public function userRead(Request $request, $id): JsonResponse
    {
        if (!User::find($id)) {
            return response()->json(['message' => 'Пользователь не найден'], 404);
        }
        return response()->json(User::find($id)->publishs()->get());
    }

    public function authorsRead(Request $request): JsonResponse
    {
        $authors_id = User::find($request->user()->id)->authors()->get();
        $publishs = Publishs::whereIn('user_id', $authors_id->pluck('id'))->get();
        return response()->json($publishs);
    }

    public function searchQueryRead(Request $request)
    {
        $searchQuery = $request->input('searchQuery');
        $publishs = Publishs::where('title', 'like', '%' . $searchQuery . '%')
            ->orWhere('desc', 'like', '%' . $searchQuery . '%')
            ->get();

        return response()->json($publishs);
    }

    public function create(CreatePublishsApiRequest $request): JsonResponse
    {
        $image = $request->file('image');
        $pathToImage = $image->store('images', 'public');

        $data = $request->all();

        $publication = Publishs::create([
            'title' => $data['title'],
            'desc' => $data['desc'],
            'image' => $pathToImage,
            'user_id' => $request->user()->id,
        ]);

        if (!isset($data['category_id'])) {
            return response()->json(['error' => 'Заполните поле категории'], 422);
        }
        if (!Categories::find($data['category_id'])) {
            return response()->json(['error' => 'Категория не найдена'], 422);
        }
        $publication->categories()->attach($data['category_id']);
        return response()->json(['message' => 'Публикация успешно создана'], 201);
    }

    public function saveInBox(Request $request, $id): JsonResponse
    {
        $box = Boxes::find($request->get('box_id'));
        if (!$box) {
            return response()->json(['error' => 'Ящик не найден'], 404);
        }

        $user = $request->user();
        if (!$user->boxes->contains($box)) {
            return response()->json(['error' => 'Это не ваш ящик'], 404);
        }

        $publish = Publishs::find($id);
        if (!$publish) {
            return response()->json(['error' => 'Публикация не найдена'], 404);
        }

        if ($publish->boxes()->where('id', $box->id)->exists()) {
            return response()->json(['error' => 'Публикация уже есть в ящике'], 404);
        }

        $publish->boxes()->attach($box);
        return response()->json([
            'success' => true,
            'code' => 201,
            'message' => 'Публикация добавлена в ящик',
        ], 201);
    }

    public function addCategory(Request $request, $id): JsonResponse
    {
        $publishs = Publishs::find($id);
        if (!$publishs) {
            return response()->json(['error' => 'Публикация не найдена'], 404);
        }

        if ($request->user()->id !== $publishs->author_id && $request->user()->id !== 1) {
            return response()->json(['error' => 'Вы не являетесь автором этой публикации/администратором'], 403);
        }

        $category_id = $request->get('category_id');
        if ($publishs->categories()->where('id', $category_id)->exists()) {
            return response()->json(['error' => 'Публикация уже прикреплена к категории'], 404);
        }

        $category = Categories::find($category_id);
        if (!$category) {
            return response()->json(['error' => 'Категория не найдена'], 404);
        }

        $publishs->categories()->attach($category_id);
        return response()->json(['message' => 'Категория успешно добавлена в публикацию'], 201);
    }


    public function updateById(Request $request, $id): JsonResponse
    {
        $publishs = Publishs::find($id);
        if (!$publishs) {
            return response()->json(['error' => 'Публикация не найдена'], 404);
        }

        if ($request->user()->id !== $publishs->author_id && $request->user()->id !== 1) {
            return response()->json(['error' => 'Вы не являетесь автором этой публикации/администратором'], 403);
        }

        $image = $request->file('image');
        if ($image) {
            $pathToImage = $image->store('images', 'public');
            $publishs->image = $pathToImage;
        }

        $publishs->title = $request->input('title', $publishs->title);
        $publishs->desc = $request->input('desc', $publishs->desc);

        $box_id = $request->input('box_id');
        if ($box_id && !$publishs->boxes()->where('id', $box_id)->exists()) {
            $box = Boxes::find($box_id);
            if (!$box) {
                return response()->json(['error' => 'Ящик не найден'], 404);
            }
            $publishs->boxes()->attach($box_id);
        }

        $category_id = $request->input('category_id');
        if ($category_id && !$publishs->categories()->where('id', $category_id)->exists()) {
            $category = Categories::find($category_id);
            if (!$category) {
                return response()->json(['error' => 'Категория не найдена'], 404);
            }
            $publishs->categories()->attach($category_id);
        }

        $publishs->save();
        return response()->json(['message' => 'Публикация успешно изменена'], 201);
    }

    public function deleteById(Request $request, $id): JsonResponse
    {
        $publish = Publishs::find($id);

        if (!$publish) {
            return response()->json(['message' => 'Публикация не найдена'], 404);
        }

        if ($request->user()->id !== $publish->author_id && $request->user()->id !== 1) {
            return response()->json(['error' => 'Вы не являетесь автором этой публикации/администратором'], 403);
        }

        $publish->categories()->detach();
        $publish->delete();

        return response()->json(['message' => 'Публикация успешно удалена'], 201);
    }

    public function deleteInBox(Request $request, $box_id, $id): JsonResponse
    {
        $box = Boxes::find($box_id);
        $publish = Publishs::find($id);

        if (!$box) {
            return response()->json(['message' => 'Ящик не найден'], 404);
        }

        if (!$publish) {
            return response()->json(['message' => 'Публикация не найдена'], 404);
        }

        if (!$box->publishs->contains($id)) {
            return response()->json(['message' => 'В ящике не найдена публикация'], 404);
        }

        $publish->boxes()->detach($box_id);

        return response()->json(['message' => 'Публикация успешно удалена из ящика'], 200);
    }

    public function deleteCategory(Request $request, $category_id, $id): JsonResponse
    {
        $category = Categories::find($category_id);
        $publish = Publishs::find($id);

        if (!$category) {
            return response()->json(['error' => 'Категория не найдена'], 404);
        }

        if (!$publish) {
            return response()->json(['error' => 'Публикация не найдена'], 404);
        }

        if (!$publish->categories->contains($category_id)) {
            return response()->json(['error' => 'У публикации нет такой категории'], 404);
        }

        if ($publish->categories()->count() <= 1) {
            return response()->json(['error' => 'Нельзя удалить последнюю категорию публикации'], 400);
        }

        $publish->categories()->detach($category_id);

        return response()->json(['message' => 'Категория успешно удалена из публикации'], 200);
    }
}
