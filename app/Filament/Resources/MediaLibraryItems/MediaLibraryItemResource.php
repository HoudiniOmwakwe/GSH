<?php

namespace App\Filament\Resources\MediaLibraryItems;

use App\Filament\Resources\MediaLibraryItems\Pages\ManageMediaLibraryItems;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Number;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use UnitEnum;

class MediaLibraryItemResource extends Resource
{
    protected static ?string $model = Media::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static ?string $navigationLabel = 'Media Library';

    protected static ?string $modelLabel = 'media item';

    protected static ?string $pluralModelLabel = 'Media Library';

    protected static ?string $recordTitleAttribute = 'file_name';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                    ->label('')
                    ->getStateUsing(fn (Media $record): string => $record->getUrl())
                    ->square(),
                TextColumn::make('file_name')
                    ->searchable()
                    ->weight('bold')
                    ->limit(40),
                TextColumn::make('model_type')
                    ->label('Attached to')
                    ->formatStateUsing(fn (string $state): string => class_basename($state))
                    ->badge(),
                TextColumn::make('collection_name')
                    ->label('Collection')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('size')
                    ->formatStateUsing(fn (int $state): string => Number::fileSize($state))
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Uploaded')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyState(fn () => view('filament.empty-states.no-records', [
                'heading' => 'No media uploaded yet',
                'description' => 'Files uploaded through casinos, reviews, and blog posts will appear here.',
            ]))
            ->filters([
                SelectFilter::make('collection_name')
                    ->label('Collection')
                    ->options(fn (): array => Media::query()
                        ->distinct()
                        ->pluck('collection_name', 'collection_name')
                        ->all()),
            ])
            ->recordActions([
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageMediaLibraryItems::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
