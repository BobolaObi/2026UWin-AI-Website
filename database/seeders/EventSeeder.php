<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        if (Event::query()->exists()) {
            return;
        }

        $timezone = config('app.timezone');

        $items = [
            [
                'title' => 'Mini Jarvis Workshop',
                'starts_at' => Carbon::parse('2026-01-16 17:00:00', $timezone),
                'ends_at' => Carbon::parse('2026-01-16 20:00:00', $timezone),
                'location' => 'Toledo Health Education CTR 102',
                'description' => 'Build your own voice-powered AI assistant with Python.',
                'is_published' => true,
                'sort_order' => 0,
            ],
            [
                'title' => 'ML Learning Workshop',
                'starts_at' => Carbon::parse('2026-03-19 11:30:00', $timezone),
                'ends_at' => Carbon::parse('2026-03-19 13:00:00', $timezone),
                'location' => 'Dillon Hall 255',
                'description' => 'Hands-on ML learning session (bring a laptop).',
                'is_published' => true,
                'sort_order' => 0,
            ],
            [
                'title' => 'AI and Autonomous Technologies on Future Societies',
                'starts_at' => Carbon::parse('2026-03-22 12:00:00', $timezone),
                'ends_at' => Carbon::parse('2026-03-22 13:00:00', $timezone),
                'location' => '300 Ouellette Avenue',
                'description' => 'Speaker: Nour Elkott. Talk and discussion.',
                'is_published' => true,
                'sort_order' => 0,
            ],
            [
                'title' => 'Introduction to Python Workshop',
                'starts_at' => Carbon::parse('2026-07-29 19:00:00', $timezone),
                'ends_at' => Carbon::parse('2026-07-29 20:00:00', $timezone),
                'location' => 'Online',
                'description' => 'Led by Matthew Muscedere (AI Club President).',
                'is_published' => true,
                'sort_order' => 0,
            ],
            [
                'title' => 'ML Model Training Workshop',
                'starts_at' => Carbon::parse('2026-07-30 19:00:00', $timezone),
                'ends_at' => Carbon::parse('2026-07-30 20:00:00', $timezone),
                'location' => 'Online',
                'description' => 'Led by Gabriel Rueda.',
                'is_published' => true,
                'sort_order' => 0,
            ],
        ];

        foreach ($items as $item) {
            Event::create($item);
        }
    }
}
