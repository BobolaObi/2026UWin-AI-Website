<?php

namespace Database\Seeders;

use App\Models\Leader;
use Illuminate\Database\Seeder;

class LeaderSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'sort_order' => 10,
                'name' => 'Hadiyah Arif',
                'title' => 'President',
                'bio' => 'Strategy, partnerships, and keeping the club aligned.',
                'photo_path' => 'images/leaders/hadiyah.png',
                'linkedin_url' => null,
                'github_url' => null,
            ],
            [
                'sort_order' => 20,
                'name' => 'Yusriyah Rahman',
                'title' => 'Vice President',
                'bio' => 'Ops, collaboration outreach, and member experience.',
                'photo_path' => 'images/leaders/Yusriyah_Rahman.jpg',
                'linkedin_url' => null,
                'github_url' => null,
            ],
            [
                'sort_order' => 30,
                'name' => 'Bobola Obiwale',
                'title' => 'Web Admin',
                'bio' => 'Site updates, chatbot activity, polls, and Discord links.',
                'photo_path' => 'images/leaders/BobolaObi.jpg',
                'linkedin_url' => null,
                'github_url' => null,
            ],
            [
                'sort_order' => 40,
                'name' => 'Mahnoz Akhtari',
                'title' => 'Head of Events',
                'bio' => 'Clubs Day prep, trivia night planning, and seminar logistics.',
                'photo_path' => 'images/leaders/manhoz.jpg',
                'linkedin_url' => null,
                'github_url' => null,
            ],
            [
                'sort_order' => 50,
                'name' => 'Aleena Azeem',
                'title' => 'Treasurer',
                'bio' => 'Funding, requisitions, and financial reporting.',
            ],
            [
                'sort_order' => 60,
                'name' => 'Muhammad Ali',
                'title' => 'Secretary',
                'bio' => 'Minutes, task sheets, and documentation.',
            ],
            [
                'sort_order' => 70,
                'name' => 'Omar Elkott',
                'title' => 'Head of Communication',
                'bio' => 'Comms schedule, AI image generator setup, collaborations.',
            ],
            [
                'sort_order' => 80,
                'name' => 'Abir Hirani',
                'title' => 'Head of Projects',
                'bio' => 'Project tracks, weekly breakdowns, and repo handoffs.',
            ],
            [
                'sort_order' => 90,
                'name' => 'Isaac P',
                'title' => 'Head of Research',
                'bio' => 'Paper selection, datasets, timelines, and starter repos.',
            ],
            [
                'sort_order' => 100,
                'name' => 'Sadat Tanzim',
                'title' => 'Project Coordinator',
                'bio' => 'Tracks execution, workshop flow, and participant support.',
            ],
            [
                'sort_order' => 110,
                'name' => 'Hassan Zafar',
                'title' => 'Research Coordinator',
                'bio' => 'Prompt engineering activity and research stream support.',
            ],
            [
                'sort_order' => 120,
                'name' => 'Prushti Patel',
                'title' => 'Research Coordinator',
                'bio' => 'Paper sprints, datasets, and schedule alignment.',
            ],
            [
                'sort_order' => 130,
                'name' => 'Yumna Sumya',
                'title' => 'Marketing Coordinator',
                'bio' => 'Flyers, blue/yellow branding, and promotional cadence.',
            ],
            [
                'sort_order' => 140,
                'name' => 'Amarjot',
                'title' => 'Content Creator',
                'bio' => 'Flyers and content for activities and streams.',
            ],
            [
                'sort_order' => 150,
                'name' => 'Zahra Gurmani',
                'title' => 'Content Creator',
                'bio' => 'Flyers and prompt-engineering explainer content.',
            ],
        ];

        foreach ($items as $item) {
            Leader::query()->updateOrCreate(
                [
                    'name' => $item['name'],
                    'title' => $item['title'] ?? null,
                ],
                [
                    'sort_order' => $item['sort_order'],
                    'bio' => $item['bio'] ?? null,
                    'photo_path' => $item['photo_path'] ?? null,
                    'linkedin_url' => $item['linkedin_url'] ?? null,
                    'github_url' => $item['github_url'] ?? null,
                ]
            );
        }
    }
}

