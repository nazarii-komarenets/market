<?php

namespace App\Filament\Resources;

use App\Filament\Account\Resources\ImprovementRequestResource\Pages\CreateImprovementRequests;
use App\Filament\Account\Resources\ImprovementRequestResource\Pages\ListImprovementRequests;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms;
use Filament\Notifications\Notification;
use App\Models\ImprovementRequest;
use App\Enums\ImprovementRequestStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ImprovementRequestResource extends Resource
{
    protected static ?string $model = ImprovementRequest::class;

    protected static ?string $label = "Запити на покращення";
    protected static ?string $pluralLabel = "Запити на покращення";
    protected static ?string $navigationIcon = "heroicon-o-chat-bubble-bottom-center-text";

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make([
                    Forms\Components\TextInput::make('title')
                        ->label('Заголовок')
                        ->required(),
                    Forms\Components\Textarea::make('description')
                        ->label('Опис')
                        ->required(),
                    Forms\Components\Select::make('status')
                        ->options([
                            ImprovementRequestStatus::Pending->value => ImprovementRequestStatus::Pending->label(),
                            ImprovementRequestStatus::Approved->value => ImprovementRequestStatus::Approved->label(),
                            ImprovementRequestStatus::Rejected->value => ImprovementRequestStatus::Rejected->label(),
                        ])
                        ->default(ImprovementRequestStatus::Pending->value)
                        ->hidden(fn () => !auth()->user()->is_admin),
                ])
            ])
            ->columns(1);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query(ImprovementRequest::query()->when(
                !auth()->user()->is_admin,
                fn($query) => $query->where('user_id', auth()->id())
            ))
            ->columns([
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('user.name')
                    ->visible(fn ($record) => auth()->user()->is_admin)
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')->limit(50),
                Tables\Columns\TextColumn::make('created_at')
                    ->sortable()
                    ->dateTime(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Очікує',
                        'approved' => 'Схвалено',
                        'rejected' => 'Відхилено',
                    ]),
                Tables\Filters\Filter::make('only_my_requests')
                    ->label('Мої запити')
                    ->query(fn ($query) => $query->where('user_id', auth()->id())),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('approve')
                    ->label('Схвалити')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => auth()->user()->is_admin && $record->status === ImprovementRequestStatus::Pending)
                    ->action(fn ($record) => self::changeStatus($record, ImprovementRequestStatus::Approved)),

                Tables\Actions\Action::make('reject')
                    ->label('Відхилити')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => auth()->user()->is_admin && $record->status === ImprovementRequestStatus::Pending)
                    ->action(fn ($record) => self::changeStatus($record, ImprovementRequestStatus::Rejected)),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListImprovementRequests::route('/'),
            'create' => CreateImprovementRequests::route('/create'),
        ];
    }

    public static function changeStatus($record, $status)
    {
        $record->update(['status' => $status]);

        Notification::make()
            ->title("Ваш запит {$record->title} було " . ($status === ImprovementRequestStatus::Approved ? 'схвалено' : 'відхилено'))
            ->sendToDatabase($record->user);
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->id() === $record->user_id;
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->id() === $record->user_id;
    }
}
