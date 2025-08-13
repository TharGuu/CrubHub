<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // GET /api/posts/{post}/comments  (public or auth—your choice)
    public function index(Post $post)
    {
        // include author name to show in mobile app
        return response()->json(
            $post->comments()->with('user:id,name')->latest()->get()
        );
    }

    // POST /api/posts/{post}/comments  (auth required)
    public function store(Request $request, Post $post)
    {
        $data = $request->validate([
            'body' => ['required','string','max:5000'],
        ]);

        $comment = $post->comments()->create([
            'body'    => $data['body'],
            'user_id' => $request->user()->id,
        ]);

        // return JSON instead of redirect
        return response()->json($comment->load('user:id,name'), 201);
    }
}
