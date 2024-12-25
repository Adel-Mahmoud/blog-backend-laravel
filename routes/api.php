<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CommentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// Route::middleware('auth:api')->get('/posts', [PostController::class, 'index']);
Route::apiResource('categories', CategoryController::class)->only(['index', 'show']);
Route::apiResource('posts', PostController::class)->only(['index', 'show']);
Route::get('postsByCategory/{id}', [PostController::class, 'getBlogByCategory']);
Route::post('/comments', [CommentController::class, 'store']);
Route::get('comments', [CommentController::class, 'index']);
Route::get('postid/{id}', [CommentController::class, 'getCommentsByPost']);
Route::middleware('auth:api')->group(function () {
    Route::apiResource('categories', CategoryController::class)->except(['index', 'show']);
    Route::apiResource('posts', PostController::class)->except(['index', 'show']);
    Route::apiResource('users', UserController::class);
    // Route::apiResource('comments', CommentController::class);
    // // Categories Routes
    // Route::get('categories', [CategoryController::class, 'index']);
    // Route::get('categories/{id}', [CategoryController::class, 'show']);
    // Route::post('categories', [CategoryController::class, 'store']);
    // Route::put('categories/{id}', [CategoryController::class, 'update']);
    // Route::delete('categories/{id}', [CategoryController::class, 'destroy']);
    // // Posts Routes
    // Route::get('posts', [PostController::class, 'index']);
    // Route::get('post/{id}', [PostController::class, 'show']);
    // Route::post('posts', [PostController::class, 'store']);
    // Route::put('posts/{id}', [PostController::class, 'update']);
    // Route::delete('posts/{id}', [PostController::class, 'destroy']);
    // // Users Routes
    // Route::get('users', [UserController::class, 'index']);
    // Route::get('user/{id}', [UserController::class, 'show']);
    // Route::post('users', [UserController::class, 'store']);
    // Route::put('users/{id}', [UserController::class, 'update']);
    // Route::delete('users/{id}', [UserController::class, 'destroy']);
});
Route::prefix('auth')->middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});

// Route::get('/', [PostController::class, 'index']);
// Route::post('login', [AuthController::class, 'login']);
// Route::post('register', [AuthController::class, 'register']);
// Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
// Route::middleware('auth:api')->get('/protected-data', [PostController::class, 'show']);
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
