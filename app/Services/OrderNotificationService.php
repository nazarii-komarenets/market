<?php
namespace App\Services;

use App\Http\Repositories\ProductRepository;
use App\Http\Repositories\UserRepository;
use App\Notifications\TelegramCheckoutNotification;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\User;

class OrderNotificationService
{
    protected ProductRepository $productRepository;
    protected UserRepository $userRepository;

    public function __construct(
        ProductRepository $productRepository,
        UserRepository $userRepository
    ) {
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
    }

    public function sendNotification(Order $order): void
    {
        try {
            $user = $this->userRepository->getById($order->author_id);

            if (!$user) {
                Log::warning("User not found for order ID: {$order->id}");
                return;
            }

            $order->product = $this->productRepository->getProductById($order->product_id);

            $this->notifyUser($user, $order);
            $this->notifyTelegram($user, $order);

            Log::info("Order notification sent successfully for order ID: {$order->id}");
        } catch (\Throwable $e) {
            Log::error("Failed to send order notification", [
                'order_id' => $order->id ?? null,
                'message'  => $e->getMessage(),
                'trace'    => $e->getTraceAsString(),
            ]);
        }
    }

    private function notifyUser(User $user, Order $order): void
    {
        if ($user->settings?->notifications_enabled) {
            $user->notify(new OrderCreatedNotification($order));
        }
    }

    private function notifyTelegram(User $user, Order $order): void
    {
        if (!empty($user->telegram_chat_id) && $user->settings?->telegram_notifications_enabled) {
            $user->notify(new TelegramCheckoutNotification($order));
        }
    }
}
