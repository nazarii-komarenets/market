<?php

namespace App\Filament\Account\Resources;

use App\Filament\Account\Resources\OrderResource\Pages;
use App\Filament\Account\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $modelLabel = 'Замовлення';
    protected static ?string $pluralLabel = 'Замовлення';
    protected static ?string $pluralModelLabel = 'Замовлення';
    protected static ?string $navigationLabel = 'Замовлення';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('author_id', auth()->id());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('status_id')
                    ->relationship('status', 'name')
                    ->required(),
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'title')
                    ->disabled(),
                Forms\Components\TextInput::make('client_phone')
                    ->tel()
                    ->disabled()
                    ->maxLength(255),
                Forms\Components\TextInput::make('client_address')
                    ->required()
                    ->disabled()
                    ->maxLength(255),
                Forms\Components\Textarea::make('note')
                    ->required()
                    ->disabled()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('status.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('author.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('product.title')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('client_phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('client_address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
