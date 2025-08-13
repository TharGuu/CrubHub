<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController as ApiPostController;
use App\Http\Controllers\Api\CommentController as ApiCommentController;
use App\Http\Controllers\Api\StreamCommentController; // <-- make sure this exists

// Public routes
Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class,'logout']);

    // Stream comments
    Route::get('/stream/comments',  [StreamCommentController::class,'index']);
    Route::post('/stream/comments', [StreamCommentController::class,'store']);

    // Posts
    Route::get('/posts', [ApiPostController::class,'index']);
    Route::post('/posts', [ApiPostController::class,'store']);
    Route::get('/posts/{post}', [ApiPostController::class,'show']);
    Route::put('/posts/{post}', [ApiPostController::class,'update']);
    Route::delete('/posts/{post}', [ApiPostController::class,'destroy']);

    // Comments on posts
    Route::post('/posts/{post}/comments', [ApiCommentController::class,'store']);
    Route::get('/posts/{post}/comments', [ApiCommentController::class,'index']);
});

// Simple test endpoint
Route::get('/ping', fn() => response()->json(['message' => 'pong']));
