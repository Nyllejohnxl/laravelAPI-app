<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Thread;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request, $threadId): JsonResponse
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $thread = Thread::find($threadId);

        if (!$thread) {
            return response()->json(['message' => 'Thread not found'], 404);
        }

        $review = Review::create([
            'thread_id' => $threadId,
            'user_id' => auth()->id(),
            'content' => $validated['content'],
            'rating' => $validated['rating'],
        ]);

        return response()->json([
            'message' => 'Review created successfully',
            'data' => $review->load(['user'])
        ], 201);
    }
}
