<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user','comments.user'])->latest()->get();
        return view('dashboard', compact('posts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'body'  => ['nullable','string'],
        ]);
        $request->user()->posts()->create($data);
        return back()->with('status','Post created.');
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'body'  => ['nullable','string'],
        ]);
        $post->update($data);
        return redirect()->route('dashboard')->with('status','Post updated.');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return back()->with('status','Post deleted.');
    }
}