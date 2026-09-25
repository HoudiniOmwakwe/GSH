<?php

namespace App\Filament\Resources\ComparisonTables\Pages;

use App\Filament\Resources\ComparisonTables\ComparisonTableResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditComparisonTable extends EditRecord
{
    protected static string $resource = ComparisonTableResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
