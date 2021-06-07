<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TopicController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('topics',  [TopicController::class, 'getAllTopics']);
Route::get('topics/{id}',  [TopicController::class, 'getTopic']);
Route::get('/topics/search/{name}', [TopicController::class, 'search']);

//Protected routes-Only authenticated users can have access to protected routes//
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('topics',  [TopicController::class, 'createTopic']);
    Route::put('topics/{id}',  [TopicController::class, 'updateTopic']);
    Route::delete('topics/{id}', [TopicController::class, 'deleteTopic']);
    Route::post('/logout',[AuthController::class,'logout']);
});
