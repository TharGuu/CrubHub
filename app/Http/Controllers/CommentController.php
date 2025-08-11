<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $data = $request->validate([
            'body' => ['required','string','max:5000']
        ]);

        $post->comments()->create([
            'body' => $data['body'],
            'user_id' => $request->user()->id,
        ]);

        return back()->with('status','Comment added.');
    }
}
