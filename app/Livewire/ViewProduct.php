<?php

namespace App\Livewire;

use App\Models\Product;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Infolists\Components\Actions;
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
use Filament\Support\Enums\VerticalAlignment;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Livewire\Component;

class ViewProduct extends Component implements HasForms, HasInfolists, HasActions
{
    use InteractsWithActions;
    use InteractsWithInfolists;
    use InteractsWithForms;

    public Product $product;
    public int $userOrderCount;

    public static function query(): Builder
    {
        return parent::query()->withCount('orders');
    }

    public function mount(Product $product, int $userOrderCount): void
    {
        $this->product = $product;
        $this->userOrderCount = $userOrderCount;
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
                                'class' => 'rounded hover:cursor-pointer',
                                'data-fancybox' => "images",
                            ]),
                        Section::make([
                            TextEntry::make('game.title')
                                ->label('')
                                ->badge(),
                            TextEntry::make('title')
                                ->label(''),
                            TextEntry::make('description')
                                ->html()
                                ->label('Опис'),
                        ]),
                        TextEntry::make('created_at')
                            ->dateTime('H:i M d, Y')
                            ->label('Створено: '),
                    ]),
                    Group::make([
                        Section::make([
                            TextEntry::make('author.name')
                                ->label(''),
                            TextEntry::make('author.orders_count')
                                ->getStateUsing(fn () => $this->userOrderCount)
                                ->inlineLabel()
                                ->label('Замовлень: '),
                        ]),
                        Section::make([
                                Group::make(['info'])
                                    ->schema([
                                        TextEntry::make('quantity')
                                            ->inlineLabel()
                                            ->label('Кількість'),
                                        TextEntry::make('price')
                                            ->inlineLabel()
                                            ->suffix(' грн.')
                                            ->label('Ціна'),
                                    ])->grow(false),
                                Actions::make([
                                    Actions\Action::make('buy')
                                        ->openUrlInNewTab()
                                        ->url(fn ($record) => route('checkout.product', $record->slug))
                                        ->label('Купити'),
                                ]),
                        ]),
                    ])->extraAttributes(['class' => 'mt-6'])->grow(false),
                ])->from('md')
            ]);
    }

    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        return view('livewire.view-product');
    }
}
