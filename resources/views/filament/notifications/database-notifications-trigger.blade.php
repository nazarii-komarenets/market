<x-filament::icon-button icon="heroicon-o-bell">
    @if($unreadNotificationsCount)
        <x-slot name="badge">
            {{ $unreadNotificationsCount }}
        </x-slot>
    @endif
</x-filament::icon-button>
