<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
    ];

    protected $casts = [
        'title' => 'string',
        'slug' => 'string',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Product::class);
    }
}
