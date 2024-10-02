<?php

namespace App\Http\Controllers;

use App\Http\Repositories\UserRepository;
use App\Models\Product;

class ProductController extends Controller
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        return view('pages.products');
    }

    public function show(Product $product)
    {
        $userOrderCount = $this->userRepository->getOrderCount($product->author_id);

        return view('pages.product', [
            'product' => $product,
            'userOrderCount' => $userOrderCount,
        ]);
    }
}
