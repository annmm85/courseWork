<?php

namespace App\Http\Controllers\Publishsboxes;

use App\Http\Controllers\Controller;
use App\Models\Publishs;
use App\Models\Publishsboxes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublishsboxesApiController extends Controller
{
    public function create(Request $request, $id): JsonResponse
    {
        $data = $request->all();
        Publishsboxes::create([
            'publish_id' => $id,
            'box_id' => $data['box_id'],
        ]);
        return response()->json([
            'success' => true,
            'code' => 201,
            'message' => 'Публикация добавлена в ящик',
        ], 201);
    }

    public function readPublishsInBox(Request $request, $id): JsonResponse
    {
        $ff_publ_id = Publishsboxes::where('box_id', $id)->get('publish_id');
        $publishs = Publishs::where('id', $ff_publ_id[0]['publish_id'])->get();
        return response()->json($publishs);
    }
    public function updateByIdPublish(Request $request, $id): JsonResponse
    {
        $Publishsboxes = Publishsboxes::where('publish_id', $id)->get()[0];

        $Publishsboxes->update([
            'box_id' => $request->input('box_id', $Publishsboxes->box_id),
        ]);
        $Publishsboxes->save();
        return response()->json($Publishsboxes);
    }

    public function deleteById(Request $request, $box_id, $id): JsonResponse
    {
        $Publishsboxes = Publishsboxes::where(['publish_id'=>$id, 'box_id'=>$box_id])->get()[0];
        $Publishsboxes->delete();
        return response()->json($Publishsboxes);
    }
}
