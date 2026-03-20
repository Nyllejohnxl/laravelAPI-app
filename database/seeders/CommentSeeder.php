<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $threads = Thread::all();
        $users = User::all();
        
        $comments = [
            'Great point! I totally agree with this approach.',
            'I\'ve had similar experiences. This is definitely important.',
            'Thanks for sharing this information. Very helpful!',
            'I think there\'s another perspective to consider here.',
            'This is exactly what we needed to discuss.',
            'Could you provide more details about this?',
            'Excellent observation. Well thought out.',
            'I disagree slightly. Here\'s my take on it...',
            'This has been very enlightening. Thanks everyone!',
            'Does anyone have resources to share on this topic?',
            'I\'ve implemented something similar with good results.',
            'This raises some interesting questions.',
            'Very relevant to our current situation.',
            'I appreciate everyone\'s input on this matter.',
            'This is something we should definitely consider.',
        ];

        foreach ($threads as $thread) {
            // Create 3-8 comments per thread
            $commentCount = rand(3, 8);
            for ($i = 0; $i < $commentCount; $i++) {
                Comment::create([
                    'thread_id' => $thread->id,
                    'user_id' => $users->random()->id,
                    'content' => $comments[array_rand($comments)],
                    'likes' => rand(0, 10),
                ]);
            }
        }
    }
}
