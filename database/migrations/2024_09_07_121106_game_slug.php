<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->string('slug')->after('title');
        });

        foreach (\App\Models\Game::all() as $game) {
            $game->slug = \Illuminate\Support\Str::slug($game->title);
            $game->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('games', function($table) {
            $table->dropColumn('slug');
        });
    }
};
