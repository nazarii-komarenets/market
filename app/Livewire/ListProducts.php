<?php

namespace App\Livewire;

use App\Models\Product;
use Exception;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Livewire\Component;
use Tapp\FilamentValueRangeFilter\Filters\ValueRangeFilter;

class ListProducts extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public ?int $filterBySellerId = null;

    public function query(): \Illuminate\Database\Eloquent\Builder
    {
        return Product::query();
    }

    /**
     * @throws Exception
     */
    public function table(Table $table): Table
    {
        return $table
            ->query($this->query())
            ->columns([
                Stack::make([
                    Stack::make([
                        ImageColumn::make('images.0')
                            ->defaultImageUrl('/images/product/default.png')
                            ->width('100%')
                            ->height('auto')
                            ->extraImgAttributes([
                                'class' => 'rounded',
                                'style' => 'height: 100%; max-height: 290px;'
                            ])
                            ->label('Image'),
                    ])->extraAttributes([
                            'class' => 'product__main_image_block'
                        ]),
                    Stack::make([
                        TextColumn::make('game.title')
                            ->badge(),

                        TextColumn::make('product_type.title')
                            ->badge(),

                        TextColumn::make('title')
                            ->limit(60)
                            ->wrap()
                            ->size('xl')
                            ->extraAttributes(['class' => 'bold'])
                            ->searchable(),
                        TextColumn::make('price')
                            ->label('Ціна')
                            ->formatStateUsing(fn ($state) => number_format($state, 0, '.', ' ') . ' грн.')
                            ->sortable(),
                    ])
                ])
            ])
            ->defaultSort('created_at', 'desc')
            ->contentGrid([
                'default' => 2,
                'sm' => 2,
                'md' => 4,
            ])
            ->recordUrl(fn ($record) => route('product.view', $record->slug))
            ->filters([
                SelectFilter::make('games')
                    ->label('Гра')
                    ->relationship('game', 'title'),

                SelectFilter::make('product_types')
                    ->label('Матеріал')
                    ->relationship('product_type', 'title'),

                SelectFilter::make('author')
                    ->label(__('Автор'))
                    ->searchable()
                    ->default(fn() => $this->filterBySellerId ?: null)
                    ->relationship('author', 'name'),
            ])
            ->filtersLayout(FiltersLayout::AboveContent)
            ->paginated([21, 36, 60]);
    }
    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        return view('livewire.list-products');
    }
}
