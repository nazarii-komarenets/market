<div class="block md:flex justify-between">
    <div class="w-full md:w-1/2">
        <x-filament::section>
            <form wire:submit="create">
                {{ $this->form }}

                <x-filament::button type="submit" class="mt-5">
                    Оформити
                </x-filament::button>
            </form>
        </x-filament::section>
    </div>
    <div class="w-full md:w-1/3">
        {{ $this->orderInfolist }}
    </div>
</div>
