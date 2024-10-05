<?php

namespace App\Http\Controllers;

use App\Http\Repositories\ProductRepository;
use App\Http\Repositories\UserRepository;
use App\Models\Product;
use App\Notifications\CheckoutNotification;
use Illuminate\Http\Request;

class CheckoutNotificationController extends Controller
{
    protected UserRepository $userRepository;
    protected ProductRepository $productRepository;

    public function __construct(
        UserRepository $userRepository,
        ProductRepository $productRepository
    ) {
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
    }

    public function send(array $order, int $author_id): void
    {
        $user = $this->userRepository->getUserByAuthorId($author_id);
        $order['product'] = $this->productRepository->getProductById($order['product_id']);

        $user->notify(new CheckoutNotification($order));
    }
}
