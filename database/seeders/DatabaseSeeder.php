<?php

namespace Database\Seeders;

use App\Models\System\ReputationLog;
use App\Models\System\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        if(Storage::disk('local')->exists('version.lock')) {
            Storage::disk('local')->delete('version.lock');
        }
        Artisan::call('app:update');
        $this->command->info('Finished Setup');

        $users = \App\Models\System\User::factory(20)->create();
        $levels = \App\Models\GeometryDash\Level::factory(30)->create();
        $reviews = \App\Models\Content\Review::factory(100)->create();

        $this->command->info('Seeded users with levels and reviews');

        \App\Models\Content\Forum::factory(1)->create([
            'name' => 'Official',
            'category' => true,
            'parent_id' => null
        ]);
        \App\Models\Content\Forum::factory(1)->create([
            'name' => 'General',
            'category' => true,
            'parent_id' => null
        ]);

        \App\Models\Content\Forum::factory(7)->create();
        $this->command->info('Seeded forums');
        \App\Models\Content\Thread::factory(25)->create();
        $this->command->info('Seeded threads');
        \App\Models\Social\PostLike::factory(100)->create();
        $this->command->info('Seeded forum content');

        $levels->load('reviews');
        $levels->each(function ($level, $i) {
            $count = 0;
            $total_gameplay = 0;
            $total_difficulty = 0;
            $total_visuals = 0;
            $total_overall = 0;
            foreach ($level->reviews as $review) {
                $count++;
                $total_gameplay += $review->rating_gameplay;
                $total_difficulty += $review->rating_difficulty;
                $total_visuals += $review->rating_visuals;
                $total_overall += $review->rating_overall;
            }
            if ($count >= 20) {
                $level->rating_gameplay = $total_gameplay / $count;
                $level->rating_difficulty = $total_difficulty / $count;
                $level->rating_visuals = $total_visuals / $count;
                $level->rating_overall = $total_overall / $count;
                $level->save();
            }
        });

        $this->command->info('Calculated initial review scores');

        \App\Models\Content\Playlist::factory(5)->create();

        \App\Models\Social\ProfileComment::factory(100)->create();
        \App\Models\Social\Message::factory(100)->create();
        \App\Models\Social\Friend::factory(20)->create();
        $reps = \App\Models\System\ReputationLog::factory(50)->create();
        $this->command->info('Seeded additional profile data');
        $users->each(function (User $user) {
            $user->reputation = ReputationLog::whereRecipientId($user->id)->sum('reputation');
            $user->save();
        });
        $this->command->info('Persisted reputation totals');
    }
}
