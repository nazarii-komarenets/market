<?php

namespace App\Models;

use Doctrine\DBAL\Query\QueryBuilder;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @mixin QueryBuilder
 */
class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'author_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'author_id');
    }

    protected static function booted(): void
    {
        static::deleting(function ($user) {
            if ($user->isForceDeleting()) {
                // Force delete related products if user is permanently deleted
                $user->products()->forceDelete();
            } else {
                // Soft delete related products
                $user->products()->delete();
            }
        });

        static::restoring(function ($user) {
            // Restore soft-deleted products when the user is restored
            $user->products()->withTrashed()->restore();
        });
    }
}
