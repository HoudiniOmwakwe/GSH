<?php

namespace App\Filament\Resources\Casinos;

use App\Filament\Resources\Casinos\Pages\CreateCasino;
use App\Filament\Resources\Casinos\Pages\EditCasino;
use App\Filament\Resources\Casinos\Pages\ListCasinos;
use App\Filament\Resources\Casinos\RelationManagers\ReviewsRelationManager;
use App\Filament\Resources\Casinos\Schemas\CasinoForm;
use App\Filament\Resources\Casinos\Tables\CasinosTable;
use App\Models\Casino;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CasinoResource extends Resource
{
    protected static ?string $model = Casino::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingStorefront;

    protected static string|UnitEnum|null $navigationGroup = 'Content';

    public static function form(Schema $schema): Schema
    {
        return CasinoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CasinosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ReviewsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCasinos::route('/'),
            'create' => CreateCasino::route('/create'),
            'edit' => EditCasino::route('/{record}/edit'),
        ];
    }
}
