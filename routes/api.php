<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StreamCommentController; // <-- this one only

// Public auth
Route::post('/register', [AuthController::class,'register']);
Route::post('/login',    [AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class,'logout']);

    // Live comments (single way)
    Route::get('/stream/comments',  [StreamCommentController::class,'index']); // can be public if you want
    Route::post('/stream/comments', [StreamCommentController::class,'store']); // requires Bearer token
});

// Health
Route::get('/ping', fn() => response()->json(['message' => 'pong']));
