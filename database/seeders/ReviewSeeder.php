<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $threads = Thread::all();
        $users = User::all();
        
        $reviewTexts = [
            'Excellent protocol with clear guidelines. Very useful for our practice.',
            'Well-structured and comprehensive. Highly recommended.',
            'Good foundation but could use more practical examples.',
            'Effective and easy to follow. Great resource.',
            'Very thorough analysis of the procedures.',
            'Practical and applicable to real-world scenarios.',
            'Comprehensive coverage of all important aspects.',
            'Could benefit from more recent research updates.',
            'Solid protocol that\'s worked well for our team.',
            'Excellent documentation and clear implementation steps.',
            'Very thorough and well-organized.',
            'Practical guidance that\'s easy to implement.',
        ];

        foreach ($threads as $thread) {
            // Create 2-4 reviews per thread
            $reviewCount = rand(2, 4);
            for ($i = 0; $i < $reviewCount; $i++) {
                Review::create([
                    'thread_id' => $thread->id,
                    'user_id' => $users->random()->id,
                    'content' => $reviewTexts[array_rand($reviewTexts)],
                    'rating' => rand(3, 5),
                ]);
            }
        }
    }
}
