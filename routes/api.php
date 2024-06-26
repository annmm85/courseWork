<?php

use App\Http\Controllers\auth\UserAuthenticationApiController;
use App\Http\Controllers\auth\UserLoginApiController;
use App\Http\Controllers\BoxesApiController;
use App\Http\Controllers\CategoriesApiController;
use App\Http\Controllers\CommentsApiController;
use App\Http\Controllers\InterestCategoriesApiController;
use App\Http\Controllers\NotifiesApiController;
use App\Http\Controllers\PublishsApiController;
use App\Http\Controllers\UserApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Здесь вы можете зарегистрировать маршруты API для своего приложения. Эти
| маршруты загружаются RouteServiceProvider, и все они будут
| отнесены к группе промежуточного программного обеспечения "api". Сделайте что-нибудь замечательное!|
*/

Route::post('/registration',[UserAuthenticationApiController::class, 'register']);
Route::post('/login',[UserLoginApiController::class, 'login']);
Route::get('/logout',[UserAuthenticationApiController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/users/roles/{id}',[UserApiController::class, 'readUsersByRole'])->middleware(['auth:sanctum','admin']);
Route::patch('/users/{id}/update-role',[UserApiController::class, 'updateRoleById'])->middleware(['auth:sanctum','admin']);

Route::get('/main',[InterestCategoriesApiController::class, 'mainRead'])->middleware('auth:sanctum');

Route::get('/category-interest',[InterestCategoriesApiController::class, 'readInterestCategory'])->middleware('auth:sanctum');
Route::post('/category-interest/add',[InterestCategoriesApiController::class, 'addCategoryInterest'])->middleware('auth:sanctum');
Route::delete('/category-interest/{id}',[InterestCategoriesApiController::class, 'deleteByIdCategoryInterest'])->middleware('auth:sanctum');

Route::get('/publishs',[PublishsApiController::class, 'read']);
Route::post('/publishs/create',[PublishsApiController::class, 'create'])->middleware('auth:sanctum');
Route::patch('/publishs/{id}',[PublishsApiController::class, 'updateById'])->middleware('auth:sanctum');
Route::delete('/publishs/{id}',[PublishsApiController::class, 'deleteById'])->middleware('auth:sanctum');

Route::match(['post', 'get'], '/publishs/search', [PublishsApiController::class, 'searchQueryRead'])->middleware('auth:sanctum');
Route::get('/publishs/{id}/download',[PublishsApiController::class, 'downloadImage'])->middleware('auth:sanctum');

Route::get('/boxes/{id}/publishs',[PublishsApiController::class, 'boxesRead'])->middleware('auth:sanctum');
Route::get('/publishs/{id}/boxes',[PublishsApiController::class, 'boxesByOnePublishRead'])->middleware('auth:sanctum');
Route::post('/publishs/{id}/save-in-box',[PublishsApiController::class, 'saveInBox'])->middleware('auth:sanctum');
Route::post('/publishs/{id}/save-in-loves',[PublishsApiController::class, 'saveInLoves'])->middleware('auth:sanctum');
Route::delete('boxes/{box_id}/publishs/{id}',[PublishsApiController::class, 'deleteInBox'])->middleware('auth:sanctum');

Route::get('/categories/{id}/publishs',[PublishsApiController::class, 'categoryRead'])->middleware('auth:sanctum');
Route::get('/publishs/{id}/categories',[PublishsApiController::class, 'categoriesByOnePublishRead'])->middleware('auth:sanctum');
Route::post('/publishs/{id}',[PublishsApiController::class, 'addCategory'])->middleware('auth:sanctum');
Route::delete('categories/{сategory_id}/publishs/{id}',[PublishsApiController::class, 'deleteCategory'])->middleware('auth:sanctum');

Route::get('/users/{id}/publishs',[PublishsApiController::class, 'userRead'])->middleware('auth:sanctum');
Route::get('/authors/publishs',[PublishsApiController::class, 'authorsRead'])->middleware('auth:sanctum');

Route::post('/publishs/subcribe',[PublishsApiController::class, 'subscribeOnAuthor'])->middleware('auth:sanctum');
Route::get('/{author_id}/publishs',[PublishsApiController::class, 'userRead'])->middleware('auth:sanctum');

Route::get('/categories',[CategoriesApiController::class, 'read'])->middleware('auth:sanctum');
Route::post('/categories/create',[CategoriesApiController::class, 'create'])->middleware('auth:sanctum');
Route::delete('/categories/{id}',[CategoriesApiController::class, 'deleteById'])->middleware('auth:sanctum');
Route::patch('/categories/{id}',[CategoriesApiController::class, 'updateById'])->middleware('auth:sanctum');

Route::post('/publishs/{id}/comments/create',[CommentsApiController::class, 'create'])->middleware('auth:sanctum');
Route::get('/publishs/{id}/comments',[CommentsApiController::class, 'read'])->middleware('auth:sanctum');
Route::patch('/comments/{id}',[CommentsApiController::class, 'updateById'])->middleware('auth:sanctum');
Route::delete('/comments/{id}',[CommentsApiController::class, 'deleteById'])->middleware('auth:sanctum');

Route::post('/boxes/create',[BoxesApiController::class, 'create'])->middleware('auth:sanctum');
Route::get('/boxes',[BoxesApiController::class, 'read'])->middleware('auth:sanctum');
Route::get('user/boxes',[BoxesApiController::class, 'readByUser'])->middleware('auth:sanctum');
Route::patch('/boxes/{id}',[BoxesApiController::class, 'updateById'])->middleware('auth:sanctum');
Route::delete('/boxes/{id}',[BoxesApiController::class, 'deleteById'])->middleware('auth:sanctum');


Route::post('/notifies/create',[NotifiesApiController::class, 'create'])->middleware('auth:sanctum');
Route::post('/notifies/{id}',[NotifiesApiController::class, 'bindUser'])->middleware('auth:sanctum');
Route::get('/notifies',[NotifiesApiController::class, 'read'])->middleware('auth:sanctum');
Route::get('/users/{id}/notifies',[NotifiesApiController::class, 'readNotifiesByUser'])->middleware('auth:sanctum');
Route::get('/notifies/{id}/users',[NotifiesApiController::class, 'readUserByNotifies'])->middleware('auth:sanctum');
Route::patch('/notifies/{id}/update',[NotifiesApiController::class, 'updateById'])->middleware('auth:sanctum');
Route::delete('/notifies/{id}',[NotifiesApiController::class, 'deleteById'])->middleware('auth:sanctum');
Route::delete('notifies/{id}/user/{user_id}',[NotifiesApiController::class, 'deleteUserByNotifies'])->middleware('auth:sanctum');


Route::post('/subscribe/authors/{id}',[UserApiController::class, 'subscribe'])->middleware('auth:sanctum');
Route::get('/subscribes/authors',[UserApiController::class, 'readAuthors'])->middleware('auth:sanctum');
Route::get('/subscribes/subscribers',[UserApiController::class, 'readSubscribers'])->middleware('auth:sanctum');
Route::delete('/unsubscribes/authors/{id}',[UserApiController::class, 'unsubscribe'])->middleware('auth:sanctum');
