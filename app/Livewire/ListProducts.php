<?php

namespace App\Livewire;

use App\Models\Product;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Livewire\Component;
use Tapp\FilamentValueRangeFilter\Filters\ValueRangeFilter;

class ListProducts extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function query(): \Illuminate\Database\Eloquent\Builder
    {
        return Product::query();
    }

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
                            ->badge()
                            ->numeric(),
                        TextColumn::make('title')
                            ->limit(60)
                            ->wrap()
                            ->size('xl')
                            ->extraAttributes(['class' => 'bold'])
                            ->searchable(),
                        TextColumn::make('price')
                            ->formatStateUsing(fn ($state) => number_format($state, 0, '.', ' ') . ' грн.')
                            ->sortable(),
                    ])
                ])
            ])
            ->contentGrid([
                'default' => 2,
                'sm' => 2,
                'md' => 3,
            ])
            ->recordUrl(fn ($record) => route('product.view', $record->slug))
            ->filters([
                SelectFilter::make('games')
                    ->relationship('game', 'title'),
                ValueRangeFilter::make('price'),
            ])->filtersLayout(FiltersLayout::Modal)
            ->paginated([21, 36, 60]);
    }
    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        return view('livewire.list-products');
    }
}
