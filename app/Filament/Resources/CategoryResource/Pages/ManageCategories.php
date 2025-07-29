<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCategories extends ManageRecords
{
    //use ManageRecords\Concerns\Translatable;

    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //Actions\LocaleSwitcher::make(),
            Actions\CreateAction::make()
            ->slideOver()
            ->mutateFormDataUsing(function (array $data): array {
                unset($data['is_subcategory']);
                //dd($data);
                return $data;
            }),
        ];
    }
}
