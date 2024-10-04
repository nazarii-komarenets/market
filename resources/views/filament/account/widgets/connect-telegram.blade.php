@php
    $user = \Illuminate\Support\Facades\Auth::user();
@endphp
<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex justify-between">
            Телеграм
            @if(!$user->telegram_chat_id)
                <x-filament::button>
                    <a href="{{ route('telegram-temp-url') }}">Підключити</a>
                </x-filament::button>
            @else
                <x-filament::badge color="success">Підключено</x-filament::badge>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
