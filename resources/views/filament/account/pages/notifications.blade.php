<x-filament::page xmlns:x-filament="http://www.w3.org/1999/html">
    <form wire:submit.prevent="save">
        {{ $this->form }}
        <x-filament::button type="submit" class="mt-3">Зберегти</x-filament::button>
    </form>
</x-filament::page>
