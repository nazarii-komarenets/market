<?php

namespace App\Livewire\Seller;

use App\Models\Seller;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Contracts\TranslatableContentDriver;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class ListSeller extends Component implements HasForms, HasTable
{
    use InteractsWithForms, InteractsWithTable;

    public function query(): Builder
    {
        return Seller::query();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->query())
            ->columns([
                Stack::make([
                    Split::make([
                        TextColumn::make('name'),

                        TextColumn::make('products_count')
                            ->counts('products')
                            ->prefix('Товарів: ')
                            ->alignEnd()
                            ->badge(),
                    ]),

                    TextColumn::make('order_count')
                        ->prefix('Замовлень: '),
                ])
            ])
            ->recordUrl(fn ($record) => route('seller.show', $record->id))
            ->filters([
                Filter::make('has_order')
                    ->toggle()
                    ->label('Має замовлення')
                    ->query(fn (Builder $query): Builder => $query->where('order_count', '>', 0))
            ])
            ->contentGrid([
                'default' => 2,
                'sm' => 2,
                'md' => 4,
            ]);
    }

    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        return view('livewire.seller.list');
    }
}
