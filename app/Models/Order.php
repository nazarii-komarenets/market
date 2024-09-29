<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property User $author
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'status_id',
        'author_id',
        'product_id',
        'client_phone',
        'client_address',
        'note',
    ];

    protected $casts = [
        'status_id' => 'int',
        'author_id' => 'int',
        'product_id' => 'int',
        'client_phone' => 'string',
        'client_address' => 'string',
        'note' => 'string',
    ];

    public function status(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
