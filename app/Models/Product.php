<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'price',
        'description',
        'images',
        'quantity',
        'author_id',
        'game_id',
    ];

    protected $casts = [
        'title' => 'string',
        'slug' => 'string',
        'images' => 'json',
        'price' => 'int',
        'description' => 'string',
        'quantity' => 'int',
        'author_id' => 'int',
        'game_id' => 'int',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function game(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Game::class);
    }
}
