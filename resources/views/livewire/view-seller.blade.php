<div>
    <x-filament::section class="mb-5">
        {{ $this->sellerInfolist }}
    </x-filament::section>

    <div>
        @livewire('list-products', ['filterBySellerId' => $seller->id])
    </div>
</div>
