<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $games = [
            ['title' => 'Warhammer 40k', 'slug' => 'warhammer-40k'],
            ['title' => 'Kill Team', 'slug' => 'kill-team'],
            ['title' => 'Warhammer Aos', 'slug' => 'warhammer-aos'],
        ];

        foreach ($games as $game) {
            Game::factory([
                'title' => $game['title'],
                'slug' => $game['slug'],
            ])->create();
        }
    }
}
