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

    public function show(int|string $author_id, Product $product): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $userOrderCount = $this->userRepository->getOrderCount($author_id);

        return view('pages.product', [
            'product' => $product,
            'userOrderCount' => $userOrderCount,
        ]);
    }
}
