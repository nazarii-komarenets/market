<?php

namespace App\Filament\Account\Resources\ImprovementRequestResource\Pages;

use App\Filament\Resources\ImprovementRequestResource;
use Filament\Resources\Pages\CreateRecord;

class CreateImprovementRequests extends CreateRecord
{
    protected static string $resource = ImprovementRequestResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
