<?php
// database/seeders/SampleDataSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Show;
use App\Models\Episode;
use App\Models\Comment;
use App\Models\Favorite;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create categories (safe to run multiple times)
        $categories = [
            ['name' => 'Culture', 'slug' => 'culture', 'description' => 'Pop culture and entertainment discussions'],
            ['name' => 'Music', 'slug' => 'music', 'description' => 'Music reviews and interviews'],
            ['name' => 'Celebrity', 'slug' => 'celebrity', 'description' => 'Celebrity news and gossip'],
            ['name' => 'TV', 'slug' => 'tv', 'description' => 'Television shows and reviews'],
            ['name' => 'Movies', 'slug' => 'movies', 'description' => 'Movie reviews and discussions'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['slug' => $category['slug']], $category);
        }

        // Create sample users (safe to run multiple times)
        $admin = User::firstOrCreate(
            ['email' => 'admin@guhso.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'language_pref' => 'en',
            ]
        );

        $user = User::firstOrCreate(
            ['email' => 'user@guhso.com'],
            [
                'name' => 'John Doe',
                'password' => bcrypt('password'),
                'role' => 'user',
                'language_pref' => 'en',
            ]
        );

        // Create sample shows (safe to run multiple times)
        $shows = [
            [
                'title' => 'Keep It!',
                'description' => 'Each week, the hosts get together with actors, politicians, and many others to discuss what\'s happening in entertainment.',
                'author' => 'Crooked Media',
                'language' => 'en',
                'is_active' => true,
            ],
            [
                'title' => 'Pop Culture Weekly',
                'description' => 'Your weekly dose of pop culture news, reviews, and hot takes.',
                'author' => 'Entertainment Network',
                'language' => 'en',
                'is_active' => true,
            ],
            [
                'title' => 'Music Matters',
                'description' => 'Deep dives into the music that matters, from indie to mainstream.',
                'author' => 'Music Media Co',
                'language' => 'en',
                'is_active' => true,
            ],
        ];

        foreach ($shows as $showData) {
            $show = Show::firstOrCreate(
                ['title' => $showData['title']],
                $showData
            );
            
            // Only attach categories if not already attached
            if ($show->categories()->count() === 0) {
                $randomCategories = Category::inRandomOrder()->take(rand(1, 3))->pluck('id');
                $show->categories()->attach($randomCategories);
            }
            
            // Only create episodes if show doesn't have any
            if ($show->episodes()->count() === 0) {
                for ($i = 1; $i <= 5; $i++) {
                    $episode = Episode::create([
                        'show_id' => $show->id,
                        'title' => "Episode {$i}: " . fake()->sentence(4),
                        'description' => fake()->paragraph(3),
                        'audio_url' => 'https://example.com/audio/episode-' . $show->id . '-' . $i . '.mp3',
                        'duration' => rand(1800, 7200), // 30min to 2 hours
                        'published_at' => now()->subDays(rand(1, 30)),
                        'episode_number' => $i,
                        'file_size' => rand(50000000, 200000000), // 50MB to 200MB
                        'mime_type' => 'audio/mpeg',
                        'is_manual' => true,
                        'is_published' => true,
                    ]);

                    // Add some comments
                    if (rand(1, 3) === 1) { // 33% chance of having comments
                        Comment::create([
                            'user_id' => $user->id,
                            'episode_id' => $episode->id,
                            'content' => fake()->paragraph(2),
                            'rating' => rand(3, 5),
                            'is_approved' => true,
                        ]);
                    }

                    // Add some favorites
                    if (rand(1, 4) === 1) { // 25% chance of being favorited
                        Favorite::firstOrCreate([
                            'user_id' => $user->id,
                            'episode_id' => $episode->id,
                        ]);
                    }
                }
            }
        }

        $this->command->info('Sample data seeded successfully!');
        $this->command->info('Login credentials:');
        $this->command->info('Admin: admin@guhso.com / password');
        $this->command->info('User: user@guhso.com / password');
        $this->command->info('Categories: ' . Category::count());
        $this->command->info('Shows: ' . Show::count());
        $this->command->info('Episodes: ' . Episode::count());
    }
}