<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    /**
     * Store a vote (upvote or downvote).
     */
    public function store(Request $request, $commentId): JsonResponse
    {
        $validated = $request->validate([
            'type' => 'required|in:upvote,downvote',
        ]);

        $comment = Comment::find($commentId);

        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        // Check if user already voted on this comment
        $existingVote = Vote::where('comment_id', $commentId)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingVote) {
            // If voting same type, remove the vote
            if ($existingVote->type === $validated['type']) {
                $existingVote->delete();
                return response()->json([
                    'message' => 'Vote removed successfully',
                    'data' => null
                ]);
            }

            // Otherwise, update the vote
            $existingVote->update(['type' => $validated['type']]);
            return response()->json([
                'message' => 'Vote updated successfully',
                'data' => $existingVote->load('user')
            ]);
        }

        // Create new vote
        $vote = Vote::create([
            'comment_id' => $commentId,
            'user_id' => auth()->id(),
            'type' => $validated['type'],
        ]);

        return response()->json([
            'message' => 'Vote created successfully',
            'data' => $vote->load('user')
        ], 201);
    }

    /**
     * Delete a vote.
     */
    public function destroy($voteId): JsonResponse
    {
        $vote = Vote::find($voteId);

        if (!$vote) {
            return response()->json(['message' => 'Vote not found'], 404);
        }

        // Check if user is vote owner
        if ($vote->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $vote->delete();

        return response()->json(['message' => 'Vote deleted successfully']);
    }
}
