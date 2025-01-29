<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class CheckoutNotification extends Notification
{
    use Queueable;

    protected Order $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [TelegramChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            ->to($notifiable->telegram_chat_id)
            ->content('У вас нове замовлення!')
            ->line(' ')
            ->line('---')
            ->line('Товар: ' . $this->order['product']['title'])
            ->line('Ціна: ' . $this->order['product']['price'] . ' грн.')
            ->line('---')
            ->line('Телефон: ' . $this->order['client_phone'])
            ->line('Адрес: ' . $this->order['client_address'])
            ->line('Примітка: ' . $this->order['note'])
            ->button('Відкрити замовлення', 'https://waha-market.online/account/orders');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
