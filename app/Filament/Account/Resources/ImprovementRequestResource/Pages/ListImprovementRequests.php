<?php

namespace App\Filament\Account\Resources\ImprovementRequestResource\Pages;

use App\Filament\Resources\ImprovementRequestResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;

class ListImprovementRequests extends ListRecords
{
    protected static string $resource = ImprovementRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->modalWidth(MaxWidth::Large),
        ];
    }
}
