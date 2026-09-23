<?php

namespace App\Filament\Resources\Reviews\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Overview')
                    ->columns(2)
                    ->schema([
                        Select::make('casino_id')
                            ->relationship('casino', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('user_id')
                            ->label('Author')
                            ->relationship('author', 'name')
                            ->searchable()
                            ->preload(),
                        TextInput::make('title')
                            ->required()
                            ->live(onBlur: true)
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->afterStateUpdated(function (Set $set, Get $get, ?string $state) {
                                if (blank($get('slug'))) {
                                    $set('slug', Str::slug($state));
                                }
                            }),
                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Auto-generated from the title; edit if you need a custom URL slug.')
                            ->columnSpanFull(),
                        Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                                'archived' => 'Archived',
                            ])
                            ->required()
                            ->default('draft'),
                        DateTimePicker::make('published_at'),
                    ]),

                Section::make('Review')
                    ->schema([
                        RichEditor::make('body')
                            ->required()
                            ->columnSpanFull(),
                        TagsInput::make('pros')
                            ->placeholder('Add a point and press Enter'),
                        TagsInput::make('cons')
                            ->placeholder('Add a point and press Enter'),
                    ]),

                Section::make('Ratings')
                    ->description('Overall rating is calculated automatically as the average of these four.')
                    ->columns(4)
                    ->schema([
                        TextInput::make('rating_payout')
                            ->label('Payout speed')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(5)
                            ->step(0.1)
                            ->default(0)
                            ->required(),
                        TextInput::make('rating_games')
                            ->label('Game variety')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(5)
                            ->step(0.1)
                            ->default(0)
                            ->required(),
                        TextInput::make('rating_support')
                            ->label('Customer support')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(5)
                            ->step(0.1)
                            ->default(0)
                            ->required(),
                        TextInput::make('rating_bonuses')
                            ->label('Bonuses')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(5)
                            ->step(0.1)
                            ->default(0)
                            ->required(),
                    ]),

                Section::make('SEO')
                    ->description('Overrides for search engines and social sharing.')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        TextInput::make('meta_title')
                            ->maxLength(255),
                        TextInput::make('meta_description')
                            ->maxLength(500),
                        TextInput::make('canonical_url')
                            ->url()
                            ->maxLength(255),
                    ]),
            ]);
    }
}
