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
        return response()->json(Categories::find($id)->publishs()->get());
    }
    public function categoriesOnePublishRead(Request $request, $id): JsonResponse
    {
        return response()->json(Publishs::find($id)->categories()->get());
    }
    public function boxesRead(Request $request, $id): JsonResponse
    {
        return response()->json(Boxes::find($id)->publishs()->get());
    }
    public function boxesOnePublishRead(Request $request, $id): JsonResponse
    {
        return response()->json(Publishs::find($id)->boxes()->get());
    }
    public function userRead(Request $request, $id): JsonResponse
    {
        $publishs = User::find($id)->publishs()->get();
        return response()->json($publishs);
    }
    public function authorsRead(Request $request): JsonResponse
    {
        $authors_id = User::find($request->user()->id)->authors()->get();
        $publishs=Publishs::whereIn('user_id', $authors_id->pluck('id'))->get();
        return response()->json($publishs);
    }

    public function searchQueryRead(Request $request)
    {
        $searchQuery = $request->input('searchQuery');

        $publishs = Publishs::where('title', 'like', '%'.$searchQuery.'%')
            ->orWhere('desc', 'like', '%'.$searchQuery.'%')
            ->get();

        return response()->json($publishs);
    }


    public function create(CreatePublishsApiRequest $request): JsonResponse
    {
        $data = $request->all();

        $publication = Publishs::create([
            'title' => $data['title'],
            'desc' => $data['desc'],
            'image' => $data['image'],
            'user_id' => $request->user()->id,
        ]);

        if(isset($data['category_id'])) {
            $publication->categories()->attach($data['category_id']);
        } else {
            return response()->json([
                'success' => false,
                'code' => 422,
                'message' => 'Пожалуйста выберите категорию',
            ], 422);
        }
        return response()->json([
            'success' => true,
            'code' => 201,
            'message' => 'Success',
        ], 201);
    }
    public function saveInBox(Request $request, $id): JsonResponse
    {
        Publishs::find($id)->boxes()->attach($request->get('box_id'));

        return response()->json([
            'success' => true,
            'code' => 201,
            'message' => 'Публикация добавлена в ящик',
        ], 201);
    }

    public function addCategory(Request $request, $id): JsonResponse
    {
        Publishs::find($id)->categories()->attach($request->get('category_id'));

        return response()->json([
            'success' => true,
            'code' => 201,
            'message' => 'Категория успешно добавлена в категорию',
        ], 201);
    }

    public function updateById(Request $request, $id): JsonResponse
    {
        $publishs = Publishs::find($id);
        $publishs->update([
            'title' => $request->input('title', $publishs->title),
            'desc' => $request->input('desc', $publishs->desc),
            'image' => $request->input('image', $publishs->image),
        ]);
        if(isset($request->box_id)) {
            $publishs->boxes()->update(['box_id' => $request->input('box_id')]);
        }
        if(isset($request->category_id)) {
            $publishs->categories()->update(['category_id' => $request->input('category_id')]);
        }
        $publishs->save();
        return response()->json([
            'success' => true,
            'code' => 201,
            'message' => 'Публикация успешно изменена',
        ], 201);
    }
    public function deleteById(Request $request, $id): JsonResponse
    {
        Publishs::find($id)->delete();
        return response()->json([
            'success' => true,
            'code' => 201,
            'message' => 'Публикация успешно удалена',
        ], 201);
    }
    public function deleteInBox(Request $request, $box_id, $id): JsonResponse
    {
        Publishs::find($id)->boxes()->detach($box_id);
        return response()->json([
            'success' => true,
            'code' => 201,
            'message' => 'Публикация успешно удалена из ящика',
        ], 201);
    }
    public function deleteCategory(Request $request, $category_id, $id): JsonResponse
    {
        Publishs::find($id)->categories()->detach($category_id);
        return response()->json([
            'success' => true,
            'code' => 201,
            'message' => 'Категория успешна удалена из публикации',
        ], 201);
    }
}
