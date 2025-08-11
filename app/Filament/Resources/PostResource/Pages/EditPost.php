<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Populate parent_category and subcategory_id fields for editing
        if (isset($data['category_id'])) {
            $category = \App\Models\Category::find($data['category_id']);
            if ($category) {
                if ($category->parent_id) {
                    // If it's a subcategory, set parent_category to its parent and subcategory_id to itself
                    $data['parent_category'] = $category->parent_id;
                    $data['subcategory_id'] = $category->id;
                } else {
                    // If it's a parent category, set parent_category to itself
                    $data['parent_category'] = $category->id;
                    $data['subcategory_id'] = null;
                }
            }
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Handle published_at timestamp
        if (isset($data['is_published']) && $data['is_published']) {
            $data['published_at'] = $data['published_at'] ?? now();
        } else {
            $data['published_at'] = null;
        }

        return $data;
    }
}
