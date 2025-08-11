<?php

namespace App\Filament\Resources\CareerResource\Pages;

use App\Filament\Resources\CareerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCareer extends CreateRecord
{
    protected static string $resource = CareerResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = \Illuminate\Support\Facades\Auth::id();

        // The model mutators will handle array to JSON conversion for meta_keywords
        return $data;
    }
}
