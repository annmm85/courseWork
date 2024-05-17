<?php

namespace App\Http\Controllers\comments;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCommentsApiRequest;
use App\Models\Answercomments;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnswercommentsApiController extends Controller
{
    public function create(CreateCommentsApiRequest $request, $id): JsonResponse
    {
        $data = $request->all();

        Answercomments::create([
            'text' => $data['text'],
            'user_id' => $request->user()->id,
            'comment_id' => $id,
        ]);

        return response()->json([
            'success' => true,
            'code' => 201,
            'message' => 'Success',
        ], 201);
    }

    public function read(Request $request, $id): JsonResponse
    {
        $Answercomments = Answercomments::where('comment_id', $id)->get();
        return response()->json($Answercomments);
    }

    public function updateById(Request $request, $id): JsonResponse
    {
        $Answercomments = Answercomments::find($id);

        $Answercomments->update([
            'text' => $request->input('text', $Answercomments->text),
        ]);
        $Answercomments->save();
        return response()->json($Answercomments);
    }

    public function deleteById(Request $request, $id): JsonResponse
    {
        $Answercomments = Answercomments::find($id);
        $Answercomments->delete();
        return response()->json($Answercomments);
    }
}
