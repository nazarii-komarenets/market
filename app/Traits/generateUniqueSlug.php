<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait generateUniqueSlug
{
    public static function generateUniqueSlug(
        $title,
        $table = 'products',
        $currentId = null
    ): string {
        $slug = Str::slug($title); // Create initial slug
        $originalSlug = $slug; // Save original slug for later reference
        $count = 1;

        // Query to check if the slug exists in the database, ignoring the current record if provided
        while (
        DB::table($table)
            ->where('slug', $slug)
            ->when($currentId, fn($query) => $query->where('id', '!=', $currentId))
            ->exists()
        ) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }
}
