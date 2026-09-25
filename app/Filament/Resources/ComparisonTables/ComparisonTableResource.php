<?php

namespace App\Filament\Resources\ComparisonTables;

use App\Filament\Resources\ComparisonTables\Pages\CreateComparisonTable;
use App\Filament\Resources\ComparisonTables\Pages\EditComparisonTable;
use App\Filament\Resources\ComparisonTables\Pages\ListComparisonTables;
use App\Filament\Resources\ComparisonTables\RelationManagers\CasinosRelationManager;
use App\Filament\Resources\ComparisonTables\Schemas\ComparisonTableForm;
use App\Filament\Resources\ComparisonTables\Tables\ComparisonTablesTable;
use App\Models\ComparisonTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ComparisonTableResource extends Resource
{
    protected static ?string $model = ComparisonTable::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTableCells;

    protected static string|UnitEnum|null $navigationGroup = 'Content';

    public static function form(Schema $schema): Schema
    {
        return ComparisonTableForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ComparisonTablesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            CasinosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListComparisonTables::route('/'),
            'create' => CreateComparisonTable::route('/create'),
            'edit' => EditComparisonTable::route('/{record}/edit'),
        ];
    }
}
