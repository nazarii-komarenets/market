<?php
namespace App\Observers;

use App\Models\Order;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    public function created(Order $order): void
    {
        if (!$order->author) {
            Log::error("Order {$order->id} has no author associated. Created method");
            return;
        }

        $order->author->increment('order_count');
    }

    public function deleted(Order $order): void
    {
        if (!$order->author) {
            Log::error("Order {$order->id} has no author associated. Deleted method");
            return;
        }

        $order->author->decrement('order_count');
    }
}
