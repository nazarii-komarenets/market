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
        $games = ['Warhammer 40k', 'Kill Team', 'Warhammer Aos'];

        foreach ($games as $game) {
            Game::factory(['title' => $game])->create();
        }
    }
}
