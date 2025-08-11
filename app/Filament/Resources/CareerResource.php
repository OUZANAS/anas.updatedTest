<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CareerResource\Pages;
use App\Filament\Resources\CareerResource\RelationManagers;
use App\Models\Career;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Get;
use Filament\Forms\Set;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use Illuminate\Support\Str;
use Filament\Forms\Components\Tabs;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;

class CareerResource extends Resource
{
    protected static ?string $model = Career::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                ->tabs([
                    Tabs\Tab::make('Basic Information')
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
                            Forms\Components\Select::make('parent_category')
                                ->label('Category')
                                ->options(function () {
                                    return \App\Models\Category::where('type', 'career')
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
                                ->label('Sub Category (Optional)')
                                ->options(function (Get $get) {
                                    $parentCategoryId = $get('parent_category');
                                    if (!$parentCategoryId) {
                                        return [];
                                    }
                                    
                                    return \App\Models\Category::where('type', 'career')
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
                                    
                                    return \App\Models\Category::where('type', 'career')
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
                            Forms\Components\RichEditor::make('excerpt')
                                ->columnSpanFull(),
                        ]),
                    Tabs\Tab::make('Content')
                        ->schema([
                            TinyEditor::make('content')
                                ->fileAttachmentsDisk('uploads')
                                ->fileAttachmentsDirectory('careers')
                                ->profile('full')
                                ->columnSpan('full')
                                ->required(),
                        ]),
                    Tabs\Tab::make('Media & Seo')
                        ->schema([
                            Forms\Components\FileUpload::make('featured_image')
                                ->disk('uploads')
                                ->directory('careers')
                                ->image(),
                            Forms\Components\FileUpload::make('company_logo')
                                ->disk('uploads')
                                ->directory('careers')
                                ->image(),
                            Forms\Components\Fieldset::make('Seo Meta')
                                ->schema([
                                    Forms\Components\TextInput::make('meta_title')
                                        ->columnSpanFull(),
                                    Forms\Components\Textarea::make('meta_description')
                                        ->columnSpanFull(),
                                    Forms\Components\TagsInput::make('meta_keywords')
                                        ->columnSpanFull(),
                                ]),
                        ]),
                    Tabs\Tab::make('Other Details')
                        ->schema([
                            Forms\Components\TextInput::make('company_name')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('company_website')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('location')
                                ->maxLength(255),
                            Forms\Components\Select::make('job_type_id')
                                ->relationship('jobType', 'title')
                                ->preload()
                                ->searchable()
                                ->required(),
                            Forms\Components\Toggle::make('is_featured')
                                ->required(),
                            Forms\Components\Toggle::make('is_active')
                                ->required(),
                            Forms\Components\TextInput::make('salary')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('application_email')
                                ->email()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('application_url')
                                ->maxLength(255)
                                 ->prefix('https://'),
                        ]),
                    Tabs\Tab::make('Contract Details')
                        ->schema([
                            Forms\Components\Select::make('city_id')
                                ->label('City')
                                ->relationship('city', 'title')
                                ->searchable()
                                ->preload(),
                            Forms\Components\TextInput::make('contract_type')
                                ->required(),
                            Forms\Components\RichEditor::make('missions')
                                ->columnSpanFull(),
                            Forms\Components\RichEditor::make('requirements')
                                ->columnSpanFull(),
                            Forms\Components\Select::make('payment_type')
                                ->required()
                                ->default('monthly')
                                ->options([
                                    'monthly' => 'Monthly',
                                    'hourly' => 'Hourly',
                                    'contract' => 'Contract',
                                ])  ,
                            Forms\Components\TextInput::make('salary_range')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('contract_duration')
                                ->maxLength(255),
                        ]),
                ])->columnSpanFull()
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ImageColumn::make('featured_image')
                    ->disk('uploads')
                    ->circular()
                    ->label('Featured Image'),
                Tables\Columns\TextColumn::make('company_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('company_website')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('company_logo')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('location')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('jobType.title')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('author.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('view_count')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('salary')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('application_email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('application_url')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('category.title')
                    ->label('Category')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('city.title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('contract_type')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('payment_type')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('salary_range')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('contract_duration')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                    ->relationship('category', 'title', fn (Builder $query) => $query->where('type', 'career')),
                SelectFilter::make('job_type')
                    ->preload()
                    ->multiple()
                    ->relationship('jobType', 'title'),
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
            'index' => Pages\ListCareers::route('/'),
            'create' => Pages\CreateCareer::route('/create'),
            'edit' => Pages\EditCareer::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'title',
            'slug',
            'company_name',
            'location',
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
            'Company' => (string) $record->company_name,
            'Job Type' => optional($record->jobType)->title,
        ];
    }

    public static function getGlobalSearchResultUrl(Model $record): string
    {
        return static::getUrl('edit', ['record' => $record]);
    }
}
