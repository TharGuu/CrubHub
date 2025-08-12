<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Post $post)
    {
        return $post->comments()->with('user:id,name')->latest()->paginate(30);
    }

    public function store(Request $request, Post $post)
    {
        $data = $request->validate([
            'body' => ['required','string','max:5000']
        ]);

        $comment = $post->comments()->create([
            'body' => $data['body'],
            'user_id' => $request->user()->id,
        ]);

        return response()->json($comment->load('user:id,name'), 201);
    }
}