<?php

namespace App\Filament\Account\Pages;

use App\Models\UserSettings;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class UserSettingsPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.account.pages.user-settings';
    protected static ?string $title = 'Settings';
    protected static ?string $slug = 'settings';
    protected static bool $shouldRegisterNavigation = true;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Toggle::make('notifications_enabled')
                    ->label('Enable Notifications')
                    ->live(),

                Toggle::make('telegram_notifications_enabled')
                    ->label('Enable Telegram Notifications')
                    ->live(),
            ]);
    }
}
