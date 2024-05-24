<?php

use App\Http\Controllers\auth\UserAuthenticationApiController;
use App\Http\Controllers\auth\UserLoginApiController;
use App\Http\Controllers\boxes\BoxesApiController;
use App\Http\Controllers\categories\CategoriesApiController;
use App\Http\Controllers\comments\AnswercommentsApiController;
use App\Http\Controllers\comments\CommentsApiController;
use App\Http\Controllers\notifies\NotifiesApiController;
use App\Http\Controllers\notifies\UsernotifiesApiController;
use App\Http\Controllers\publishs\PublishsApiController;
use App\Http\Controllers\Publishsboxes\PublishsboxesApiController;
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

Route::get('/publishs',[PublishsApiController::class, 'read'])->middleware('auth:sanctum');
Route::post('/publishs/create',[PublishsApiController::class, 'create'])->middleware('auth:sanctum');
Route::delete('/publishs/{id}',[PublishsApiController::class, 'deleteById'])->middleware('auth:sanctum');
Route::patch('/publishs/{id}',[PublishsApiController::class, 'updateById'])->middleware('auth:sanctum');

Route::get('/users/{id}/publishs',[PublishsApiController::class, 'userRead'])->middleware('auth:sanctum');
Route::get('/categories/{id}/publishs',[PublishsApiController::class, 'categoryRead'])->middleware('auth:sanctum');


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

Route::post('/comments/{id}/answercomments/create',[AnswercommentsApiController::class, 'create'])->middleware('auth:sanctum');
Route::get('/comments/{id}/answercomments',[AnswercommentsApiController::class, 'read'])->middleware('auth:sanctum');
Route::patch('/answercomments/{id}',[AnswercommentsApiController::class, 'updateById'])->middleware('auth:sanctum');
Route::delete('/answercomments/{id}',[AnswercommentsApiController::class, 'deleteById'])->middleware('auth:sanctum');

Route::post('/boxes/create',[BoxesApiController::class, 'create'])->middleware('auth:sanctum');
Route::get('/boxes',[BoxesApiController::class, 'read'])->middleware('auth:sanctum');
Route::patch('/boxes/{id}',[BoxesApiController::class, 'updateById'])->middleware('auth:sanctum');
Route::delete('/boxes/{id}',[BoxesApiController::class, 'deleteById'])->middleware('auth:sanctum');

Route::post('/publishs/{id}/boxes/create',[PublishsboxesApiController::class, 'create'])->middleware('auth:sanctum');
Route::get('/boxes/{id}/publishs',[PublishsboxesApiController::class, 'readPublishsInBox'])->middleware('auth:sanctum');
Route::patch('/publishs/{id}/boxes/update',[PublishsboxesApiController::class, 'updateByIdPublish'])->middleware('auth:sanctum');
Route::delete('boxes/{box_id}/publishs/{id}',[PublishsboxesApiController::class, 'deleteById'])->middleware('auth:sanctum');

Route::post('/notifies/create',[NotifiesApiController::class, 'create'])->middleware('auth:sanctum');
Route::get('/notifies',[NotifiesApiController::class, 'read'])->middleware('auth:sanctum');
Route::patch('/notifies/{id}/update',[NotifiesApiController::class, 'updateById'])->middleware('auth:sanctum');
Route::delete('/notifies/{id}',[NotifiesApiController::class, 'deleteById'])->middleware('auth:sanctum');


Route::post('/notifies/{id}/users/create',[UsernotifiesApiController::class, 'createByIdNotify'])->middleware('auth:sanctum');
Route::get('/usersnotifies',[UsernotifiesApiController::class, 'readUserNotifies'])->middleware('auth:sanctum');
Route::patch('/notifies/{id}/user/{user_id}/update',[UsernotifiesApiController::class, 'updateByIdUsernotifies'])->middleware('auth:sanctum');
Route::delete('/notifies/{id}/user/{user_id}',[UsernotifiesApiController::class, 'deleteById'])->middleware('auth:sanctum');



