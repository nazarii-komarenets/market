<x-filament::page>
    <form wire:submit.prevent="save">
        {{ $this->form }}
        <button type="submit" class="filament-button">Save</button>
    </form>
</x-filament::page>
