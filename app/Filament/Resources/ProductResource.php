<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Tapp\FilamentValueRangeFilter\Filters\ValueRangeFilter;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Split::make([
                    Forms\Components\Section::make([

                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->reactive()
                            ->minLength(3)
                            ->maxLength(255)
                            ->rule('string')
                            ->rule('regex:/^[a-zA-Z0-9\s\-]+$/')
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', static::generateUniqueSlug($state)))
                            ->maxLength(255),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->dehydrated()
                            ->rule('alpha_dash')
                            ->lazy()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\FileUpload::make('images')
                            ->multiple()
                            ->image()
                            ->reorderable()
                            ->maxWidth('50%')
                            ->maxFiles(5)
                            ->maxSize(2048)
                            ->disk('public')
                            ->directory('products/images')
                            ->label('Product Images'),

                    ]),
                    Forms\Components\Section::make([

                        Forms\Components\Select::make('game_id')
                            ->relationship('game', 'title')
                            ->required(),

                        Forms\Components\TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->default(0),

                        Forms\Components\TextInput::make('quantity')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->default(1),

                        Forms\Components\Select::make('author_id')
                            ->relationship('author', 'name')
                            ->required(),
                    ])->grow(false),
                ])->columnSpanFull(),
                Forms\Components\Section::make([
                    Forms\Components\RichEditor::make('description'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->formatStateUsing(fn ($state) => number_format($state, 0) . ' грн.')
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('author.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('game.title')
                    ->numeric()
                    ->sortable(),
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
                Tables\Filters\SelectFilter::make('games')
                    ->relationship('game', 'title'),
                ValueRangeFilter::make('price'),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
