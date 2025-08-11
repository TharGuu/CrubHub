<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return Post::with(['user:id,name','comments'=>fn($q)=>$q->with('user:id,name')])
            ->latest()->paginate(15);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'body'  => ['nullable','string'],
        ]);
        $post = $request->user()->posts()->create($data);
        return response()->json($post->load('user:id,name'), 201);
    }

    public function show(Post $post)
    {
        return $post->load(['user:id,name','comments.user:id,name']);
    }

    public function update(Request $request, Post $post)
    {
        abort_unless($post->user_id === $request->user()->id, 403);

        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'body'  => ['nullable','string'],
        ]);
        $post->update($data);
        return $post->refresh()->load('user:id,name');
    }

    public function destroy(Request $request, Post $post)
    {
        abort_unless($post->user_id === $request->user()->id, 403);
        $post->delete();
        return response()->json(['message'=>'Deleted']);
    }
}
