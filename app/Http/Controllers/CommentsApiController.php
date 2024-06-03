<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCommentsApiRequest;
use App\Models\Comments;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentsApiController extends Controller
{
    public function create(CreateCommentsApiRequest $request, $id): JsonResponse
    {
        $data = $request->all();
        Comments::create([
            'text' => $data['text'],
            'user_id' => $request->user()->id,
            'publish_id' => $id,
        ]);
        return response()->json([
            'success' => true,
            'code' => 201,
            'message' => 'Комментарий создан',
        ], 201);
    }

    public function read(Request $request, $id): JsonResponse
    {
        $Comments = Comments::where('publish_id', $id)->get();
        return response()->json($Comments);
    }

    public function updateById(Request $request, $id): JsonResponse
    {
        $Comments = Comments::find($id);
        if ($Comments) {
            if ($request->user()->id !== $Comments->user_id) {
                return response()->json(['error' => 'Вы не являетесь автором этого комментария'], 403);
            }
            $Comments->update([
                'text' => $request->input('text', $Comments->text),
            ]);
            $Comments->save();
            return response()->json($Comments);
        }else{
            return response()->json(['message' => 'Комментарий не найден'], 404);
        }
    }

    public function deleteById(Request $request, $id): JsonResponse
    {
        $Comments = Comments::find($id);
        if ($Comments) {
            $Comments->delete();
            return response()->json($Comments);
        }else{
            return response()->json(['message' => 'Комментарий не найден'], 404);
        }
    }
}
