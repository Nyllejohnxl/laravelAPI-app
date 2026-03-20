<?php

namespace Database\Seeders;

use App\Models\Thread;
use App\Models\Protocol;
use App\Models\User;
use Illuminate\Database\Seeder;

class ThreadSeeder extends Seeder
{
    public function run(): void
    {
        $protocols = Protocol::all();
        $users = User::all();
        
        $threadTitles = [
            'Questions about dosage specifications',
            'Implementation challenges in practice',
            'Latest updates and modifications',
            'Safety concerns and adverse events',
            'Cost-benefit analysis discussion',
            'Real-world application examples',
            'Compliance and regulatory requirements',
            'Alternative approaches and innovations',
            'Training requirements discussion',
            'Results and outcomes review',
        ];

        $threadContents = [
            'I have some concerns about the current implementation. Can we discuss the specific dosage recommendations?',
            'We\'ve been implementing this at our facility and have encountered some challenges. Would like to share our experience.',
            'There have been some recent updates to the protocol. Has anyone reviewed them yet?',
            'I\'ve noticed some potential safety issues. Should we discuss these with the committee?',
            'The cost of implementing this protocol is significant. Is the investment justified?',
            'Here\'s a real-world example from our practice. It might be helpful for others.',
            'We need to ensure we\'re meeting all compliance requirements. What are the current standards?',
            'Has anyone tried alternative approaches? I\'m looking for options.',
            'What training is required for staff members?',
            'Let\'s review the outcomes we\'ve achieved so far.',
        ];

        foreach (range(1, 10) as $i) {
            Thread::create([
                'protocol_id' => $protocols->random()->id,
                'user_id' => $users->random()->id,
                'title' => $threadTitles[$i - 1],
                'content' => $threadContents[$i - 1],
                'views' => rand(20, 300),
                'replies' => rand(2, 15),
            ]);
        }
    }
}
