<?php

namespace App\Http\Controllers\comments;

use App\Http\Controllers\Controller;
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

        $Comments->update([
            'text' => $request->input('text', $Comments->text),
        ]);
        $Comments->save();
        return response()->json($Comments);
    }

    public function deleteById(Request $request, $id): JsonResponse
    {
        $Comments = Comments::find($id);
        $Comments->delete();
        return response()->json($Comments);
    }
}
