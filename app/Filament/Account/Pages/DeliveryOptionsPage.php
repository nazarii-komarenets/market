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

class DeliveryOptionsPage extends Page
{
    use InteractsWithFormActions;

    protected static string $view = 'filament.account.pages.delivery-options';
    protected static ?string $title = 'Опції доставки';
    protected static ?string $slug = 'delivery-options';
    protected static ?string $navigationGroup = 'Налаштування';
    protected static bool $shouldRegisterNavigation = true;

    public ?array $data = [];

    public function mount(): void
    {
        $user = Auth::user();

        if (!$user->delivery_options) {
            $user->delivery_options()->create();
            $user->refresh();
        }

        $this->data = $user->delivery_options->toArray();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Toggle::make('nova_post')
                            ->label('Нова Пошта'),

                        Toggle::make('ukr_post')
                            ->label('Укр. Пошта'),

                        Toggle::make('meest')
                            ->label('Meest'),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $user = Auth::user();
        $user->delivery_options()->updateOrCreate(
            ['user_id' => $user->id],
            $this->data
        );

        Notification::make('success')
            ->title('Збережено')
            ->send();
    }
}
