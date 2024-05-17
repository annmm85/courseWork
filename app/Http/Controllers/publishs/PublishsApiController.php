<?php

namespace App\Http\Controllers\publishs;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePublishsApiRequest;
use App\Models\Publishs;
use App\Models\Publishsboxes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublishsApiController extends Controller
{
    public function read(): JsonResponse
    {
        $publishs = Publishs::all();

        return response()->json($publishs);
    }
    public function userRead(Request $request, $id): JsonResponse
    {
        $publishs = Publishs::where('user_id', $id)->get();
        return response()->json($publishs);
    }
    public function categoryRead(Request $request, $id): JsonResponse
    {
        $publishs = Publishs::where('category_id', $id)->get();
        return response()->json($publishs);
    }
    public function boxesRead(Request $request, $id): JsonResponse
    {
        $publishs = Publishsboxes::where('category_id', $id)->get();
        return response()->json($publishs);
    }

    public function create(CreatePublishsApiRequest $request): JsonResponse
    {
        $data = $request->all();

        Publishs::create([
            'title' => $data['title'],
            'desc' => $data['desc'],
            'category_id' => $data['category_id'],
            'image' => $data['image'],
            'user_id' => $data['user_id'],
        ]);
        return response()->json([
            'success' => true,
            'code' => 201,
            'message' => 'Success',
        ], 201);
    }

    public function updateById(Request $request, $id): JsonResponse
    {
        $publishs = Publishs::find($id);

        $publishs->update([
            'title' => $request->input('title', $publishs->title),
            'desc' => $request->input('desc', $publishs->desc),
            'category_id' => $request->input('category_id', $publishs->category_id),
            'image' => $request->input('image', $publishs->image),
        ]);
        $publishs->save();
        return response()->json($publishs);
    }

    public function deleteById(Request $request, $id): JsonResponse
    {

        $publishs = Publishs::find($id);
        $publishs->delete();
        return response()->json($publishs);
    }
}
