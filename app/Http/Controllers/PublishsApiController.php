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
        if (Categories::find($id)) {
            return response()->json(Categories::find($id)->publishs()->get());
        } else {
            return response()->json(['message' => 'Категория не найдена'], 404);
        }
    }

    public function categoriesByOnePublishRead(Request $request, $id): JsonResponse
    {
        if (Publishs::find($id)) {
            return response()->json(Publishs::find($id)->categories()->get());
        } else {
            return response()->json(['message' => 'Публикация не найдена'], 404);
        }
    }

    public function boxesRead(Request $request, $id): JsonResponse
    {
        if (Boxes::find($id)) {
            return response()->json(Boxes::find($id)->publishs()->get());
        } else {
            return response()->json(['message' => 'Ящик не найден'], 404);
        }
    }

    public function boxesByOnePublishRead(Request $request, $id): JsonResponse
    {
        if (Publishs::find($id)) {
            return response()->json(Publishs::find($id)->boxes()->get());
        } else {
            return response()->json(['message' => 'Публикация не найдена'], 404);
        }
    }

    public function userRead(Request $request, $id): JsonResponse
    {
        if (User::find($id)) {
            return response()->json(User::find($id)->publishs()->get());
        } else {
            return response()->json(['message' => 'Пользователь не найден'], 404);
        }
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

        if (isset($data['category_id'])) {
            if (Categories::find($data['category_id'])) {
                $publication->categories()->attach($data['category_id']);
                return response()->json(['message' => 'Публикация успешно создана'], 201);
            } else {
                return response()->json(['error' => 'Категория не найдена'], 422);
            }
        } else {
            return response()->json(['error' => 'Заполните поле категории'], 422);
        }
    }

    public function saveInBox(Request $request, $id): JsonResponse
    {
        if (Publishs::find($id)) {
            $boxes = Publishs::find($id)->boxes()->pluck('id')->toArray();
            if (!in_array($request->get('box_id'), $boxes)) {
                if (Boxes::find($request->get('box_id'))) {
                    Publishs::find($id)->boxes()->attach($request->get('box_id'));
                    return response()->json([
                        'success' => true,
                        'code' => 201,
                        'message' => 'Публикация добавлена в ящик',
                    ], 201);
                } else {
                    return response()->json(['error' => 'Ящик не найден'], 404);
                }
            } else {
                return response()->json(['error' => 'Публикация уже есть в ящике'], 404);
            }
        } else {
            return response()->json(['error' => 'Публикация не найдена'], 404);
        }
    }

    public function addCategory(Request $request, $id): JsonResponse
    {
        if (Publishs::find($id)) {
            $categories = Publishs::find($id)->categories()->pluck('id')->toArray();
            if (!in_array($request->get('category_id'), $categories)) {
                if (Categories::find($request->get('category_id'))) {
                    Publishs::find($id)->categories()->attach($request->get('category_id'));
                    return response()->json(['Категория успешно добавлена в категорию'], 201);
                } else {
                    return response()->json(['Категория не найдена'], 404);
                }
            } else {
                return response()->json(['Публикация уже прикреплена к категории'], 404);
            }
        } else {
            return response()->json(['Публикация не найдена'], 404);
        }
    }

    public function updateById(Request $request, $id): JsonResponse
    {
        $publishs = Publishs::find($id);

        $image = $request->file('image');
        $pathToImage = $image->store('images', 'public');

        if ($publishs) {
            $publishs->update([
                'title' => $request->input('title', $publishs->title),
                'desc' => $request->input('desc', $publishs->desc),
                'image' => $request->input($pathToImage, $publishs->image),
            ]);
            if (isset($request->box_id)) {
                $boxes = $publishs->boxes()->pluck('id')->toArray();
                if (!in_array($request->box_id, $boxes)) {
                    if (Boxes::find($request->box_id)) {
                        $publishs->boxes()->update(['box_id' => $request->input('box_id')]);
                    } else {
                        return response()->json(['Ящик не найден'], 404);
                    }
                } else {
                    return response()->json(['Публикация уже есть в ящике'], 404);
                }
            }
            if (isset($request->category_id)) {
                $categories = $publishs->categories()->pluck('id')->toArray();
                if (!in_array($request->get('category_id'), $categories)) {
                    if (Categories::find($request->category_id)) {
                        $publishs->categories()->update(['category_id' => $request->input('category_id')]);
                    } else {
                        return response()->json(['Категория не найдена'], 404);
                    }
                } else {
                    return response()->json(['Публикация уже прикреплена к категории'], 404);
                }
            }
            $publishs->save();
            return response()->json(['message' => 'Публикация успешно изменена'], 201);
        } else {
            return response()->json(['Публикация не найдена'], 404);
        }
    }

    public function deleteById(Request $request, $id): JsonResponse
    {   $publish = Publishs::find($id);
        if ($publish) {
            $publish->categories()->detach();
            $publish->delete();
            return response()->json(['message' => 'Публикация успешно удалена'], 201);
        } else {
            return response()->json(['Публикация не найдена'], 404);
        }
    }

    public function deleteInBox(Request $request, $box_id, $id): JsonResponse
    {
        if (Boxes::find($box_id)) {
            if (Publishs::find($id)) {
                $idPublishsInBox = Boxes::find($box_id)->publishs()->pluck('id')->toArray();
                if (in_array($id, $idPublishsInBox)) {
                    Publishs::find($id)->boxes()->detach($box_id);
                    return response()->json(['message' => 'Публикация успешно удалена из ящика'], 201);
                } else {
                    return response()->json(['В ящике не найдена публикация'], 404);
                }
            } else {
                return response()->json(['Публикация не найдена'], 404);
            }
        } else {
            return response()->json(['Ящик не найден'], 404);
        }
    }

    public function deleteCategory(Request $request, $category_id, $id): JsonResponse
    {
        if (Categories::find($category_id)) {
            if (Publishs::find($id)) {
                $idPublishsWithCategories = Categories::find($category_id)->publishs()->pluck('id')->toArray();
                if (in_array($id, $idPublishsWithCategories)) {
                    Publishs::find($id)->categories()->detach($category_id);
                    return response()->json(['message' => 'Категория успешна удалена из публикации'], 201);
                } else {
                    return response()->json(['У публикации нет такой категории'], 404);
                }
            } else {
                return response()->json(['Публикация не найдена'], 404);
            }
        } else {
            return response()->json(['Категория не найдена'], 404);
        }
    }
}
