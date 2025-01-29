<?php

namespace App\Notifications;

use App\Models\Order;
use Filament\Notifications\Actions\Action;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification
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
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toDatabase(object $notifiable): \Filament\Notifications\DatabaseNotification
    {
        return \Filament\Notifications\Notification::make()
            ->title('У Вас нове замовлення!')
            ->body('Перегляньте деталі вашого замовлення.')
            ->icon('heroicon-o-shopping-cart')
            ->actions([
                Action::make('view')
                    ->button()
                    ->label('Переглянути')
                    ->url(route('filament.account.resources.orders.edit', ['record' => $this->order->id])),
            ])
            ->toDatabase();
    }
}
