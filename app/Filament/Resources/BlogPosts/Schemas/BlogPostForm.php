<?php

namespace App\Filament\Resources\BlogPosts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload as FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BlogPostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Overview')
                    ->columns(2)
                    ->schema([
                        Select::make('blog_category_id')
                            ->label('Category')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload(),
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
                        Select::make('tags')
                            ->relationship('tags', 'name')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->columnSpanFull(),
                        Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                                'scheduled' => 'Scheduled',
                            ])
                            ->required()
                            ->default('draft'),
                        DateTimePicker::make('published_at'),
                    ]),

                Section::make('Content')
                    ->schema([
                        Textarea::make('excerpt')
                            ->rows(2)
                            ->maxLength(500)
                            ->columnSpanFull(),
                        RichEditor::make('body')
                            ->required()
                            ->columnSpanFull(),
                        FileUpload::make('featured_image')
                            ->collection('featured_image')
                            ->image()
                            ->imageEditor(),
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
