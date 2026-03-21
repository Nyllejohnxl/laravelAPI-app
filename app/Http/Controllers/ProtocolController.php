<?php

namespace App\Http\Controllers;

use App\Models\Protocol;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProtocolController extends Controller
{
    /**
     * Get all protocols
     */
    public function index(): JsonResponse
    {
        $protocols = Protocol::with(['user', 'threads' => function ($query) {
            $query->with(['reviews' => function ($q) {
                $q->with('user')->orderBy('created_at', 'desc');
            }, 'comments' => function ($q) {
                $q->with(['user', 'votes' => function ($v) {
                    $v->with('user');
                }])->orderBy('created_at', 'desc');
            }])->orderBy('created_at', 'desc');
        }])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json($protocols);
    }

    /**
     * Get a single protocol with all related data
     */
    public function show($id): JsonResponse
    {
        $protocol = Protocol::with([
            'user',
            'threads' => function ($query) {
                $query->with([
                    'user',
                    'reviews' => function ($q) {
                        $q->with('user')->orderBy('created_at', 'desc');
                    },
                    'comments' => function ($q) {
                        $q->with(['user', 'votes' => function ($v) {
                            $v->with('user');
                        }])->orderBy('created_at', 'desc');
                    }
                ])->orderBy('created_at', 'desc');
            }
        ])->find($id);

        if (!$protocol) {
            return response()->json(['message' => 'Protocol not found'], 404);
        }

        // Increment views
        $protocol->increment('views');

        return response()->json($protocol);
    }

    /**
     * Get protocols by status
     */
    public function getByStatus($status): JsonResponse
    {
        $protocols = Protocol::where('status', $status)
            ->with(['user', 'threads', 'reviews'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json($protocols);
    }

    /**
     * Store a newly created protocol.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $protocol = Protocol::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => 'Active',
            'views' => 0,
        ]);

        return response()->json([
            'message' => 'Protocol created successfully',
            'data' => $protocol->load('user')
        ], 201);
    }
}
