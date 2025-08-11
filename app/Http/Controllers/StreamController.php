<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StreamComment;   // ← add this

class StreamController extends Controller
{
    public function index()
    {
        $comments = StreamComment::with('user')->latest()->paginate(30);
        return view('dashboard', compact('comments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'body' => ['required','string','max:2000'],
        ]);

        $request->user()->streamComments()->create($validated);

        return back();
    }
}
