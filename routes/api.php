<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController as ApiPostController;
use App\Http\Controllers\Api\CommentController as ApiCommentController;

Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class,'logout']);

    Route::get('/posts', [ApiPostController::class,'index']);
    Route::post('/posts', [ApiPostController::class,'store']);
    Route::get('/posts/{post}', [ApiPostController::class,'show']);
    Route::put('/posts/{post}', [ApiPostController::class,'update']);
    Route::delete('/posts/{post}', [ApiPostController::class,'destroy']);

    Route::post('/posts/{post}/comments', [ApiCommentController::class,'store']);
    Route::get('/posts/{post}/comments', [ApiCommentController::class,'index']);
});
