<?php

namespace App\Http\Controllers;

use App\Http\Repositories\ProductRepository;
use App\Http\Repositories\UserRepository;
use App\Models\Order;
use App\Models\User;
use App\Notifications\CheckoutNotification;
use App\Notifications\OrderCreatedNotification;
use Filament\Notifications\Notification;

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

    public function send(Order $order): void
    {
        $user = User::where('id', $order->author_id)->first();
        $order['product'] = $this->productRepository->getProductById($order->product_id);

        $user->notify(new OrderCreatedNotification($order));

        if ($user->telegram_chat_id) {
            $user->notify(new CheckoutNotification($order));
        }
    }
}
