<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Thread;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a newly created comment in storage.
     */
    public function store(Request $request, $threadId): JsonResponse
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $thread = Thread::find($threadId);

        if (!$thread) {
            return response()->json(['message' => 'Thread not found'], 404);
        }

        $comment = Comment::create([
            'thread_id' => $threadId,
            'user_id' => auth()->id(),
            'content' => $validated['content'],
            'likes' => 0,
        ]);

        return response()->json([
            'message' => 'Comment created successfully',
            'data' => $comment->load(['user', 'votes'])
        ], 201);
    }

    /**
     * Get all comments for a thread.
     */
    public function getByThread($threadId): JsonResponse
    {
        $comments = Comment::where('thread_id', $threadId)
            ->with(['user', 'votes' => function ($query) {
                $query->with('user');
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($comments);
    }
}
