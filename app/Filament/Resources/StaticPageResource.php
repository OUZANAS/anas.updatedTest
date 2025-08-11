<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StaticPageResource\Pages;
use App\Filament\Resources\StaticPageResource\RelationManagers;
use App\Models\StaticPage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StaticPageResource extends Resource
{
    protected static ?string $model = StaticPage::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    
    protected static ?string $navigationGroup = 'Settings';
    
    protected static ?string $navigationLabel = 'SEO & Static Pages';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Page Information')
                    ->schema([
                        Forms\Components\TextInput::make('page_name')
                            ->required()
                            ->label('Page Name')
                            ->placeholder('Home Page')
                            ->maxLength(255),
                            
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->placeholder('home')
                            ->helperText('Used in API requests (e.g., "home", "about", "contact")'),
                            
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('World Wide Progress - Home Page')
                            ->helperText('The page title (used by the browser)'),
                    ])->columns(2),
                    
                Forms\Components\Tabs::make('SEO Settings')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Basic SEO')
                            ->schema([
                                Forms\Components\TextInput::make('meta_title')
                                    ->maxLength(60)
                                    ->placeholder('World Wide Progress - Your Career Partner')
                                    ->helperText('Recommended length: 50-60 characters'),
                                    
                                Forms\Components\Textarea::make('meta_description')
                                    ->maxLength(160)
                                    ->placeholder('Find your dream job with World Wide Progress. We connect talented professionals with top employers worldwide.')
                                    ->helperText('Recommended length: 150-160 characters'),
                                    
                                Forms\Components\TagsInput::make('meta_keywords')
                                    ->placeholder('Add keywords')
                                    ->helperText('Add keywords separated by comma'),
                                    
                                Forms\Components\TextInput::make('canonical_url')
                                    ->url()
                                    ->placeholder('https://example.com/page')
                                    ->helperText('Leave empty to use the default URL'),
                            ]),
                            
                        Forms\Components\Tabs\Tab::make('Open Graph')
                            ->schema([
                                Forms\Components\TextInput::make('og_title')
                                    ->maxLength(100)
                                    ->placeholder('World Wide Progress - Find Your Career Path')
                                    ->helperText('Title for social media sharing'),
                                    
                                Forms\Components\Textarea::make('og_description')
                                    ->maxLength(200)
                                    ->placeholder('Discover thousands of career opportunities with top companies worldwide.')
                                    ->helperText('Description for social media sharing'),
                                    
                                Forms\Components\FileUpload::make('og_image')
                                    ->directory('seo/og-images')
                                    ->disk('uploads')
                                    ->visibility('public')
                                    ->image()
                                    ->helperText('Recommended size: 1200x630 pixels'),
                                    
                                Forms\Components\Select::make('og_type')
                                    ->options([
                                        'website' => 'Website',
                                        'article' => 'Article',
                                        'profile' => 'Profile',
                                    ])
                                    ->default('website'),
                            ]),
                            
                        Forms\Components\Tabs\Tab::make('Advanced')
                            ->schema([
                                Forms\Components\Toggle::make('index_page')
                                    ->label('Allow indexing')
                                    ->helperText('Enable to allow search engines to index this page')
                                    ->default(true),
                                    
                                Forms\Components\Toggle::make('follow_links')
                                    ->label('Follow links')
                                    ->helperText('Enable to allow search engines to follow links on this page')
                                    ->default(true),
                                    
                                Forms\Components\Textarea::make('structured_data')
                                    ->label('Structured Data (JSON-LD)')
                                    ->placeholder('{"@context": "https://schema.org", "@type": "Organization", ...}')
                                    ->helperText('JSON-LD structured data for rich snippets')
                                    ->columnSpanFull(),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('page_name')
                    ->label('Page')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('meta_title')
                    ->label('SEO Title')
                    ->searchable()
                    ->limit(30),
                    
                Tables\Columns\TextColumn::make('meta_description')
                    ->label('SEO Description')
                    ->searchable()
                    ->limit(50),
                    
                Tables\Columns\IconColumn::make('index_page')
                    ->label('Indexed')
                    ->boolean(),
                    
                Tables\Columns\IconColumn::make('follow_links')
                    ->label('Links Followed')
                    ->boolean(),
                    
                Tables\Columns\ImageColumn::make('og_image')
                    ->label('OG Image')
                    ->disk('uploads')
                    ->circular(),
                    
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime()
                    ->sortable(),
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
            'index' => Pages\ListStaticPages::route('/'),
            'create' => Pages\CreateStaticPage::route('/create'),
            'edit' => Pages\EditStaticPage::route('/{record}/edit'),
        ];
    }
    
    public static function getGloballySearchableAttributes(): array
    {
        return [
            'page_name',
            'title',
            'slug',
            'meta_title',
            'meta_description',
        ];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return (string) ($record->page_name ?? $record->title ?? $record->slug);
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Indexed' => $record->index_page ? 'Yes' : 'No',
            'Follow links' => $record->follow_links ? 'Yes' : 'No',
        ];
    }

    public static function getGlobalSearchResultUrl(Model $record): string
    {
        return static::getUrl('edit', ['record' => $record]);
    }
}
