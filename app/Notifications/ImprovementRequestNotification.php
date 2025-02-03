<?php

namespace App\Notifications;

use App\Models\ImprovementRequest;
use Filament\Notifications\Actions\Action;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ImprovementRequestNotification extends Notification
{
    use Queueable;

    protected ImprovementRequest $improvementRequest;

    /**
     * Create a new notification instance.
     */
    public function __construct(ImprovementRequest $improvementRequest)
    {
        $this->improvementRequest = $improvementRequest;
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

    public function toDatabase(object $notifiable): \Filament\Notifications\DatabaseNotification
    {
        return \Filament\Notifications\Notification::make()
            ->title('Ваш запит отримав відповідь!')
            ->body('Перегляньте деталі')
            ->icon('heroicon-o-chat-bubble-bottom-center-text')
            ->actions([
                Action::make('view')
                    ->button()
                    ->label('Переглянути')
                    ->url(route('filament.account.resources.improvement-requests.index', ['record' => $this->improvementRequest->id])),
            ])
            ->toDatabase();
    }
}
