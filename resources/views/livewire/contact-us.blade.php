<div class="block md:flex justify-between">
    <div class="w-full md:w-1/2">
        <x-filament::section.heading class="mb-10">{{ __('Contacts_Form_Title') }}</x-filament::section.heading>

        <form wire:submit="create" class="mb-10">
            {{ $this->form }}

            <x-filament::button type="submit" class="mt-5">
                {{ __('Send') }}
            </x-filament::button>
        </form>

        <x-filament::section>
            <x-filament::section.description>
                Також ви можете зв`язатись напряму, якщо виникло щось термінове:
                <a href="https://t.me/n_komarenets" target="_blank">
                    @n_komarenets
                </a>
            </x-filament::section.description>
        </x-filament::section>
    </div>
</div>
