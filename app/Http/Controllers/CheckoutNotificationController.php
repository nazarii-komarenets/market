<?php

namespace App\Http\Controllers;

use App\Http\Repositories\ProductRepository;
use App\Http\Repositories\UserRepository;
use App\Models\User;
use App\Notifications\CheckoutNotification;

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
        $user = User::where('id', $author_id)->first();
        $order['product'] = $this->productRepository->getProductById($order['product_id']);

        if ($user->telegram_chat_id) {
            $user->notify(new CheckoutNotification($order));
        }
    }
}
