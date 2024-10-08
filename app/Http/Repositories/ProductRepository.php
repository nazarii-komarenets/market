<?php

namespace App\Http\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function getProductById(int $id)
    {
        return Product::where('id', $id)->first();
    }
}
