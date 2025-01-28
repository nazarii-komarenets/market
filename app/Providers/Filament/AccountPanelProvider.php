<?php

namespace App\Providers\Filament;

use App\Filament\Account\Resources\OrderResource\Widgets\OrderOverview;
use App\Filament\Account\Resources\ProductResource\Widgets\ProductOverview;
use App\Filament\Account\Widgets\ConnectTelegram;
use App\Filament\Account\Widgets\WelcomePage;
use App\Filament\Pages\Auth\EditProfile;
use App\Filament\Pages\Auth\Login;
use App\Filament\Pages\Auth\Register;
use App\Http\Middleware\IsAdmin;
use Filament\Enums\ThemeMode;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AccountPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('account')
            ->defaultThemeMode(ThemeMode::Light)
            ->darkMode(false)
            ->path('account')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->login()
            ->profile(EditProfile::class)
            ->registration(Register::class)
            ->discoverResources(in: app_path('Filament/Account/Resources'), for: 'App\\Filament\\Account\\Resources')
            ->discoverPages(in: app_path('Filament/Account/Pages'), for: 'App\\Filament\\Account\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->navigationItems([
                NavigationItem::make('main_page')
                    ->label('Головна сторінка')
                    ->url('/', shouldOpenInNewTab: true)
                    ->sort(100)
                    ->icon('heroicon-o-arrow-right-start-on-rectangle')
            ])
            ->discoverWidgets(in: app_path('Filament/Account/Widgets'), for: 'App\\Filament\\Account\\Widgets')
            ->widgets([
                WelcomePage::class,
                ConnectTelegram::class,
                ProductOverview::class,
                OrderOverview::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
