<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use GalleryJsonMedia\Form\JsonMediaGallery;
use GalleryJsonMedia\Tables\Columns\JsonMediaColumn;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                        if (($get('slug') ?? '') !== Str::slug($old)) {
                            return;
                        }
                    
                        $set('slug', Str::slug($state));
                    }),
                Forms\Components\TextInput::make('slug')
                    ->required(),
                TinyEditor::make('content')
                    ->fileAttachmentsDisk('uploads')
                    ->fileAttachmentsDirectory('posts')
                    ->profile('full')
                    ->columnSpan('full')
                    ->required(),
                Forms\Components\Select::make('parent_category')
                    ->label('Parent Category')
                    ->options(function () {
                        return \App\Models\Category::where('type', 'post')
                            ->whereNull('parent_id')
                            ->get()
                            ->pluck('title', 'id')
                            ->toArray();
                    })
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function (Set $set, Get $get, $state) {
                        // Always set the parent as the default category
                        $set('category_id', $state);
                        
                        // Clear subcategory selection when parent changes
                        $set('subcategory_id', null);
                    })
                    ->dehydrated(false), // Don't save this field to database
                Forms\Components\Select::make('subcategory_id')
                    ->label('Subcategory (Optional)')
                    ->options(function (Get $get) {
                        $parentCategoryId = $get('parent_category');
                        if (!$parentCategoryId) {
                            return [];
                        }
                        
                        return \App\Models\Category::where('type', 'post')
                            ->where('parent_id', $parentCategoryId)
                            ->get()
                            ->pluck('title', 'id')
                            ->toArray();
                    })
                    ->searchable()
                    ->preload()
                    ->visible(function (Get $get) {
                        $parentCategoryId = $get('parent_category');
                        if (!$parentCategoryId) {
                            return false;
                        }
                        
                        return \App\Models\Category::where('type', 'post')
                            ->where('parent_id', $parentCategoryId)
                            ->exists();
                    })
                    ->afterStateUpdated(function (Set $set, Get $get, $state) {
                        // If a subcategory is selected, use it as the final category
                        // Otherwise, keep the parent category
                        if ($state) {
                            $set('category_id', $state);
                        } else {
                            $set('category_id', $get('parent_category'));
                        }
                    })
                    ->dehydrated(false), // Don't save this field to database
                Forms\Components\Hidden::make('category_id')
                    ->required(),
                Forms\Components\Select::make('tags')
                    ->multiple()
                    ->relationship('tags', 'name')
                    ->preload()
                    ->searchable()
                    ->required()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->required(),
                    ]),
                Forms\Components\FileUpload::make('featured_image')
                    ->directory('uploads/posts')
                    ->image()
                    ->visibility('public'),
                JsonMediaGallery::make('gallery_images')
                    ->disk('uploads')
                    ->directory('posts')
                    ->reorderable()
                    ->preserveFilenames()
                    ->acceptedFileTypes(['image/*'])
                    ->visibility('public')
                    ->maxSize(2 * 1024)
                    ->maxFiles(10)
                    ->image()
                    ->downloadable()
                    ->deletable()
                    ->columnSpanFull(),
                Forms\Components\Fieldset::make('Seo Meta')
                    ->schema([
                        Forms\Components\TextInput::make('meta_title')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('meta_description')
                            ->columnSpanFull(),
                        Forms\Components\TagsInput::make('meta_keywords')
                            ->columnSpanFull(),
                    ]),
                Forms\Components\Toggle::make('is_featured')
                    ->required(),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
                Forms\Components\Toggle::make('is_published')
                    ->required(),
            ]);
    } 

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->circular(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('category.title')
                    ->label('Category')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->boolean(),
                Tables\Columns\TextColumn::make('published_at')
                    ->since()
                    ->sortable(),
                Tables\Columns\TextColumn::make('author.name')
                    ->label('Author')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->toggleable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->toggleable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('view_count')
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
                SelectFilter::make('category')
                    ->preload()
                    ->multiple()
                    ->relationship('category', 'title', fn (Builder $query) => $query->where('type', 'post')),
                TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'title',
            'slug',
            'meta_title',
            'meta_description',
        ];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->title ?? $record->slug);
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Category' => optional($record->category)->title,
            'Status' => $record->is_published ? 'Published' : 'Draft',
        ];
    }

    public static function getGlobalSearchResultUrl(Model $record): string
    {
        return static::getUrl('edit', ['record' => $record]);
    }
}
