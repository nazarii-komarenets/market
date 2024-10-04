@php
    $user = filament()->auth()->user();
@endphp

<x-filament-widgets::widget class="fi-account-widget">
        <x-filament::section>
            <div class="flex items-center gap-x-3">
                <x-filament-panels::avatar.user size="lg" :user="$user" />

                <div class="flex-1">
                    <h2
                        class="grid flex-1 text-base font-semibold leading-6 text-gray-950 dark:text-white"
                    >
                        {{ __('filament-panels::widgets/account-widget.welcome', ['app' => config('app.name')]) }}
                    </h2>

                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ filament()->getUserName($user) }}
                    </p>
                </div>

                <form
                    action="{{ filament()->getLogoutUrl() }}"
                    method="post"
                    class="my-auto"
                >
                    @csrf

                    <x-filament::button
                        color="gray"
                        icon="heroicon-m-arrow-left-on-rectangle"
                        icon-alias="panels::widgets.account.logout-button"
                        labeled-from="sm"
                        tag="button"
                        type="submit"
                    >
                        Вийти
                    </x-filament::button>
                </form>
                <x-filament::button>
                    <a target="_blank" href="{{ route('welcome') }}">Відкрити сайт</a>
                </x-filament::button>
            </div>
        </x-filament::section>
    </x-filament-widgets::widget>
