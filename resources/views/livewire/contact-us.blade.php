<div class="block md:flex justify-between">
    <div class="w-full md:w-1/2">
        <form wire:submit="create">
            {{ $this->form }}

            <x-filament::button type="submit" class="mt-5">
                Відправити
            </x-filament::button>
        </form>
    </div>
</div>
