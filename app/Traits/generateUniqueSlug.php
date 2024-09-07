<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait generateUniqueSlug
{
    public static function generateUniqueSlug($title, $table = 'products'): string
    {
        $slug = Str::slug($title); // Create initial slug
        $originalSlug = $slug; // Save original slug for later reference
        $count = 1;

        // Check if the slug exists in the database, and append a number if needed
        while (
        DB::table($table)->where('slug', $slug)->exists()
        ) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }
}
