<?php
namespace App\Services;

use App\Http\Repositories\ProductRepository;
use App\Notifications\TelegramCheckoutNotification;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\User;

class OrderNotificationService
{
    protected ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function sendNotification(Order $order): void
    {
        try {
            $user = User::find($order->author_id);

            if (!$user) {
                Log::warning("User not found for order ID: {$order->id}");
                return;
            }

            $order->product = $this->productRepository->getProductById($order->product_id);

            $user->notify(new OrderCreatedNotification($order));

            if (!empty($user->telegram_chat_id)) {
                $user->notify(new TelegramCheckoutNotification($order));
            }

            Log::info("Order notification sent successfully for order ID: {$order->id}");
        } catch (\Throwable $e) {
            Log::error("Failed to send order notification: " . $e->getMessage(), [
                'order_id' => $order->id ?? null,
                'trace'    => $e->getTraceAsString(),
            ]);
        }
    }
}
