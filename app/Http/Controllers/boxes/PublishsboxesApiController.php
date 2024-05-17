<?php

namespace App\Http\Controllers\Publishsboxes;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoriesApiRequest;
use App\Models\Publishsboxes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublishsboxesApiController extends Controller
{
    public function createByIdPublish(CreateCategoriesApiRequest $request, $id): JsonResponse
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

    public function read(Request $request, $id): JsonResponse
    {
        $Publishsboxes = Publishsboxes::all();
        return response()->json($Publishsboxes);
    }

    public function updateById(Request $request, $id): JsonResponse
    {
        $Publishsboxes = Publishsboxes::find($id);

        $Publishsboxes->update([
            'name' => $request->input('name', $Publishsboxes->name),
        ]);
        $Publishsboxes->save();
        return response()->json($Publishsboxes);
    }

    public function deleteById(Request $request, $id): JsonResponse
    {
        $Publishsboxes = Publishsboxes::find($id);
        $Publishsboxes->delete();
        return response()->json($Publishsboxes);
    }
}
