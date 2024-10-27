<?php

namespace App\Livewire;

use App\Models\Seller;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\TextEntry;
use Livewire\Component;
use Filament\Infolists\Infolist;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;

class ViewSeller extends Component implements HasInfolists, HasForms
{
    use InteractsWithInfolists;
    use InteractsWithForms;

    public Seller $seller;

    public function mount($sellerId): void
    {
        $this->seller = Seller::findOrFail($sellerId);
    }

    public function sellerInfolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->seller)
            ->schema([
                Fieldset::make('Автор')->schema([
                    TextEntry::make('name'),
                    TextEntry::make('email'),
                    TextEntry::make('order_count')
                        ->label(__('Кількість замовлень')),
                ])
            ]);
    }

    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        return view('livewire.view-seller');
    }
}
