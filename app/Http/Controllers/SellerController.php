<?php

namespace App\Http\Controllers;

use App\Http\Repositories\UserRepository;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Http\Request;

class SellerController extends Controller
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

    public function show(Seller $seller)
    {
//        dd($seller);
//        $userOrderCount = $this->userRepository->getOrderCount($product->author_id);

        return view('pages.seller', compact('seller'));
    }
}
