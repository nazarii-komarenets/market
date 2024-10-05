<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class CheckoutNotification extends Notification
{
    use Queueable;

    protected array $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(array $order)
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
            ->line($this->order['product']['title'])
            ->line($this->order['product']['price'])
            ->line('---')
            ->line($this->order['client_phone'])
            ->line($this->order['client_address'])
            ->line($this->order['note'])
            ->button('Відкрити сайт', 'https://waha-market.online/account/orders');
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
