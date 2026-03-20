<?php

namespace Database\Seeders;

use App\Models\Vote;
use App\Models\Thread;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;

class VoteSeeder extends Seeder
{
    public function run(): void
    {
        $threads = Thread::all();
        $comments = Comment::all();
        $users = User::all();
        
        // Add votes to threads
        foreach ($threads as $thread) {
            $voteCount = rand(5, 15);
            $randomUsers = $users->random(min($voteCount, $users->count()))->pluck('id')->toArray();
            
            foreach (array_slice($randomUsers, 0, $voteCount) as $userId) {
                try {
                    Vote::create([
                        'user_id' => $userId,
                        'voteable_type' => 'thread',
                        'voteable_id' => $thread->id,
                        'type' => rand(0, 1) ? 'up' : 'down',
                    ]);
                } catch (\Exception $e) {
                    // Ignore duplicate vote constraint violations
                }
            }
        }
        
        // Add votes to comments
        foreach ($comments as $comment) {
            $voteCount = rand(2, 10);
            $randomUsers = $users->random(min($voteCount, $users->count()))->pluck('id')->toArray();
            
            foreach (array_slice($randomUsers, 0, $voteCount) as $userId) {
                try {
                    Vote::create([
                        'user_id' => $userId,
                        'voteable_type' => 'comment',
                        'voteable_id' => $comment->id,
                        'type' => rand(0, 1) ? 'up' : 'down',
                    ]);
                } catch (\Exception $e) {
                    // Ignore duplicate vote constraint violations
                }
            }
        }
    }
}
