<?php

namespace App\Filament\Account\Pages;

use App\Models\User;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class NotificationsPage extends Page
{
    use InteractsWithFormActions;

    protected static string $view = 'filament.account.pages.notifications';
    protected static ?string $title = 'Сповіщення';
    protected static ?string $slug = 'notifications';
    protected static ?string $navigationGroup = 'Налаштування';
    protected static bool $shouldRegisterNavigation = true;

    public ?array $data = [];

    public function mount(): void
    {
        $user = Auth::user();

        if (!$user->settings) {
            $user->settings()->create();
            $user->refresh();
        }

        $this->data = $user->settings->toArray();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Toggle::make('notifications_enabled')
                            ->label('Включити сповіщення'),

                        Toggle::make('telegram_notifications_enabled')
                            ->label('Включити Телеграм сповіщення'),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $user = Auth::user();
        $user->settings()->updateOrCreate(
            ['user_id' => $user->id],
            $this->data
        );

        Notification::make('success')
            ->title('Збережено')
            ->send();
    }
}
