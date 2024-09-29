<div>
    <x-filament::card>
        <div class="mb-5">
            <x-filament::section.heading>Приєднуйся до спільноти Warhammer!</x-filament::section.heading>

            <p>Купуй, продавай, обмінюйся мініатюрами з однодумцями.</p>
        </div>

        <div class="flex gap-2">
            <x-filament::button color="gray">Про нас</x-filament::button>
            <a href="{{ route('registration') }}">
                <x-filament::button>Стати продавцем</x-filament::button>
            </a>
        </div>
    </x-filament::card>
</div>
