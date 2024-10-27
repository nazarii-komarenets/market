<?php

namespace App\Http\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function getProductById(int $id)
    {
        return Product::where('id', $id)->first();
    }

    public function getProductsBySeller(int $sellerId)
    {
        return Product::where('author_id', $sellerId)->all();
    }
}
