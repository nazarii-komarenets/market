<?php

namespace App\Http\Controllers;

use App\Http\Repositories\ProductRepository;
use App\Http\Repositories\UserRepository;
use App\Models\Order;
use App\Models\User;
use App\Notifications\TelegramCheckoutNotification;
use App\Notifications\OrderCreatedNotification;
use App\Services\OrderNotificationService;
use Filament\Notifications\Notification;

class CheckoutNotificationController extends Controller
{
    protected OrderNotificationService $orderNotificationService;

    public function __construct(OrderNotificationService $orderNotificationService)
    {
        $this->orderNotificationService = $orderNotificationService;
    }

    public function send(Order $order): void
    {
        $this->orderNotificationService->sendNotification($order);
    }
}
