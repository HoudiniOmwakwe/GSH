<?php

namespace App\Filament\Resources\Casinos\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload as FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CasinoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Overview')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->live(onBlur: true)
                            ->maxLength(255),
                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Auto-generated from the name; edit if you need a custom URL slug.'),
                        Select::make('type')
                            ->options([
                                'casino' => 'Casino',
                                'sportsbook' => 'Sportsbook',
                                'crypto-exchange' => 'Crypto Exchange',
                            ])
                            ->required()
                            ->default('casino'),
                        Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                                'archived' => 'Archived',
                            ])
                            ->required()
                            ->default('draft'),
                        TextInput::make('license_info')
                            ->maxLength(255),
                        TextInput::make('established_year')
                            ->numeric()
                            ->minValue(1990)
                            ->maxValue((int) date('Y')),
                        TextInput::make('website_url')
                            ->url()
                            ->maxLength(255),
                        TextInput::make('affiliate_link')
                            ->url()
                            ->maxLength(255),
                        Toggle::make('is_featured'),
                        TextInput::make('ordering')
                            ->numeric()
                            ->default(0)
                            ->helperText('Lower numbers appear first.'),
                    ]),

                Section::make('Content')
                    ->schema([
                        Textarea::make('summary')
                            ->rows(2)
                            ->maxLength(500)
                            ->columnSpanFull(),
                        Textarea::make('bonus_summary')
                            ->rows(2)
                            ->maxLength(500)
                            ->columnSpanFull(),
                        RichEditor::make('description')
                            ->columnSpanFull(),
                    ]),

                Section::make('Media')
                    ->columns(2)
                    ->schema([
                        FileUpload::make('logo')
                            ->collection('logo')
                            ->image()
                            ->imageEditor(),
                        FileUpload::make('og_image')
                            ->collection('og_image')
                            ->image()
                            ->imageEditor()
                            ->label('Social share image'),
                    ]),

                Section::make('Payment Methods')
                    ->schema([
                        CheckboxList::make('paymentMethods')
                            ->relationship('paymentMethods', 'name')
                            ->columns(3)
                            ->columnSpanFull(),
                    ]),

                Section::make('SEO')
                    ->description('Overrides for search engines and social sharing.')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        TextInput::make('meta_title')
                            ->maxLength(255),
                        Textarea::make('meta_description')
                            ->rows(2)
                            ->maxLength(500),
                        TextInput::make('canonical_url')
                            ->url()
                            ->maxLength(255),
                    ]),
            ]);
    }
}
