<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\JsonResponse;

class ThreadController extends Controller
{
    /**
     * Get all threads
     */
    public function index(): JsonResponse
    {
        $threads = Thread::with(['user', 'protocol', 'comments'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json($threads);
    }

    /**
     * Get a single thread with all related data
     */
    public function show($id): JsonResponse
    {
        $thread = Thread::with([
            'user',
            'protocol',
            'comments' => function ($query) {
                $query->with('user')->orderBy('created_at', 'desc');
            }
        ])->find($id);

        if (!$thread) {
            return response()->json(['message' => 'Thread not found'], 404);
        }

        // Increment views
        $thread->increment('views');

        return response()->json($thread);
    }

    /**
     * Get threads by protocol
     */
    public function getByProtocol($protocolId): JsonResponse
    {
        $threads = Thread::where('protocol_id', $protocolId)
            ->with(['user', 'comments'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json($threads);
    }
}
