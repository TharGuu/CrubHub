<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StreamComment;
use Illuminate\Http\Request;

class StreamCommentController extends Controller
{
    // GET /api/stream/comments?after=2025-08-13T05:00:00Z  (optional)
    public function index(Request $request)
    {
        $query = StreamComment::with('user:id,name')->latest();

        if ($after = $request->query('after')) {
            $query->where('created_at', '>', $after);
        }

        return response()->json($query->take(50)->get());
    }

    // POST /api/stream/comments    { "body": "hello" }
    public function store(Request $request)
    {
        $data = $request->validate([
            'body' => ['required','string','max:5000'],
        ]);

        $comment = StreamComment::create([
            'body'    => $data['body'],
            'user_id' => $request->user()->id,
        ])->load('user:id,name');

        return response()->json($comment, 201);
    }
}
