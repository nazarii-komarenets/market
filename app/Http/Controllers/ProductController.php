<?php

namespace App\Http\Controllers;

use App\Http\Repositories\UserRepository;
use App\Models\Product;

class ProductController extends Controller
{
    protected UserRepository $userRepository;
    protected Product $product;

    public function __construct(Product $product, UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->product = $product;
    }

    public function show(Product $product)
    {
        $userOrderCount = $this->userRepository->getOrderCount($product->author_id);

        return view('pages.product', [
            'product' => $product,
            'userOrderCount' => $userOrderCount,
        ]);
    }

    public function getProduct()
    {
        return $this->product;
    }
}
