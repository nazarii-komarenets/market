<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Register as BaseRegister;
class Register extends BaseRegister
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        TextInput::make('name')
                            ->label(__('filament-panels::pages/auth/register.form.name.label'))
                            ->minLength(3)
                            ->maxLength(255)
                            ->required()
                            ->autofocus(),
                        TextInput::make('email')
                            ->label(__('filament-panels::pages/auth/register.form.email.label'))
                            ->email()
                            ->required()
                            ->minLength(5)
                            ->maxLength(255)
                            ->unique($this->getUserModel()),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }
}
