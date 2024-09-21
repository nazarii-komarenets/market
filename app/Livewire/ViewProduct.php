<?php

namespace App\Livewire;

use App\Models\Product;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Split;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Livewire\Component;

class ViewProduct extends Component implements HasForms, HasInfolists
{
    use InteractsWithInfolists;
    use InteractsWithForms;

    public Product $product;

    public function mount(Product $product): void
    {
        $this->product = $product;
    }

    public function productInfolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->product)
            ->schema([
                Split::make([
                    Group::make([
                        ImageEntry::make('images')
                            ->label('')
                            ->extraImgAttributes([
                                'data-fancybox' => "images",
                            ]),
                        Section::make([
                            TextEntry::make('title'),
                            TextEntry::make('description'),
                        ]),
                    ]),
                    Section::make([
                        TextEntry::make('price'),
                    ])->grow(false),
                ])
            ]);
    }

    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        return view('livewire.view-product');
    }
}
